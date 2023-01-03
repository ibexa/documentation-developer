<?php

namespace EzSystems\Raml2Html\Test;

class ReferenceTester
{
    const TEST_REFERENCE_ROUTES = 1;
    const TEST_CONFIG_ROUTES = 2;
    const TEST_ALL_ROUTES = 3;

    const DEFAULT_FILE_LIST = [
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

    private $apiUri = '/api/ibexa/v2';

    private $restApiReference;
    private $dxpRoot;

    private $refRoutes;
    private $confRoutes;

    public function __construct($restApiReference, $dxpRoot, $consolePath = 'bin/console', $routingFiles = null)
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
                    user_error("$routeId ($routingFile@$line) matches every methods by default; skipped", E_USER_WARNING);
                    continue;
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

        foreach (array_intersect(array_keys($refRoutes), array_keys($confRoutes)) as $commonRoute) {
            $missingMethods = $this->compareMethods($commonRoute, $commonRoute, $testedRoutes);
            if (!array_key_exists('GET', $refRoutes[$commonRoute]['methods']) && array_key_exists('HEAD', $refRoutes[$commonRoute]['methods'])
                && array_key_exists('GET', $confRoutes[$commonRoute]['methods']) && array_key_exists('HEAD', $confRoutes[$commonRoute]['methods'])
                && !is_null($confRoutes[$commonRoute]['methods']['HEAD']['id']) && $confRoutes[$commonRoute]['methods']['GET']['id'] === $confRoutes[$commonRoute]['methods']['HEAD']['id']) {
                echo "\t$commonRoute has no GET reference but has a HEAD reference, HEAD and GET share the same route id ({$confRoutes[$commonRoute]['methods']['GET']['id']}) so GET might be just a fallback for HEAD.\n";
            }
            if ($missingMethods && false !== strpos($commonRoute, '{')) {
                $similarRefRoutes = $this->getSimilarRoutes($commonRoute, $refRoutes);
                $similarConfRoutes = $this->getSimilarRoutes($commonRoute, $confRoutes);
                foreach (['highly', 'poorly'] as $similarityLevel) {
                    foreach ($similarRefRoutes[$similarityLevel] as $refRoute) {
                        if ($refRoute === $commonRoute) {
                            continue;
                        }
                        $stillMissingMethod = $this->compareMethods($refRoute, $commonRoute, $testedRoutes, $missingMethods);
                        $foundMethods = array_diff($missingMethods, $stillMissingMethod);
                        if (!empty($foundMethods)) {
                            foreach ($foundMethods as $foundMethod) {
                                if ('highly' === $similarityLevel) {
                                    echo "\t$refRoute has $foundMethod and is highly similar to $commonRoute\n";
                                } else {
                                    echo "\t$refRoute has $foundMethod and is a bit similar to $commonRoute\n";
                                }
                            }
                        }
                    }
                    foreach ($similarConfRoutes[$similarityLevel] as $confRoute) {
                        if ($confRoute === $commonRoute) {
                            continue;
                        }
                        $stillMissingMethod = $this->compareMethods($commonRoute, $confRoute, $testedRoutes, $missingMethods);
                        $foundMethods = array_diff($missingMethods, $stillMissingMethod);
                        if (!empty($foundMethods)) {
                            foreach ($foundMethods as $foundMethod) {
                                if ('highly' === $similarityLevel) {
                                    echo "\t{$this->getConfRoutePrompt($confRoute)} has $foundMethod and is highly similar to $commonRoute\n";
                                } else {
                                    echo "\t{$this->getConfRoutePrompt($confRoute)} has $foundMethod and is a bit similar to $commonRoute\n";
                                }
                            }
                        }
                    }
                }
            }
        }

        if (self::TEST_REFERENCE_ROUTES & $testedRoutes) {
            foreach (array_diff(array_keys($refRoutes), array_keys($confRoutes)) as $refRouteWithoutConf) {
                if (false !== strpos($refRouteWithoutConf, '{')) {
                    $similarConfRoutes = $this->getSimilarRoutes($refRouteWithoutConf, $confRoutes);
                    if (!empty($similarConfRoutes['highly'])) {
                        echo "$refRouteWithoutConf not found in config files but\n";
                        foreach ($similarConfRoutes['highly'] as $confRoute) {
                            echo "\t$refRouteWithoutConf is highly similar to $confRoute\n";
                            $this->compareMethods($refRouteWithoutConf, $confRoute, $testedRoutes);
                        }
                        continue;
                    }
                    if (!empty($similarConfRoutes['poorly'])) {
                        echo "$refRouteWithoutConf not found in config files but\n";
                        foreach ($similarConfRoutes['poorly'] as $confRoute) {
                            echo "\t$refRouteWithoutConf is a bit similar to $confRoute\n";
                            $this->compareMethods($refRouteWithoutConf, $confRoute, $testedRoutes);
                        }
                        continue;
                    }
                }
                echo "$refRouteWithoutConf not found in config files.\n";
            }
        }

        if (self::TEST_CONFIG_ROUTES & $testedRoutes) {
            foreach (array_diff(array_keys($confRoutes), array_keys($refRoutes)) as $confRouteWithoutRef) {
                if (false !== strpos($confRouteWithoutRef, '{')) {
                    $similarRefRoutes = $this->getSimilarRoutes($confRouteWithoutRef, $refRoutes);
                    if (!empty($similarRefRoutes['highly'])) {
                        echo "{$this->getConfRoutePrompt($confRouteWithoutRef)} not found in reference but\n";
                        foreach ($similarRefRoutes['highly'] as $refRoute) {
                            echo "\t$confRouteWithoutRef is highly similar to $refRoute\n";
                            $this->compareMethods($refRoute, $confRouteWithoutRef, $testedRoutes);
                        }
                        continue;
                    }
                    if (!empty($similarRefRoutes['poorly'])) {
                        echo "{$this->getConfRoutePrompt($confRouteWithoutRef)} not found in reference but\n";
                        foreach ($similarRefRoutes['poorly'] as $refRoute) {
                            echo "\t$confRouteWithoutRef is a bit similar to $refRoute\n";
                            $this->compareMethods($refRoute, $confRouteWithoutRef, $testedRoutes);
                        }
                        continue;
                    }
                }
                echo "{$this->getConfRoutePrompt($confRouteWithoutRef)} not found in reference.\n";
            }
        }
    }

    private function compareMethods(string $refRoute, string $confRoute, int $testedRoutes = self::TEST_ALL_ROUTES, ?array $testedMethods = null): array
    {
        $refRoutes = $this->refRoutes;
        $confRoutes = $this->confRoutes;
        $missingMethods = [];

        if (self::TEST_REFERENCE_ROUTES & $testedRoutes) {
            foreach (array_diff(array_keys($refRoutes[$refRoute]['methods']), array_keys($confRoutes[$confRoute]['methods'])) as $refMethodWithoutConf) {
                if (null === $testedMethods || in_array($refMethodWithoutConf, $testedMethods)) {
                    echo "$refRoute: $refMethodWithoutConf method not found in conf files" . ($refRoute === $confRoute ? '' : " (while comparing to $confRoute)") . ".\n";
                    $missingMethods[] = $refMethodWithoutConf;
                }
            }
        }

        if (self::TEST_CONFIG_ROUTES & $testedRoutes) {
            foreach (array_diff(array_keys($confRoutes[$confRoute]['methods']), array_keys($refRoutes[$refRoute]['methods'])) as $confMethodWithoutRef) {
                if (null === $testedMethods || in_array($confMethodWithoutRef, $testedMethods)) {
                    echo "{$this->getConfRoutePrompt($confRoute, $confMethodWithoutRef)}: $confMethodWithoutRef not found in reference" . ($refRoute === $confRoute ? '' : " (while comparing to $refRoute)") . ".\n";
                    $missingMethods[] = $confMethodWithoutRef;
                }
            }
        }

        return $missingMethods;
    }

    private function getSimilarRoutes(string $path, array $routeCollection): array
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

    private function getSimplifiedRoute(string $path): string
    {
        return str_replace(['identifier', 'number', '_', '-'], ['id', 'no', ''], strtolower($path));
    }

    private function getRoutePattern(string $path): string
    {
        return '@^' . preg_replace('@\{[^}]+\}@', '\{[^}]+\}', $path) . '$@';
    }

    private function getConfRoutePrompt(string $path, $method = null): string
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
}
