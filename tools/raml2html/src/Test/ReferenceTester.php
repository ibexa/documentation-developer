<?php

namespace EzSystems\Raml2Html\Test;

use Symfony\Component\Console\Output\OutputInterface;

class ReferenceTester
{
    public const TEST_REFERENCE_ROUTES = 1;
    public const TEST_CONFIG_ROUTES = 2;
    public const TEST_ALL_ROUTES = 3;

    public const DEFAULT_FILE_LIST = [
        'vendor/ibexa/rest/src/bundle/Resources/config/routing.yml',
        'vendor/ibexa/commerce-rest/src/bundle/Resources/config/routing.yaml',
        // `find $dxpRoot/vendor/ibexa -name "routing_rest.y*ml"`
        //'vendor/ibexa/admin-ui/src/bundle/Resources/config/routing_rest.yaml',
        'vendor/ibexa/calendar/src/bundle/Resources/config/routing_rest.yaml',
        'vendor/ibexa/connector-dam/src/bundle/Resources/config/routing_rest.yaml',
        'vendor/ibexa/personalization/src/bundle/Resources/config/routing_rest.yaml',
        'vendor/ibexa/product-catalog/src/bundle/Resources/config/routing_rest.yaml',
        //'vendor/ibexa/scheduler/src/bundle/Resources/config/routing_rest.yaml', // prefixed /api/datebasedpublisher/v1
        'vendor/ibexa/taxonomy/src/bundle/Resources/config/routing_rest.yaml',
    ];

    public const METHOD_LIST = [
        'OPTIONS',
        'GET',
        'HEAD',
        'POST',
        'PATCH',
        'COPY',
        'MOVE',
        'SWAP',
        'PUBLISH',
        'DELETE',
    ];

    public $apiUri = '/api/ibexa/v2';

    private const REF_METHOD_NOT_IN_CONF = 'ref_route_method_missing_from_conf';
    private const CONF_METHOD_NOT_IN_REF = 'conf_route_method_missing_from_ref';

    private $restApiReference;
    private $dxpRoot;

    private $refRoutes;
    private $confRoutes;

    /** @var OutputInterface */
    private $output;

    public function __construct($restApiReference, $dxpRoot, $consolePath = 'bin/console', $routingFiles = null, OutputInterface $output = null)
    {
        if (!is_file($restApiReference)) {
            user_error("$restApiReference doesn't exist or is not a file", E_USER_ERROR);
            exit(1);
        }
        if ('~' === $dxpRoot[0]) {
            $dxpRoot = trim(shell_exec("echo $dxpRoot"));
        }
        if (!is_dir($dxpRoot)) {
            user_error("$dxpRoot doesn't exist or is not a directory", E_USER_ERROR);
            exit(2);
        }

        $this->output = $output;

        $this->restApiReference = $restApiReference;
        $this->dxpRoot = $dxpRoot;
        $this->parseApiReference($this->restApiReference);
        $this->parseRoutes($consolePath, $routingFiles);
    }

    private function parseApiReference($restApiReference): void
    {
        $refRoutes = [];

        $restApiRefDoc = new \DOMDocument();
        $restApiRefDoc->loadHTMLFile($restApiReference, LIBXML_NOERROR);
        $restApiRefXpath = new \DOMXpath($restApiRefDoc);

        /** @var DOMElement $urlElement */
        foreach ($restApiRefXpath->query('//*[@data-field="url"]') as $urlElement) {
            if (!array_key_exists($urlElement->nodeValue, $refRoutes)) {
                $refRoutes[$urlElement->nodeValue] = [
                    'methods' => [],
                ];
            }
            $refRoutes[$urlElement->nodeValue]['methods'][$urlElement->previousSibling->previousSibling->nodeValue] = true;
        }

        $this->refRoutes = $refRoutes;
        ksort($this->refRoutes);
    }

    private function parseRoutes($consolePath = 'bin/console', $routingFiles = null)
    {
        if (is_string($consolePath)) {
            $this->parseRouterOutput($consolePath);
        } elseif (is_array($routingFiles)) {
            $this->parseRoutingFiles($routingFiles);
        } elseif (is_string($routingFiles)) {
            $this->parseRoutingFiles([$routingFiles]);
        } else {
            $this->parseRoutingFiles(self::DEFAULT_FILE_LIST);
        }
        ksort($this->confRoutes);
    }

    private function parseRouterOutput($consolePath)
    {
        $confRoutes = [];

        $routerCommand = 'debug:router --format=txt';
        $consolePathLastChar = substr($consolePath, -1);
        if (in_array($consolePathLastChar, ['"', "'"])) {
            $consoleCommand = substr($consolePath, 0, -1) . " {$routerCommand}{$consolePathLastChar}";
        } else {
            $consoleCommand = "$consolePath $routerCommand";
        }

        $routerOutput = shell_exec("cd {$this->dxpRoot} && $consoleCommand | grep '{$this->apiUri}'");

        foreach (explode("\n", $routerOutput) as $outputLine) {
            $outputLine = trim($outputLine);
            if (empty($outputLine)) {
                continue;
            }
            $lineParts = preg_split('/\s+/', $outputLine);
            $routeId = $lineParts[0];
            $methods = explode('|', $lineParts[1]);
            foreach ($methods as $method) {
                if ('OPTIONS' === $method) {
                    continue;
                }
                $routePath = str_replace($this->apiUri, '', $lineParts[4]);
                if (!array_key_exists($routePath, $confRoutes)) {
                    $confRoutes[$routePath] = ['methods' => []];
                }
                $confRoutes[$routePath]['methods'][$method] = [
                    'id' => $routeId,
                    'file' => null,
                    'line' => null,
                ];
            }
        }

        $this->confRoutes = $confRoutes;
    }

    private function parseRoutingFiles($routingFiles): void
    {
        $confRoutes = [];

        $parsedRoutingFiles = [];
        foreach ($routingFiles as $routingFile) {
            $routingFilePath = "{$this->dxpRoot}/$routingFile";
            if (!is_file($routingFilePath)) {
                user_error("$routingFilePath doesn't exist or is not a file", E_USER_WARNING);
                continue;
            }
            $parsedRoutingFiles[$routingFile] = yaml_parse_file($routingFilePath);
        }

        foreach ($parsedRoutingFiles as $routingFile => $parsedRoutingFile) {
            foreach ($parsedRoutingFile as $routeId => $routeDef) {
                $line = (int)explode(':', `grep -n '^$routeId:$' {$this->dxpRoot}/$routingFile`)[0];
                if (!array_key_exists('methods', $routeDef)) {
                    $routeDef['methods'] = self::METHOD_LIST;
                }
                if (!array_key_exists($routeDef['path'], $confRoutes)) {
                    $confRoutes[$routeDef['path']] = [
                        'methods' => [],
                    ];
                }
                foreach ($routeDef['methods'] as $method) {
                    $confRoutes[$routeDef['path']]['methods'][$method] = [
                        'id' => $routeId,
                        'file' => $routingFile,
                        'line' => $line,
                    ];
                }
            }
        }

        $this->confRoutes = $confRoutes;
    }

    public function run(int $testedRoutes = self::TEST_ALL_ROUTES)
    {
        $refRoutes = $this->refRoutes;
        $confRoutes = $this->confRoutes;

        // Check methods from routes found in both reference and configuration
        foreach (array_intersect(array_keys($refRoutes), array_keys($confRoutes)) as $commonRoute) {
            $missingMethods = $this->compareMethods($commonRoute, $commonRoute, $testedRoutes);
            if (!array_key_exists('GET', $refRoutes[$commonRoute]['methods']) && array_key_exists('HEAD', $refRoutes[$commonRoute]['methods'])
                && array_key_exists('GET', $confRoutes[$commonRoute]['methods']) && array_key_exists('HEAD', $confRoutes[$commonRoute]['methods'])
                && !is_null($confRoutes[$commonRoute]['methods']['HEAD']['id']) && $confRoutes[$commonRoute]['methods']['GET']['id'] === $confRoutes[$commonRoute]['methods']['HEAD']['id']) {
                $this->output("\t$commonRoute has no GET reference but has a HEAD reference, HEAD and GET share the same configuration route id ({$confRoutes[$commonRoute]['methods']['GET']['id']}) so GET might be just a fallback for HEAD.");
            }
            if (false !== strpos($commonRoute, '{')) {
                if (self::TEST_REFERENCE_ROUTES & $testedRoutes && $missingMethods[self::REF_METHOD_NOT_IN_CONF]) {
                    // Check reference route's methods not found in the configuration against similar routes from configuration
                    $similarConfRoutes = $this->getSimilarRoutes($commonRoute, $confRoutes);
                    foreach (['highly', 'poorly'] as $similarityLevel) {
                        foreach ($similarConfRoutes[$similarityLevel] as $confRoute) {
                            if ($confRoute === $commonRoute) {
                                continue;
                            }
                            $stillMissingMethod = $this->compareMethods($commonRoute, $confRoute, self::TEST_REFERENCE_ROUTES, $missingMethods[self::REF_METHOD_NOT_IN_CONF]);
                            $foundMethods = array_diff($missingMethods[self::REF_METHOD_NOT_IN_CONF], $stillMissingMethod[self::REF_METHOD_NOT_IN_CONF]);
                            if (!empty($foundMethods)) {
                                foreach ($foundMethods as $foundMethod) {
                                    if ('highly' === $similarityLevel) {
                                        $this->output("\t{$this->getConfRoutePrompt($confRoute)} has $foundMethod and is highly similar to $commonRoute");
                                    } else {
                                        $this->output("\t{$this->getConfRoutePrompt($confRoute)} has $foundMethod and is a bit similar to $commonRoute");
                                    }
                                }
                            }
                        }
                    }
                }
                if (self::TEST_CONFIG_ROUTES & $testedRoutes) {
                    // Check configuration route's methods not found in the reference against similar routes from reference
                    $similarRefRoutes = $this->getSimilarRoutes($commonRoute, $refRoutes);
                    foreach (['highly', 'poorly'] as $similarityLevel) {
                        foreach ($similarRefRoutes[$similarityLevel] as $refRoute) {
                            if ($refRoute === $commonRoute) {
                                continue;
                            }
                            $stillMissingMethod = $this->compareMethods($refRoute, $commonRoute, self::TEST_CONFIG_ROUTES, $missingMethods[self::CONF_METHOD_NOT_IN_REF]);
                            $foundMethods = array_diff($missingMethods[self::CONF_METHOD_NOT_IN_REF], $stillMissingMethod[self::CONF_METHOD_NOT_IN_REF]);
                            if (!empty($foundMethods)) {
                                foreach ($foundMethods as $foundMethod) {
                                    if ('highly' === $similarityLevel) {
                                        $this->output("\t$refRoute has $foundMethod and is highly similar to $commonRoute");
                                    } else {
                                        $this->output("\t$refRoute has $foundMethod and is a bit similar to $commonRoute");
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if (self::TEST_REFERENCE_ROUTES & $testedRoutes) {
            // Check reference routes not found in the configuration
            foreach (array_diff(array_keys($refRoutes), array_keys($confRoutes)) as $refRouteWithoutConf) {
                $this->output("$refRouteWithoutConf not found in config files.");
                if (false !== strpos($refRouteWithoutConf, '{')) {
                    $similarConfRoutes = $this->getSimilarRoutes($refRouteWithoutConf, $confRoutes);
                    if (!empty($similarConfRoutes['highly'])) {
                        foreach ($similarConfRoutes['highly'] as $confRoute) {
                            $this->output("\t$refRouteWithoutConf is highly similar to $confRoute");
                            $this->compareMethods($refRouteWithoutConf, $confRoute, self::TEST_REFERENCE_ROUTES);
                        }
                        continue;
                    }
                    if (!empty($similarConfRoutes['poorly'])) {
                        foreach ($similarConfRoutes['poorly'] as $confRoute) {
                            $this->output("\t$refRouteWithoutConf is a bit similar to $confRoute");
                            $this->compareMethods($refRouteWithoutConf, $confRoute, self::TEST_REFERENCE_ROUTES);
                        }
                    }
                }
            }
        }

        if (self::TEST_CONFIG_ROUTES & $testedRoutes) {
            // Check configuration routes not found in the reference
            foreach (array_diff(array_keys($confRoutes), array_keys($refRoutes)) as $confRouteWithoutRef) {
                $this->output("{$this->getConfRoutePrompt($confRouteWithoutRef)} not found in reference.");
                if (false !== strpos($confRouteWithoutRef, '{')) {
                    $similarRefRoutes = $this->getSimilarRoutes($confRouteWithoutRef, $refRoutes);
                    if (!empty($similarRefRoutes['highly'])) {
                        foreach ($similarRefRoutes['highly'] as $refRoute) {
                            $this->output("\t$confRouteWithoutRef is highly similar to $refRoute");
                            $this->compareMethods($refRoute, $confRouteWithoutRef, self::TEST_CONFIG_ROUTES);
                        }
                        continue;
                    }
                    if (!empty($similarRefRoutes['poorly'])) {
                        foreach ($similarRefRoutes['poorly'] as $refRoute) {
                            $this->output("\t$confRouteWithoutRef is a bit similar to $refRoute");
                            $this->compareMethods($refRoute, $confRouteWithoutRef, self::TEST_CONFIG_ROUTES);
                        }
                    }
                }
            }
        }
    }

    /**
     * Compare reference route methods and configuration route methods, output methods missing on one side or the other.
     * @param array|null $testedMethods A list of methods to search for and compare; if null, all existing methods are compared
     * @return array A list of missing methods
     */
    private
    function compareMethods(string $refRoute, string $confRoute, int $testedRoutes = self::TEST_ALL_ROUTES, ?array $testedMethods = null): array
    {
        $refRoutes = $this->refRoutes;
        $confRoutes = $this->confRoutes;
        $missingMethods = [
            self::REF_METHOD_NOT_IN_CONF => [],
            self::CONF_METHOD_NOT_IN_REF => [],

        ];

        if (self::TEST_REFERENCE_ROUTES & $testedRoutes) {
            // Check reference route's methods missing from configuration route
            foreach (array_diff(array_keys($refRoutes[$refRoute]['methods']), array_keys($confRoutes[$confRoute]['methods'])) as $refMethodWithoutConf) {
                if (null === $testedMethods || in_array($refMethodWithoutConf, $testedMethods)) {
                    if ($refRoute === $confRoute) {
                        $this->output("$refRoute: $refMethodWithoutConf not found in configuration.");
                    } else {
                        $this->output("\t$refMethodWithoutConf not found in configuration while comparing to $confRoute.");
                    }
                    $missingMethods[self::REF_METHOD_NOT_IN_CONF][] = $refMethodWithoutConf;
                }
            }
        }

        if (self::TEST_CONFIG_ROUTES & $testedRoutes) {
            // Check configuration route's methods missing from reference route
            foreach (array_diff(array_keys($confRoutes[$confRoute]['methods']), array_keys($refRoutes[$refRoute]['methods'])) as $confMethodWithoutRef) {
                if (null === $testedMethods || in_array($confMethodWithoutRef, $testedMethods)) {
                    if ($refRoute === $confRoute) {
                        $this->output("{$this->getConfRoutePrompt($confRoute, $confMethodWithoutRef)}: $confMethodWithoutRef not found in reference.");
                    } else {
                        $this->output("\t$confMethodWithoutRef not found in reference while comparing to $refRoute.");
                    }
                    $missingMethods[self::CONF_METHOD_NOT_IN_REF][] = $confMethodWithoutRef;
                }
            }
        }

        return $missingMethods;
    }

    private
    function getSimilarRoutes(string $path, array $routeCollection): array
    {
        $routePattern = $this->getRoutePattern($path);
        $highlySimilarRoutes = [];
        $poorlySimilarRoutes = [];
        foreach (array_keys($routeCollection) as $route) {
            if (preg_match($routePattern, $route)) {
                if ($this->getSimplifiedRoute($route) === $this->getSimplifiedRoute($path)) {
                    $highlySimilarRoutes[] = $route;
                } else {
                    $poorlySimilarRoutes[] = $route;
                }
            }
        }
        return [
            'highly' => $highlySimilarRoutes,
            'poorly' => $poorlySimilarRoutes,
        ];
    }

    private
    function getSimplifiedRoute(string $path): string
    {
        return str_replace(['identifier', 'number', '_', '-'], ['id', 'no', ''], strtolower($path));
    }

    private
    function getRoutePattern(string $path): string
    {
        return '@^' . preg_replace('@\{[^}]+\}@', '\{[^}]+\}', $path) . '$@';
    }

    private
    function getConfRoutePrompt(string $path, $method = null): string
    {
        $prompt = $path;

        if (array_key_exists($path, $this->confRoutes)) {
            if ($method && array_key_exists($method, $this->confRoutes[$path]['methods'])) {
                if (array_key_exists('file', $this->confRoutes[$path]['methods'][$method]) && !is_null($this->confRoutes[$path]['methods'][$method]['file'])) {
                    $location = $this->confRoutes[$path]['methods'][$method]['file'];
                    if (array_key_exists('line', $this->confRoutes[$path]['methods'][$method]) && !is_null($this->confRoutes[$path]['methods'][$method]['line'])) {
                        $location .= "@{$this->confRoutes[$path]['methods'][$method]['line']}";
                    }
                    $prompt = "$prompt ($location)";
                }
            } else {
                $files = [];
                $lines = [];
                $pairs = [];
                foreach ($this->confRoutes[$path]['methods'] as $methodDetail) {
                    if (array_key_exists('file', $methodDetail) && !is_null($methodDetail['file'])) {
                        $files[] = $methodDetail['file'];
                        if (array_key_exists('line', $methodDetail) && !is_null($methodDetail['line'])) {
                            $lines[] = $methodDetail['line'];
                            $pairs[] = "{$methodDetail['file']}@{$methodDetail['line']}";
                        } else {
                            $pairs[] = $methodDetail['file'];
                        }
                    }
                }
                $filteredFiles = array_unique($files);
                if (!empty($filteredFiles)) {
                    if (1 < count($filteredFiles)) {
                        $pairs = implode(',', array_unique($pairs));
                        $prompt = "$prompt ($pairs)";
                    } else {
                        $file = $filteredFiles[0];
                        $lines = implode(',', array_unique($lines));
                        $prompt = "$prompt ($file@$lines)";
                    }
                }
            }
        }

        return $prompt;
    }

    private
    function output($message)
    {
        if ($this->output) {
            $this->output->writeln($message);
        } else {
            echo strip_tags($message) . "\n";
        }
    }
}
