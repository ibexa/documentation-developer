---
description: Render the content from PHP and get the HTML as a string.
---

# Render content in PHP

While in PHP, you may need to render the view of a content for further treatment.

The following example is a command outputting the render of a content for a view type in the terminal.
It will work only if the view doesn't refer to the HTTP request.
It works with views like the `line` or `embed` ones from default installation. It won't work with a `full` view if the pagelayout is using `app.request.locale`.

```yaml
# config/services.yaml
services:
    #…
    App\Command\ViewCommand:
        tags:
            - { name: 'console.command', command: 'app:view' }
```

```php
<?php
// src/Command/ViewCommand.php

namespace App\Command;

use Ibexa\Core\MVC\Symfony\View\Builder\ContentViewBuilder;
use Ibexa\Core\MVC\Symfony\View\Renderer\TemplateRenderer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ViewCommand extends Command {
    protected static $defaultName = 'app:view';

    private ContentViewBuilder $contentViewBuilder;
    private TemplateRenderer $templateRenderer;
    private ResponseTagger $responseTagger;

    public function __construct(
        ContentViewBuilder $contentViewBuilder,
        TemplateRenderer $templateRenderer
    )
    {
        parent::__construct(self::$defaultName);
        $this->contentViewBuilder = $contentViewBuilder;
        $this->templateRenderer = $templateRenderer;
    }

    protected function configure(): void
    {
        $this->setDescription('Render the view of a content item')
            ->addOption('content-id', 'c', InputOption::VALUE_OPTIONAL, 'Content ID')
            ->addOption('location-id', 'l', InputOption::VALUE_OPTIONAL, 'Location ID')
            ->addOption('view-type', 't', InputOption::VALUE_OPTIONAL, 'View Type', 'line');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $contentId = $input->getOption('content-id');
        $locationId = $input->getOption('location-id');
        if (empty($contentId) && empty($locationId)) {
            throw new \InvalidArgumentException('No content nor location ID given');
        }

        $viewParameters = [
            'viewType' => $input->getOption('view-type'),
            '_controller' => 'ibexa_content:viewAction',
        ];

        if (!empty($locationId)) {
            $viewParameters['locationId'] = $locationId;
        }
        if (!empty($contentId)) {
            $viewParameters['contentId'] = $contentId;
        }

        // build view
        $contentView = $this->contentViewBuilder->buildView($viewParameters);

        // generate the HTML using TemplateRenderer + ContentViewBuilder
        $renderedView = $this->templateRenderer->render($contentView);

        $output->writeln($renderedView);

        return 0;
    }
}
```

```bash
php bin/console app:view --content-id=52
php bin/console app:view --location-id=2 --view-type=embed
```

!!! caution

    Avoid using this in a controller as much as possible.
    You can access directly to a view via the route /view/content/{contentId}/{viewType}[/{location}]. For example, on a fresh installation, you can access `/view/content/52/line which will return a small piece of HTML with a link to the content that could be used in Ajax.
    If you need a controller (to have additional information available in the template, or to manipulate the `Response` object before returning it), a controller defined in a [view configuration](template_configuration.md) as shown in [Controllers](controllers.md) is a better practice.
