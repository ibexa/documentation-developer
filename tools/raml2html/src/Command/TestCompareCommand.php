<?php

declare(strict_types=1);

namespace EzSystems\Raml2Html\Command;

use EzSystems\Raml2Html\Test\ReferenceTester;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class TestCompareCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setName('test:compare')
            ->setDescription('Compare REST API Reference documentation with Ibexa DXP routing configuration under /api/ibexa/v2 prefix')
            ->setHelp('It is recommended to not use --console-path and --routing-file options while testing the Rest API Reference HTML file against configuration. Those options are used to test that the default configuration file list is up-to-date and other subtleties.')
            ->addArgument('ibexa-dxp-root', InputArgument::REQUIRED, 'Path to an Ibexa DXP root directory')
            ->addArgument('rest-api-reference', InputArgument::OPTIONAL, 'Path to the REST API Reference HTML file', 'docs/api/rest_api/rest_api_reference/rest_api_reference.html')
            ->addOption('console-path', 'c', InputOption::VALUE_OPTIONAL, 'Path to the console relative to Ibexa DXP root directory (if no value, use `bin/console`)', false)
            ->addOption('routing-file', 'f', InputOption::VALUE_IS_ARRAY | InputOption::VALUE_OPTIONAL, 'Path to a routing configuration YAML file relative to Ibexa DXP root directory', ReferenceTester::DEFAULT_FILE_LIST)
            ->addOption('tested-routes', 't', InputOption::VALUE_OPTIONAL,
                "ref: Test if reference routes are found in the configuration file;\n
                            conf: Test if configuration routes are found in the reference file;\n
                            both: Test both.", 'both');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $restApiReference = $input->getArgument('rest-api-reference');
        if (!is_file($restApiReference)) {
            $output->writeln("<error>$restApiReference doesn't exist or is not a file.</error>");
            return 1;
        }

        $dxpRoot = $input->getArgument('ibexa-dxp-root');
        if (!is_dir($dxpRoot)) {
            $output->writeln("<error>$dxpRoot doesn't exist or is not a directory.</error>");
            return 2;
        }

        $consolePath = $input->getOption('console-path');
        if (null === $consolePath) {
            $consolePath = 'bin/console';
        }

        $routingFiles = $input->getOption('routing-file');

        $referenceTester = new ReferenceTester($restApiReference, $dxpRoot, $consolePath, $routingFiles, $output);

        $testedRoutes = [
            'ref' => ReferenceTester::TEST_REFERENCE_ROUTES,
            'conf' => ReferenceTester::TEST_CONFIG_ROUTES,
            'both' => ReferenceTester::TEST_ALL_ROUTES,
        ][$input->getOption('tested-routes')] ?? ReferenceTester::TEST_ALL_ROUTES;

        $referenceTester->run($testedRoutes);

        return Command::SUCCESS;
    }
}
