<?php

declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\SiteContext\BrandContextAiContextResolverInterface;
use Ibexa\Contracts\SiteContext\SiteContextServiceInterface;
use Ibexa\Contracts\SiteContext\Values\BrandContextAi\BrandContextAiContext;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'doc:brand_context:ai_guidelines')]
final class BrandContextAiGuidelinesCommand extends Command
{
    public function __construct(
        private readonly BrandContextAiContextResolverInterface $aiContextResolver,
        private readonly SiteContextServiceInterface $siteContextService
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Get the AI guidelines of the brand context that the carotella_pro website belongs to
        $aiContext = $this->aiContextResolver->resolveForSiteAccess('carotella_pro', 'eng-GB');

        foreach ($aiContext?->getEntries() ?? [] as $entry) {
            $output->writeln(sprintf('- %s: %s', $entry->getDescription(), $entry->getValue()));
        }

        // Run code as if the carotella_pro website was selected in the back office
        $aiContext = $this->siteContextService->runInContext(
            'carotella_pro',
            fn (): ?BrandContextAiContext => $this->aiContextResolver->resolveForCurrentSiteContext('eng-GB')
        );

        $output->writeln('Brand context: ' . ($aiContext?->getBrandContextIdentifier() ?? 'none'));

        return self::SUCCESS;
    }
}
