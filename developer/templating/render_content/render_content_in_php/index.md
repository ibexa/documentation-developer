# Render content in PHP

Render content item from PHP and get the resulting HTML as a string.

While in PHP, you may need to render the view of a content item (for example, for further treatment like PDF conversion, or because you're not in an HTML context).

> **Caution: Caution**
>
> Avoid using PHP rendering in a controller as much as possible. You can access a view directly through the route `/view/content/{contentId}/{viewType}[/{location}]`. For example, on a fresh installation, you can access `/view/content/52/line` which returns a small piece of HTML with a link to the content that could be used in Ajax. If you need a controller to have additional information available in the template or to customize the `Response` object, define the controller in a [view configuration](../../templates/template_configuration/index.md) as shown in [Controllers](../../queries_and_controllers/controllers/index.md), enhance the View object and return it.

The following example is a command outputting the render of a content for a view type in the terminal. It works only if the view doesn't refer to the HTTP request. It's compatible with the default installation views such as `line` or `embed`. To go further with this example, you could add some dedicated views not outputting HTML but, for example, plain text, [Symfony command styled text](https://symfony.com/doc/7.4/console/style.html#output-coloring) or Markdown. It doesn't work with a `full` view when the [page layout](../../templates/template_configuration/index.md#page-layout) uses `app.request`, such as the out-of-the-box template.

Create the command in `src/Command/ViewCommand.php`:

```php
<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Core\MVC\Symfony\View\Builder\ContentViewBuilder;
use Ibexa\Core\MVC\Symfony\View\Renderer\TemplateRenderer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:view',
    description: 'Render the view of a content item'
)]
class ViewCommand extends Command
{
    public function __construct(
        private readonly ContentViewBuilder $contentViewBuilder,
        private readonly TemplateRenderer $templateRenderer
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('content-id', 'c', InputOption::VALUE_OPTIONAL, 'Content ID')
            ->addOption('location-id', 'l', InputOption::VALUE_OPTIONAL, 'Location ID')
            ->addOption('view-type', 't', InputOption::VALUE_OPTIONAL, 'View Type', 'line');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $contentId = $input->getOption('content-id');
        $locationId = $input->getOption('location-id');
        if (empty($contentId) && empty($locationId)) {
            throw new \InvalidArgumentException('No Content ID nor Location ID given');
        }

        $viewParameters = [
            'viewType' => $input->getOption('view-type'),
            '_controller' => 'ibexa_content::viewAction',
        ];

        if (!empty($locationId)) {
            $viewParameters['locationId'] = $locationId;
        }
        if (!empty($contentId)) {
            $viewParameters['contentId'] = $contentId;
        }

        // build view
        $contentView = $this->contentViewBuilder->buildView($viewParameters);

        // render view
        $renderedView = $this->templateRenderer->render($contentView);

        $output->writeln($renderedView);

        return 0;
    }
}
```

> **Caution: Caution**
>
> As `Ibexa\Core\MVC\Symfony\View\Builder\ContentViewBuilder` and `Ibexa\Core\MVC\Symfony\View\Renderer\TemplateRenderer` aren't part of the public PHP API's `Ibexa\Contracts` namespace, they might change without notice.

Use the command with some views:

```bash
php bin/console app:view --content-id=52
php bin/console app:view --location-id=2 --view-type=embed
```
