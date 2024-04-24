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
                    $this->checkUselessHeader($parent, $key, $definition, 'Content-Type', $output);
                    $this->checkMandatoryHeader($parent, $key, $definition, 'Accept', $output);
                    $this->checkAcceptHeaderAgainstBody($parent, $key, $definition, $output);
                    break;
                case 'post':
                    //$this->checkMandatoryHeader($parent, $key, $definition, 'Content-Type', $output);// POST may not have a payload like `POST /content/objects/{contentId}/hide`
                    //$this->checkMandatoryHeader($parent, $key, $definition, 'Accept', $output);// …and may return 204 No Content.
                    $this->checkAcceptHeaderAgainstBody($parent, $key, $definition, $output);
                    break;
                case 'patch':
                    $this->checkMandatoryHeader($parent, $key, $definition, 'Content-Type', $output);
                    $this->checkMandatoryHeader($parent, $key, $definition, 'Accept', $output);
                    $this->checkAcceptHeaderAgainstBody($parent, $key, $definition, $output);
                    break;
                case 'delete':
                    $this->checkUselessHeader($parent, $key, $definition, 'Content-Type', $output);
                    //$this->checkUselessHeader($parent, $key, $definition, 'Accept', $output);// Can return the updated "parent"/"container"/"list"
                    $this->checkAcceptHeaderAgainstBody($parent, $key, $definition, $output);
                    break;
            }
        }
    }

    private function checkUselessHeader($route, $method, $methodDefinition, $header, $output)
    {
        if (array_key_exists('headers', $methodDefinition) && array_key_exists($header, $methodDefinition['headers'])) {
            $output->writeln("$method $route doesn't need a '$header' header.");
        }
    }

    private function checkMandatoryHeader($route, $method, $methodDefinition, $header, $output)
    {
        if (!array_key_exists('headers', $methodDefinition) || !array_key_exists($header, $methodDefinition['headers'])) {
            $output->writeln("$method $route needs a '$header' header.");
        }
    }

    private function checkAcceptHeaderAgainstBody($route, $method, $methodDefinition, $output)
    {
        if (array_key_exists('headers', $methodDefinition)
            && array_key_exists('Accept', $methodDefinition['headers'])
            && array_key_exists('example', $methodDefinition['headers']['Accept'])
            && array_key_exists('body', $methodDefinition)) {
            $acceptedTypes = explode(PHP_EOL, trim($methodDefinition['headers']['Accept']['example']));
            $returnedTypes = array_keys($methodDefinition['body']);
            $missingAcceptedType = array_diff($returnedTypes, $acceptedTypes);
            $missingReturnedType = array_diff($acceptedTypes, $returnedTypes);
            if (!empty($missingAcceptedType) || !empty($missingReturnedType)) {
                $output->writeln("$method $route 'Accept' header and body doesn't contain the same types.");
                //dump($missingAcceptedType, $missingReturnedType);
            }
        }
    }
}
