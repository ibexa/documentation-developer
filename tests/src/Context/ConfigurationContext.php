<?php declare(strict_types=1);

/**
 * @copyright Copyright (C) Ibexa. All rights reserved.
 *
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\DeveloperDocumentation\Test\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use EzSystems\DeveloperDocumentation\Test\ConfigurationEditor;

class ConfigurationContext implements Context
{
    private $basePath;

    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @Given I set the Landing Page template configuration in :filePath
     */
    public function iSetTheLandingPageTemplateConfigurationIn($filePath): void
    {
        $config = new ConfigurationEditor(sprintf('%s/%s', $this->basePath, $filePath));
        $config->add([
            'ezpublish.system.site_group.content_view.full.landing_page.template' => 'full/landing_page.html.twig',
            'ezpublish.system.site_group.content_view.full.landing_page.match.Identifier\ContentType' => 'landing_page',
        ]);
    }

    /**
     * @Given I add imports to :configPath
     */
    public function iAddImport($configPath, TableNode $imports): void
    {
        $config = new ConfigurationEditor(sprintf('%s/%s', $this->basePath, $configPath));

        $entriesToAdd['imports'] = [];
        foreach ($imports->getHash() as $import) {
            $entriesToAdd['imports'][] = ['resource' => $import['name']];
        }

        $config->add($entriesToAdd);
    }

    /**
     * @Given I add Content List layout configuration to :filePath
     */
    public function addContentListLayout($filePath): void
    {
        $config = new ConfigurationEditor(sprintf('%s/%s', $this->basePath, $filePath));
        $config->add([
            'ezplatform_page_fieldtype.blocks.contentlist.views.contentList.template' => 'blocks/contentlist/default.html.twig',
            'ezplatform_page_fieldtype.blocks.contentlist.views.contentList.name' => 'Content List',
        ]);
    }

    /**
     * @Given I set Content List image variations in :filePath
     */
    public function setContentListImageVariation($filePath): void
    {
        $config = new ConfigurationEditor(sprintf('%s/%s', $this->basePath, $filePath));
        $config->add([
            'ezpublish.system.default.image_variations.content_list.reference' => null,
            'ezpublish.system.default.image_variations.content_list.filters' => [['name' => 'geometry/scaleheightdownonly', 'params' => [81]], ['name' => 'geometry/crop', 'params' => [80, 80, 0, 0]]],
        ]);
    }

    /**
     * @Given I add Content Scheduler layout configuration to :filePath
     */
    public function addContentSchedulerLayout($filePath): void
    {
        $config = new ConfigurationEditor(sprintf('%s/%s', $this->basePath, $filePath));
        $config->add([
            'ezplatform_page_fieldtype.blocks.schedule.views.featured.template' => 'blocks/schedule/featured.html.twig',
            'ezplatform_page_fieldtype.blocks.schedule.views.featured.name' => 'Featured Schedule Block',
        ]);
    }

    /**
     * @Given I set template for Article in :filePath
     */
    public function setTemplateForArticle($filePath): void
    {
        $config = new ConfigurationEditor(sprintf('%s/%s', $this->basePath, $filePath));
        $config->add([
            'ezpublish.system.site_group.content_view.featured.article.template' => 'featured/article.html.twig',
            'ezpublish.system.site_group.content_view.featured.article.match.Identifier\ContentType' => 'article',
        ]);
    }

    /**
     * @Given I set Content Scheduler image variations in :filePath
     */
    public function setContentSchedulerVariations($filePath): void
    {
        $config = new ConfigurationEditor(sprintf('%s/%s', $this->basePath, $filePath));
        $config->add([
            'ezpublish.system.default.image_variations.featured_article.reference' => null,
            'ezpublish.system.default.image_variations.featured_article.filters' => [['name' => 'geometry/scaleheightdownonly', 'params' => [200]]],
        ]);
    }

    /**
     * @Given I add RandomBlockListener service configuration to :filePath
     */
    public function addService($filePath): void
    {
        $config = new ConfigurationEditor(sprintf('%s/%s', $this->basePath, $filePath));
        $config->add([
            'services.AppBundle\Event\RandomBlockListener.tags' => ['name' => 'kernel.event_subscriber'],
        ]);
    }

    /**
     * @Given I create configuration of Random block to :filePath
     */
    public function addRandomBlockConfig($filePath): void
    {
        $config = new ConfigurationEditor(sprintf('%s/%s', $this->basePath, $filePath));
        $config->add([
            'ezplatform_page_fieldtype.blocks.random.name' => 'Random block',
            'ezplatform_page_fieldtype.blocks.random.thumbnail' => '/assets/images/blocks/random_block.svg#random',
            'ezplatform_page_fieldtype.blocks.random.views.random.template' => 'blocks/random/default.html.twig',
            'ezplatform_page_fieldtype.blocks.random.views.random.name' => 'Random Content Block View',
            'ezplatform_page_fieldtype.blocks.random.attributes.parent.type' => 'embed',
            'ezplatform_page_fieldtype.blocks.random.attributes.parent.name' => 'Parent',
            'ezplatform_page_fieldtype.blocks.random.attributes.parent.validators.not_blank.message' => 'You must provide value',
            'ezplatform_page_fieldtype.blocks.random.attributes.parent.validators.regexp.message' => 'Choose a content item',
            'ezplatform_page_fieldtype.blocks.random.attributes.parent.validators.regexp.options.pattern' => '/[0-9]+/',
        ]);
    }

    /**
     * @Given I create configuration of Form block to :filePath
     */
    public function addFormBlockConfig($filePath): void
    {
        $config = new ConfigurationEditor(sprintf('%s/%s', $this->basePath, $filePath));
        $config->add([
            'ezplatform_page_fieldtype.blocks.form.views.newsletter.template' => 'blocks/form/newsletter.html.twig',
            'ezplatform_page_fieldtype.blocks.form.views.newsletter.name' => 'Newsletter Form View',
        ]);
    }

    /**
     * @Given I create configuration of Form field to :filePath
     */
    public function addFormFieldConfig($configPath): void
    {
        $config = new ConfigurationEditor(sprintf('%s/%s', $this->basePath, $configPath));
        $config->add([
            'ezpublish.system.site.field_templates' => [['template' => 'fields/form_field.html.twig', 'priority' => 30]],
        ]);
    }

    /**
     * @Given I create configuration of Captcha field to :filePath
     */
    public function addCaptchaConfig($configPath): void
    {
        $config = new ConfigurationEditor(sprintf('%s/%s', $this->basePath, $configPath));
        $config->add([
            'gregwar_captcha.width' => '150',
            'gregwar_captcha.invalid_message' => 'Please, enter again.',
            'gregwar_captcha.reload' => 'true',
            'gregwar_captcha.length' => '4',
        ]);
    }

    /**
     * @Given I rebuild Webpack Encore assets
     */
    public function rebuildYarn(): void
    {
        shell_exec('bin/console ezplatform:encore:compile');
    }
}
