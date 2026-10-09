<?php

declare(strict_types=1);

namespace EzSystems\Raml2Html\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class TestLogicCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setName('test:logic')
            ->setDescription('Check REST logic in RAML files')
            ->addArgument('raml-input-dir', InputArgument::OPTIONAL, 'Path to the REST API Reference\'s RAML input directory', 'docs/api/rest_api/rest_api_reference/input')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dir = $input->getArgument('raml-input-dir');
        $files = shell_exec("find $dir -type f -name '*.raml'");
        if (!empty($files)) {
            foreach (explode(PHP_EOL, trim($files)) as $file) {
                $output->writeln("<info>$file</info>");
                $definitions = yaml_parse_file($file);
                if (is_array($definitions)) {
                    $this->checkDefinitions($file, yaml_parse_file($file), $output);
                }
            }
        }

        return Command::SUCCESS;
    }

    private function checkDefinitions(string $parent, array $definitions, OutputInterface $output)
    {
        foreach ($definitions as $key => $definition) {
            if ('/' === $key[0]) { // $key is a route
                if (is_array($definition)) {
                    $this->checkDefinitions($key, $definition, $output);
                }
            }
            switch ($key) { // $key is a method
                case 'get':
                    $this->checkUselessRequestHeader($parent, $key, $definition, 'Content-Type', $output);// Used in rare case of GET with a body…
                    $this->checkUselessRequestBody($parent, $key, $definition, $output);// …
                    $this->checkMandatoryRequestHeader($parent, $key, $definition, 'Accept', $output);
                    $this->checkAcceptHeaderAgainstResponseBody($parent, $key, $definition, $output);
                    break;
                case 'post':
                    //$this->checkMandatoryHeader($parent, $key, $definition, 'Content-Type', $output);// POST may not have a payload like `POST /content/objects/{contentId}/hide`
                    //$this->checkUselessRequestBody($parent, $key, $definition, $output);// …
                    //$this->checkMandatoryHeader($parent, $key, $definition, 'Accept', $output);// …and may return 204 No Content.
                    $this->checkAcceptHeaderAgainstResponseBody($parent, $key, $definition, $output);
                    $this->checkContentTypeHeaderAgainstRequestBody($parent, $key, $definition, $output);
                    break;
                case 'patch':
                    $this->checkMandatoryRequestHeader($parent, $key, $definition, 'Content-Type', $output);
                    $this->checkMandatoryRequestBody($parent, $key, $definition, $output);
                    $this->checkMandatoryRequestHeader($parent, $key, $definition, 'Accept', $output);
                    $this->checkAcceptHeaderAgainstResponseBody($parent, $key, $definition, $output);
                    $this->checkContentTypeHeaderAgainstRequestBody($parent, $key, $definition, $output);
                    break;
                case 'delete':
                    //$this->checkUselessRequestHeader($parent, $key, $definition, 'Content-Type', $output);// Can need a payload to precise what to delete
                    //$this->checkUselessRequestBody($parent, $key, $definition, $output);// …
                    //$this->checkUselessHeader($parent, $key, $definition, 'Accept', $output);// Can return the updated "parent"/"container"/"list"
                    $this->checkAcceptHeaderAgainstResponseBody($parent, $key, $definition, $output);
                    $this->checkContentTypeHeaderAgainstRequestBody($parent, $key, $definition, $output);
                    break;
            }
        }
    }

    private function checkUselessRequestHeader($route, $method, $methodDefinition, $header, $output)
    {
        if (array_key_exists('headers', $methodDefinition) && array_key_exists($header, $methodDefinition['headers'])) {
            $output->writeln("$method $route may not need a '$header' request header.");
        }
    }

    private function checkMandatoryRequestHeader($route, $method, $methodDefinition, $header, $output)
    {
        if (!array_key_exists('headers', $methodDefinition) || !array_key_exists($header, $methodDefinition['headers'])) {
            if ('Accept' === $header && array_key_exists('responses', $methodDefinition)) {
                if (!array_key_exists('200', array_keys($methodDefinition['responses'])) && empty(array_intersect(['301', '307'], array_keys($methodDefinition['responses'])))) {
                    // No need for an Accept header when expecting a redirection, right?
                    $output->writeln("$method $route needs a '$header' request header.");
                }
            } else {
                $output->writeln("$method $route needs a '$header' request header.");
            }
        }
    }

    private function checkUselessRequestBody($route, $method, $methodDefinition, $output)
    {
        if (array_key_exists('body', $methodDefinition)) {
            $output->writeln("$method $route may not need a request body.");
        }
    }

    private function checkMandatoryRequestBody($route, $method, $methodDefinition, $output)
    {
        if (!array_key_exists('body', $methodDefinition)) {
            $output->writeln("$method $route needs a request body.");
        }
    }

    private function checkAcceptHeaderAgainstResponseBody($route, $method, $methodDefinition, $output)
    {
        if (array_key_exists('headers', $methodDefinition)
            && array_key_exists('Accept', $methodDefinition['headers'])
            && array_key_exists('example', $methodDefinition['headers']['Accept'])
            && array_key_exists('responses', $methodDefinition)
        ) {
            if (array_key_exists('200', $methodDefinition['responses'])) {
                if (array_key_exists('body', $methodDefinition['responses']['200'])) {
                    $acceptedTypes = explode(PHP_EOL, trim($methodDefinition['headers']['Accept']['example']));
                    $returnedTypes = array_keys($methodDefinition['responses']['200']['body']);
                    $missingAcceptedType = array_diff($returnedTypes, $acceptedTypes);
                    $missingReturnedType = array_diff($acceptedTypes, $returnedTypes);
                    if (!empty($missingAcceptedType) || !empty($missingReturnedType)) {
                        $output->writeln("$method $route 'Accept' header and body doesn't contain the same types.");
                        if (!empty($missingAcceptedType)) {
                            $output->writeln("\tThe following are returned but not accepted: ".implode(', ', $missingAcceptedType));
                        }
                        if (!empty($missingReturnedType)) {
                            $output->writeln("\tThe following are accepted but not returned: ".implode(', ', $missingReturnedType));
                        }
                    }
                }
            } else if (array_key_exists('204', $methodDefinition['responses'])) {
                //Accept header can be used to indicate the format to use in case of returning an error
                $output->writeln("$method $route may not need an 'Accept' header as it responses with an HTTP code meaning an empty body.");
            }
        }
    }

    private function checkContentTypeHeaderAgainstRequestBody($route, $method, $methodDefinition, $output)
    {
        if (array_key_exists('headers', $methodDefinition)
            && array_key_exists('Content-Type', $methodDefinition['headers'])
            && array_key_exists('example', $methodDefinition['headers']['Content-Type'])
            && array_key_exists('body', $methodDefinition)) {
            $saidTypes = explode(PHP_EOL, trim($methodDefinition['headers']['Content-Type']['example']));
            $bodyTypes = array_keys($methodDefinition['body']);
            $missingSaidType = array_diff($bodyTypes, $saidTypes);
            $missingBodyType = array_diff($saidTypes, $bodyTypes);
            if (!empty($missingSaidType) || !empty($missingBodyType)) {
                $output->writeln("$method $route 'Content-Type' header and request body doesn't contain the same types.");
                if (!empty($missingSaidType)) {
                    $output->writeln("\tThe following are sent as request body but are not available as Content-Type: ".implode(', ', $missingSaidType));
                }
                if (!empty($missingBodyType)) {
                    $output->writeln("\tThe following can be declared in Content-Type but aren't used in request body: ".implode(', ', $missingBodyType));
                }
            }
        }
    }
}
