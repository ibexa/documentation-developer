# Extend AI Actions

Extend AI Actions by connecting to other services and adding new capabilities.

By extending [AI Actions](../ai_actions_guide/index.md), you can make regular content management and editing tasks more appealing and less demanding. You can start by integrating additional AI services to the existing action types or develop custom ones that impact completely new areas of application. For example, you can create a handler that connects to a translation model and use it to translate your website on-the-fly, or generate illustrations based on a body of an article.

## Execute Actions

You can execute AI Actions by using the [`Ibexa\Contracts\ConnectorAi\ActionServiceInterface`](../../../../../../ibexa/connector-ai/src/contracts/ActionServiceInterface.php) service, as in the following example:

```php
$action = new GenerateAltTextAction(new Image([$imageEncodedInBase64]));

$action->setRuntimeContext(new RuntimeContext(['languageCode' => $languageCode]));
$action->setActionContext(
    new ActionContext(
        new ActionConfigurationOptions(['default_locale_fallback' => 'en']), // System context
        new ActionConfigurationOptions(['max_lenght' => 100]), // Action Type options
        new ActionConfigurationOptions( // Action Handler options
            [
                'prompt' => 'Generate the alt text for this image in less than 100 characters.',
                'temperature' => 0.7,
                'max_tokens' => 4096,
                'model' => 'gpt-4o-mini',
            ]
        )
    )
);

$output = $this->actionService->execute($action)->getOutput();
```

The `GenerateAltTextAction` is a built-in action that implements the [`Ibexa\Contracts\ConnectorAi\ActionInterface`](../../../../../../ibexa/connector-ai/src/contracts/ActionInterface.php), takes an [`Ibexa\Contracts\ConnectorAi\Action\DataType\Image`](../../../../../../ibexa/connector-ai/src/contracts/Action/DataType/Image.php) as an input, and generates the alternative text in the response.

This action is parameterized with the [`Ibexa\Contracts\ConnectorAi\Action\RuntimeContext`](../../../../../../ibexa/connector-ai/src/contracts/Action/RuntimeContext.php) and the [`Ibexa\Contracts\ConnectorAi\Action\ActionContext`](../../../../../../ibexa/connector-ai/src/contracts/Action/ActionContext.php), which allows you to pass additional options to the Action before it's executed.

| Type of context | Type of options        | Usage                                                                                          | Example                                                                  |
| --------------- | ---------------------- | ---------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------ |
| Runtime Context | Runtime options        | Sets additional parameters that are relevant to the specific action that is currently executed | Information about the language of the content that is being processed    |
| Action Context  | Action Type options    | Sets additional parameters for the Action Type                                                 | Information about the expected response length                           |
| Action Context  | Action Handler options | Sets additional parameters for the Action Handler                                              | Information about the model, temperature, prompt, and max tokens allowed |
| Action Context  | System options         | Sets additional information, not matching the other option collections                         | Information about the fallback locale                                    |

Both `ActionContext` and `RuntimeContext` are passed to the Action Handler (an object implementing the [`Ibexa\Contracts\ConnectorAi\Action\ActionHandlerInterface`](../../../../../../ibexa/connector-ai/src/contracts/Action/ActionHandlerInterface.php)) to execute the action. The Action Handler is responsible for combining all the options together, sending them to the AI service and returning an [ActionResponse](../../../../../../ibexa/connector-ai/src/contracts/ActionResponseInterface.php).

You can pass the Action Handler directly to the `ActionServiceInterface::execute()` method, which overrides all the other ways of selecting the Action Handler. You can also specify the Action Handler by including it in the provided [Action Configuration](#action-configurations). In other cases, the Action Handler is selected automatically. You can affect this choice by creating your own class implementing the [`Ibexa\Contracts\ConnectorAi\Action\ActionHandlerResolverInterface`](../../../../../../ibexa/connector-ai/src/contracts/Action/ActionHandlerResolverInterface.php) or by listening to the [`Ibexa\Contracts\ConnectorAi\Events\ResolveActionHandlerEvent`](../../../../../../ibexa/connector-ai/src/contracts/Events/ResolveActionHandlerEvent.php) Event sent by the default implementation.

You can influence the execution of an Action with two events:

- [`Ibexa\Contracts\ConnectorAi\Action\Event\BeforeExecuteEvent`](../../../../../../ibexa/connector-ai/src/contracts/Action/Event/BeforeExecuteEvent.php), fired before the Action is executed
- [`Ibexa\Contracts\ConnectorAi\Action\Event\ExecuteEvent`](../../../../../../ibexa/connector-ai/src/contracts/Action/Event/ExecuteEvent.php), fired after the Action is executed

Below you can find the full example of a Symfony Command, together with a matching service definition. The command finds the images modified in the last 24 hours, and adds the alternative text to them if it's missing.

```php
<?php

declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\ConnectorAi\Action\ActionContext;
use Ibexa\Contracts\ConnectorAi\Action\DataType\Image;
use Ibexa\Contracts\ConnectorAi\Action\DataType\Text;
use Ibexa\Contracts\ConnectorAi\Action\GenerateAltTextAction;
use Ibexa\Contracts\ConnectorAi\Action\RuntimeContext;
use Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionConfigurationOptions;
use Ibexa\Contracts\ConnectorAi\ActionServiceInterface;
use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\FieldTypeService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Core\Repository\Values\Content\ContentList;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\ContentTypeIdentifier;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\DateMetadata;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Operator;
use Ibexa\Contracts\Core\Repository\Values\Filter\Filter;
use Ibexa\Core\FieldType\Image\Value;
use Ibexa\Core\IO\IOBinarydataHandler;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:add-alt-text',
)]
final class AddMissingAltTextCommand extends Command
{
    private const string IMAGE_FIELD_IDENTIFIER = 'image';

    public function __construct(
        private readonly ContentService $contentService,
        private readonly PermissionResolver $permissionResolver,
        private readonly UserService $userService,
        private readonly FieldTypeService $fieldTypeService,
        private readonly ActionServiceInterface $actionService,
        private readonly IOBinarydataHandler $binaryDataHandler
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('user', InputArgument::OPTIONAL, 'Login of the user executing the actions', 'admin');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->setUser($input->getArgument('user'));

        $modifiedImages = $this->getModifiedImages();
        $output->writeln(sprintf('Found %d modified image in the last 24h', $modifiedImages->getTotalCount()));

        /** @var \Ibexa\Contracts\Core\Repository\Values\Content\Content $content */
        foreach ($modifiedImages as $content) {
            /** @var \Ibexa\Core\FieldType\Image\Value $value */
            $value = $content->getFieldValue(self::IMAGE_FIELD_IDENTIFIER);

            if ($value === null || !$this->shouldGenerateAltText($value)) {
                $output->writeln(sprintf('Image %s has the image field empty, the file cannot be accessed, or the alternative text is already specified. Skipping.', $content->getName()));
                continue;
            }

            $contentUpdateStruct = $this->contentService->newContentUpdateStruct();
            $value->alternativeText = $this->getSuggestedAltText($this->convertImageToBase64($value->uri), $content->getDefaultLanguageCode());
            $contentUpdateStruct->setField(self::IMAGE_FIELD_IDENTIFIER, $value);

            $updatedContent = $this->contentService->updateContent(
                $this->contentService->createContentDraft($content->getContentInfo())->getVersionInfo(),
                $contentUpdateStruct
            );
            $this->contentService->publishVersion($updatedContent->getVersionInfo());
        }

        return Command::SUCCESS;
    }

    private function getSuggestedAltText(string $imageEncodedInBase64, string $languageCode): string
    {
        $action = new GenerateAltTextAction(new Image([$imageEncodedInBase64]));

        $action->setRuntimeContext(new RuntimeContext(['languageCode' => $languageCode]));
        $action->setActionContext(
            new ActionContext(
                new ActionConfigurationOptions(['default_locale_fallback' => 'en']), // System context
                new ActionConfigurationOptions(['max_lenght' => 100]), // Action Type options
                new ActionConfigurationOptions( // Action Handler options
                    [
                        'prompt' => 'Generate the alt text for this image in less than 100 characters.',
                        'temperature' => 0.7,
                        'max_tokens' => 4096,
                        'model' => 'gpt-4o-mini',
                    ]
                )
            )
        );

        $output = $this->actionService->execute($action)->getOutput();

        assert($output instanceof Text);

        return $output->getText();
    }

    private function convertImageToBase64(string $uri): string
    {
        $id = $this->binaryDataHandler->getIdFromUri($uri);
        $file = $this->binaryDataHandler->getContents($id);

        return 'data:image/jpeg;base64,' . base64_encode($file);
    }

    private function getModifiedImages(): ContentList
    {
        $filter = (new Filter())
            ->withCriterion(
                new DateMetadata(DateMetadata::MODIFIED, Operator::GTE, strtotime('-1 day'))
            )
        ->andWithCriterion(new ContentTypeIdentifier('image'));

        return $this->contentService->find($filter);
    }

    /** @phpstan-assert-if-true string $value->uri */
    private function shouldGenerateAltText(Value $value): bool
    {
        return $this->fieldTypeService->getFieldType('ibexa_image')->isEmptyValue($value) === false &&
            $value->isAlternativeTextEmpty() &&
            $value->uri !== null;
    }

    private function setUser(string $userLogin): void
    {
        $this->permissionResolver->setCurrentUserReference($this->userService->loadUserByLogin($userLogin));
    }
}
```

```yaml
    App\Command\AddMissingAltTextCommand:
        arguments:
            $binaryDataHandler: '@Ibexa\Core\IO\IOBinarydataHandler\SiteAccessDependentBinaryDataHandler'
```

Executing Actions this way has a major drawback: all the parameters are stored directly in the code and cannot be easily reused or changed. To manage configurations of an AI Action you need to use another concept: Action Configurations.

## Action Configurations

### Manage Action Configurations

Action Configurations allow you to store the parameters for a given Action in the database and reuse them when needed. They can be managed [through the back office](../../../../user/ai_actions/work_with_ai_actions/index.md), [data migrations](../../../content_management/data_migration/importing_data/index.md#ai-action-configurations), or through the PHP API.

To manage Action Configurations through the PHP API, you need to use the [`Ibexa\Contracts\ConnectorAi\ActionConfigurationServiceInterface`](../../../../../../ibexa/connector-ai/src/contracts/ActionConfigurationServiceInterface.php) service.

You can manage them using the following methods:

- Creating them with `ActionConfigurationServiceInterface::createActionConfiguration()` by passing the [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionConfigurationCreateStruct`](../../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/ActionConfigurationCreateStruct.php).
- Updating them with `ActionConfigurationServiceInterface::updateActionConfiguration()` by passing the [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\ActionConfigurationUpdateStruct`](../../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/ActionConfigurationUpdateStruct.php).
- Deleting them with `ActionConfigurationServiceInterface::deleteActionConfiguration()` by passing the [`Ibexa\Contracts\ConnectorAi\ActionConfigurationInterface`](../../../../../../ibexa/connector-ai/src/contracts/ActionConfigurationInterface.php).

See the [AI Actions event reference](../../../api/event_reference/ai_action_events/index.md#action-configurations-management) for a list of events related to these operations.

You can get a specific Action Configuration using the `ActionConfigurationServiceInterface::getActionConfiguration()` method and search for them using the `ActionConfigurationServiceInterface::findActionConfigurations()` method. See [Action Configuration Search Criteria reference](../../../search/ai_actions_search_reference/action_configuration_criteria/index.md) and [Action Configuration Search Sort Clauses reference](../../../search/ai_actions_search_reference/action_configuration_sort_clauses/index.md) to discover query possibilities.

The following example creates a new Action Configuration:

```php
$refineTextActionType = $this->actionTypeRegistry->getActionType('refine_text');

$actionConfigurationCreateStruct = new ActionConfigurationCreateStruct('rewrite_casual');

$actionConfigurationCreateStruct->setType($refineTextActionType);
$actionConfigurationCreateStruct->setName('eng-GB', 'Rewrite in casual tone');
$actionConfigurationCreateStruct->setDescription('eng-GB', 'Rewrites the text using a casual tone');
$actionConfigurationCreateStruct->setActionHandler('openai-text-to-text');
$actionConfigurationCreateStruct->setActionHandlerOptions(new ArrayMap([
    'max_tokens' => 4000,
    'temperature' => 1,
    'prompt' => 'Rewrite this content to improve readability. Preserve meaning and crucial information but use casual language accessible to a broader audience.',
    'model' => 'gpt-4-turbo',
]));
$actionConfigurationCreateStruct->setEnabled(true);

$this->actionConfigurationService->createActionConfiguration($actionConfigurationCreateStruct);
```

Actions Configurations are tied to a specific Action Type and are translatable.

### Execute Actions with Action Configurations

Reuse existing Action Configurations to simplify the execution of AI Actions. You can pass one directly to the `ActionServiceInterface::execute()` method:

```php
        $action = new RefineTextAction(new Text([
<<<TEXT
Proteins differ from one another primarily in their sequence of amino acids, which is dictated by the nucleotide sequence of their genes, 
and which usually results in protein folding into a specific 3D structure that determines its activity.
TEXT
        ]));
        $actionConfiguration = $this->actionConfigurationService->getActionConfiguration('rewrite_casual');
        $actionResponse = $this->actionService->execute($action, $actionConfiguration)->getOutput();
```

The passed Action Configuration is only taken into account if the Action Context was not passed to the Action directly using the [ActionInterface::setActionContext()](../../../../../../ibexa/connector-ai/src/contracts/ActionInterface.php) method. The `ActionServiceInterface` service extracts the configuration options from the Action Configuration object and builds the Action Context object internally:

- Action Type options are mapped to Action Type options in the Action Context
- Action Handler options are mapped to Action Handler options in the Action Context
- System Context options are modified using the [ContextEvent](../../../api/event_reference/ai_action_events/index.md#others) event

## Create custom Action Handler

Ibexa DXP comes with a built-in connector to OpenAI services, but you're not limited to it and can add support for additional AI services in your application.

The following example adds a new Action Handler connecting to a local AI run using [the llamafile project](https://github.com/mozilla-ai/llamafile) which you can use to execute Text-To-Text Actions, such as the built-in "Refine Text" Action.

When creating an Action Handler for Ibexa Connect, add the new handler identifier to the [`Ibexa AI handler` custom property](../configure_ai_actions/index.md#initiate-integration) in Ibexa Connect user interface.

### Register a custom Action Handler in the system

Create a class implementing the [`Ibexa\Contracts\ConnectorAi\Action\ActionHandlerInterface`](../../../../../../ibexa/connector-ai/src/contracts/Action/ActionHandlerInterface.php) and register it as a service:

- The `ActionHandlerInterface::supports()` method decides whether the Action Handler is able to execute given Action.
- The `ActionHandlerInterface::handle()` method is responsible for combining all the Action options together, sending them to the AI service and forming an Action Response.
- The `ActionHandlerInterface::getIdentifier()` method returns the identifier of the Action Handler which you can use to refer to it in other places in the code.

See the code sample below, together with a matching service definition:

```php
<?php

declare(strict_types=1);

namespace App\AI\Handler;

use Ibexa\Contracts\ConnectorAi\Action\ActionHandlerInterface;
use Ibexa\Contracts\ConnectorAi\Action\DataType\Text;
use Ibexa\Contracts\ConnectorAi\Action\Response\TextResponse;
use Ibexa\Contracts\ConnectorAi\Action\TextToText\Action as TextToTextAction;
use Ibexa\Contracts\ConnectorAi\ActionInterface;
use Ibexa\Contracts\ConnectorAi\ActionResponseInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class LLaVaTextToTextActionHandler implements ActionHandlerInterface
{
    public const string IDENTIFIER = 'LLaVATextToText';

    public function __construct(
        private HttpClientInterface $client,
        private string $host = 'http://localhost:8080'
    ) {
    }

    public function supports(ActionInterface $action): bool
    {
        return $action instanceof TextToTextAction;
    }

    public function handle(ActionInterface $action, array $context = []): ActionResponseInterface
    {
        /** @var \Ibexa\Contracts\ConnectorAi\Action\DataType\Text */
        $input = $action->getInput();
        $text = $this->sanitizeInput($input->getText());

        $systemMessage = $action->hasActionContext() ? $action->getActionContext()->getActionHandlerOptions()->get('system_prompt', '') : '';

        $response = $this->client->request(
            'POST',
            sprintf('%s/v1/chat/completions', $this->host),
            [
                'headers' => [
                    'Authorization: Bearer no-key',
                ],
                'json' => [
                    'model' => 'LLaMA_CPP',
                    'messages' => [
                        (object)[
                            'role' => 'system',
                            'content' => $systemMessage,
                        ],
                        (object)[
                            'role' => 'user',
                            'content' => $text,
                        ],
                    ],
                    'temperature' => 0.7,
                ],
            ]
        );

        $output = strip_tags((string) json_decode($response->getContent(), true)['choices'][0]['message']['content']);

        return new TextResponse(new Text([$output]));
    }

    public static function getIdentifier(): string
    {
        return self::IDENTIFIER;
    }

    private function sanitizeInput(string $text): string
    {
        return str_replace(["\n", "\r"], ' ', $text);
    }
}
```

```yaml
    App\AI\Handler\LLaVATextToTextActionHandler:
        tags:
            - { name: ibexa.ai.action.handler, priority: 0 }
            - { name: ibexa.ai.action.handler.text_to_text, priority: 0 }
```

The `ibexa.ai.action.handler` tag is used by the `ActionHandlerResolverInterface` to find all the Action Handlers in the system.

The built-in Action Types use service tags to find Action Handlers capable of handling them and display in the back office UI:

- Refine Text uses the `ibexa.ai.action.handler.text_to_text` service tag
- Generate Alt Text uses the `ibexa.ai.action.handler.image_to_text` service tag

### Provide Form configuration

Form configuration makes the Handler configurable by using the back office. The example handler uses the `system_prompt` option, which becomes part of the Action Configuration UI thanks to the following code:

```php
<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class TextToTextOptionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('system_prompt', TextareaType::class, [
            'required' => true,
            'disabled' => $options['translation_mode'],
            'label' => 'System message',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'translation_domain' => 'app_ai',
            'translation_mode' => false,
        ]);

        $resolver->setAllowedTypes('translation_mode', 'bool');
    }
}
```

```yaml
    app.connector_ai.action_configuration.handler.llava_text_to_text.form_mapper.options:
        class: Ibexa\Bundle\ConnectorAi\Form\FormMapper\ActionConfiguration\ActionHandlerOptionsFormMapper
        arguments:
            $formType: 'App\Form\Type\TextToTextOptionsType'
        tags:
            - name: ibexa.connector_ai.action_configuration.form_mapper.options
              type: !php/const \App\AI\Handler\LLaVaTextToTextActionHandler::IDENTIFIER
```

The created Form Type adds the `system_prompt` field to the Form. Use the `Ibexa\Bundle\ConnectorAi\Form\FormMapper\ActionConfiguration\ActionHandlerOptionsFormMapper` class together with the `ibexa.connector_ai.action_configuration.form_mapper.options` service tag to make it part of the Action Handler options form. Pass the Action Handler identifier (`LLaVATextToText`) as the type when tagging the service.

The Action Handler and Action Type options are rendered in the back office using the built-in Twig options formatter.

![Custom Action Handler options rendered using the default Twig options formatter](https://doc.ibexa.co/en/5.0/ai/ai_actions/img/action_handler_options.png "Custom Action Handler options rendered using the default Twig options formatter")

You can create your own formatting by creating a class implementing the [`Ibexa\Contracts\ConnectorAi\ActionConfiguration\OptionsFormatterInterface`](../../../../../../ibexa/connector-ai/src/contracts/ActionConfiguration/OptionsFormatterInterface.php) interface and aliasing it to `Ibexa\Contracts\ConnectorAi\ActionConfiguration\OptionsFormatterInterface`.

The following service definition switches the options rendering to the other built-in options formatter, displaying the options as JSON.

```yaml
    Ibexa\Contracts\ConnectorAi\ActionConfiguration\OptionsFormatterInterface:
        alias: Ibexa\ConnectorAi\ActionConfiguration\JsonOptionsFormatter
```

## Custom Action Type use case

With custom Action Types you can create your own tasks for the AI services to perform. They can be integrated with the rest of the AI framework provided by Ibexa and incorporated into the back office.

The following example shows how to implement a custom Action Type dedicated for transcribing audio with an example Handler using [the OpenAI's Whisper](https://github.com/openai/whisper) project.

### Create custom Action Type

Start by creating your own Action Type, a class implementing the [`Ibexa\Contracts\ConnectorAi\ActionType\ActionTypeInterface`](../../../../../../ibexa/connector-ai/src/contracts/ActionType/ActionTypeInterface.php). The class needs to define following parameters of the Action Type:

- name
- identifier
- input type identifier
- output type identifier
- Action object

```php
<?php

declare(strict_types=1);

namespace App\AI\ActionType;

use App\AI\Action\TranscribeAudioAction;
use App\AI\DataType\Audio;
use Ibexa\Contracts\ConnectorAi\Action\DataType\Text;
use Ibexa\Contracts\ConnectorAi\ActionInterface;
use Ibexa\Contracts\ConnectorAi\ActionType\ActionTypeInterface;
use Ibexa\Contracts\ConnectorAi\DataType;
use Ibexa\Contracts\Core\Exception\InvalidArgumentException;

final readonly class TranscribeAudioActionType implements ActionTypeInterface
{
    public const string IDENTIFIER = 'transcribe_audio';

    /** @param iterable<\Ibexa\Contracts\ConnectorAi\Action\ActionHandlerInterface> $actionHandlers*/
    public function __construct(private iterable $actionHandlers)
    {
    }

    public function getIdentifier(): string
    {
        return self::IDENTIFIER;
    }

    public function getName(): string
    {
        return 'Transcribe audio';
    }

    public function getInputIdentifier(): string
    {
        return Audio::getIdentifier();
    }

    public function getOutputIdentifier(): string
    {
        return Text::getIdentifier();
    }

    public function getOptions(): array
    {
        return [];
    }

    public function createAction(DataType $input, array $parameters = []): ActionInterface
    {
        if (!$input instanceof Audio) {
            throw new InvalidArgumentException(
                'audio',
                'expected \App\AI\DataType\Audio type, ' . get_debug_type($input) . ' given.'
            );
        }

        return new TranscribeAudioAction($input);
    }

    public function getActionHandlers(): iterable
    {
        return $this->actionHandlers;
    }
}
```

```yaml
    App\AI\ActionType\TranscribeAudioActionType:
        arguments:
            $actionHandlers: !tagged_iterator
                tag: app.connector_ai.action.handler.audio_to_text
                default_index_method: getIdentifier
                index_by: key
        tags:
            - { name: ibexa.ai.action.type, identifier: !php/const \App\AI\ActionType\TranscribeAudioActionType::IDENTIFIER }
```

The service definition introduces a custom `app.connector_ai.action.handler.audio_to_text` service tag to mark all the handlers capable of working with this Action Type. The `ibexa.ai.action.type` service tag registers the class in the service container as a new Action Type.

If the Action Type is meant to be used mainly with prompt-based systems you can use the [`Ibexa\Contracts\ConnectorAi\Action\LLMBaseActionTypeInterface`](../../../../../../ibexa/connector-ai/src/contracts/Action/LLMBaseActionTypeInterface.php) interface as the base for your Action Type. It allows you to define a base prompt directly in the Action Type that can be common for all Action Configurations.

Action Type names can be localized using the Translation component. See the built-in Action Types like Generate Alt Text or Refine Text for an example.

### Create custom Data classes

The `TranscribeAudio` Action Type requires adding two data classes that exist in its definition:

- an `Audio` class, implementing the [DataType interface](../../../../../../ibexa/connector-ai/src/contracts/DataType.php), to store the input data for the Action

```php
<?php

declare(strict_types=1);

namespace App\AI\DataType;

use Ibexa\Contracts\ConnectorAi\DataType;

/**
 * @implements DataType<string>
 */
final class Audio implements DataType
{
    /**
     * @param non-empty-array<string> $base64
     */
    public function __construct(private array $base64)
    {
    }

    public function getBase64(): string
    {
        return reset($this->base64);
    }

    public function getList(): array
    {
        return $this->base64;
    }

    public static function getIdentifier(): string
    {
        return 'audio';
    }
}
```

- an `TranscribeAudioAction` class, implementing the [ActionInterface interface](../../../../../../ibexa/connector-ai/src/contracts/ActionInterface.php). Pass this object to the `ActionServiceInterface::execute()` method to execute the action.

```php
<?php

declare(strict_types=1);

namespace App\AI\Action;

use App\AI\DataType\Audio;
use Ibexa\Contracts\ConnectorAi\Action\Action;

final class TranscribeAudioAction extends Action
{
    public function __construct(private readonly Audio $audio)
    {
    }

    public function getParameters(): array
    {
        return [];
    }

    public function getInput(): Audio
    {
        return $this->audio;
    }

    public function getActionTypeIdentifier(): string
    {
        return 'transcribe_audio';
    }
}
```

### Create custom Action Type options form

Custom Form Type is needed if the Action Type requires additional options configurable in the UI. The following example adds a checkbox field that indicates to the Action Handler whether the transcription should include the timestamps.

```php
<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class TranscribeAudioOptionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('include_timestamps', CheckboxType::class, [
            'required' => false,
            'disabled' => $options['translation_mode'],
            'label' => 'Include timestamps',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'translation_domain' => 'app_ai',
            'translation_mode' => false,
        ]);

        $resolver->setAllowedTypes('translation_mode', 'bool');
    }
}
```

```yaml
    app.connector_ai.action_configuration.handler.transcribe_audio.form_mapper.options:
        class: Ibexa\Bundle\ConnectorAi\Form\FormMapper\ActionConfiguration\ActionTypeOptionsFormMapper
        arguments:
            $formType: 'App\Form\Type\TranscribeAudioOptionsType'
        tags:
            - name: ibexa.connector_ai.action_configuration.form_mapper.action_type_options
              type: !php/const \App\AI\ActionType\TranscribeAudioActionType::IDENTIFIER
```

The built-in `Ibexa\Bundle\ConnectorAi\Form\FormMapper\ActionConfiguration\ActionTypeOptionsFormMapper` renders the Form Type in the back office when editing the Action Configuration for a specific Action Type (indicated by the `type` attribute of the `ibexa.connector_ai.action_configuration.form_mapper.action_type_options` service tag).

### Create custom Action Handler

An example Action Handler combines the input data and the Action Type options and passes them to the Whisper executable to form an Action Response. The language of the transcribed data is extracted from the Runtime Context for better results. The Action Type options provided in the Action Context dictate whether the timestamps will be removed before returning the result.

```php
<?php

declare(strict_types=1);

namespace App\AI\Handler;

use App\AI\ActionType\TranscribeAudioActionType;
use Ibexa\Contracts\ConnectorAi\Action\ActionHandlerInterface;
use Ibexa\Contracts\ConnectorAi\Action\DataType\Text;
use Ibexa\Contracts\ConnectorAi\Action\Response\TextResponse;
use Ibexa\Contracts\ConnectorAi\ActionInterface;
use Ibexa\Contracts\ConnectorAi\ActionResponseInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

final class WhisperAudioToTextActionHandler implements ActionHandlerInterface
{
    private const string TIMESTAMP_FORMAT = '/^\[\d{2}:\d{2}\.\d{3} --> \d{2}:\d{2}\.\d{3}]\s*/';

    public function supports(ActionInterface $action): bool
    {
        return $action->getActionTypeIdentifier() === TranscribeAudioActionType::IDENTIFIER;
    }

    public function handle(ActionInterface $action, array $context = []): ActionResponseInterface
    {
        /** @var \App\AI\DataType\Audio $input */
        $input = $action->getInput();

        $path = $this->saveInputToFile($input->getBase64());

        $arguments = ['whisper'];

        $language = $action->getRuntimeContext()?->get('languageCode');
        if ($language !== null) {
            $arguments[] = sprintf('--language=%s', substr((string) $language, 0, 2));
        }

        $arguments[] = '--output_format=txt';
        $arguments[] = $path;

        $process = new Process($arguments);
        $process->run();

        if (!$process->isSuccessful()) {
            unlink($path);
            throw new ProcessFailedException($process);
        }

        $output = $process->getOutput();

        $includeTimestamps = $action->getActionContext()
            ?->getActionTypeOptions()
            ->get('include_timestamps', false)
            ?? false;

        if (!$includeTimestamps) {
            $output = $this->removeTimestamps($output);
        }

        unlink($path);

        return new TextResponse(new Text([$output]));
    }

    public static function getIdentifier(): string
    {
        return 'whisper_audio_to_text';
    }

    private function removeTimestamps(string $text): string
    {
        $lines = explode(PHP_EOL, $text);

        $processedLines = array_map(static fn (string $line): string => preg_replace(self::TIMESTAMP_FORMAT, '', (string) $line) ?? '', $lines);

        return implode(PHP_EOL, $processedLines);
    }

    private function saveInputToFile(string $audioEncodedInBase64): string
    {
        $filename = uniqid('audio');
        $path = sys_get_temp_dir() . \DIRECTORY_SEPARATOR . $filename;
        file_put_contents($path, base64_decode($audioEncodedInBase64));

        return $path;
    }
}
```

```yaml
    App\AI\Handler\WhisperAudioToTextActionHandler:
        tags:
            - { name: ibexa.ai.action.handler, priority: 0 }
            - { name: app.connector_ai.action.handler.audio_to_text, priority: 0 }
```

### Integrate with the REST API

At this point the custom Action Type can already be executed by using the PHP API. To integrate it with the [AI Actions execute endpoint](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#ai-actions-execute-ai-action) you need to create additional classes responsible for parsing the request and response data. See [adding custom media type](../../../api/rest_api/extending_rest_api/adding_custom_media_type/index.md) and [creating new REST resource](../../../api/rest_api/extending_rest_api/creating_new_rest_resource/index.md) to learn more about extending the REST API.

#### Handle input data

Start by creating an Input Parser able to handle the `application/vnd.ibexa.api.ai.TranscribeAudio` media type.

```php
<?php

declare(strict_types=1);

namespace App\AI\REST\Input\Parser;

use App\AI\DataType\Audio as AudioDataType;
use App\AI\REST\Value\TranscribeAudioAction;
use Ibexa\ConnectorAi\REST\Input\Parser\Action;
use Ibexa\Contracts\ConnectorAi\Action\RuntimeContext;
use Ibexa\Contracts\Rest\Input\ParsingDispatcher;
use Ibexa\Rest\Input\BaseParser;

final class TranscribeAudio extends BaseParser
{
    public const string AUDIO_KEY = 'Audio';
    public const string BASE64_KEY = 'base64';

    /** @param array<mixed> $data */
    public function parse(array $data, ParsingDispatcher $parsingDispatcher): TranscribeAudioAction
    {
        $this->assertInputIsValid($data);
        $runtimeContext = $this->getRuntimeContext($data);

        return new TranscribeAudioAction(
            new AudioDataType([$data[self::AUDIO_KEY][self::BASE64_KEY]]),
            $runtimeContext
        );
    }

    /** @param array<mixed> $data */
    private function assertInputIsValid(array $data): void
    {
        if (!array_key_exists(self::AUDIO_KEY, $data)) {
            throw new \InvalidArgumentException('Missing audio key');
        }

        if (!array_key_exists(self::BASE64_KEY, $data[self::AUDIO_KEY])) {
            throw new \InvalidArgumentException('Missing base64 key');
        }
    }

    /**
     * @param array<string, mixed> $data
     */
    private function getRuntimeContext(array $data): RuntimeContext
    {
        return new RuntimeContext(
            $data[Action::RUNTIME_CONTEXT_KEY] ?? []
        );
    }
}
```

```yaml
    App\AI\REST\Input\Parser\TranscribeAudio:
        parent: Ibexa\Rest\Server\Common\Parser
        tags:
            - { name: ibexa.rest.input.parser, mediaType: application/vnd.ibexa.api.ai.TranscribeAudio }
```

The `TranscribeAudioAction` is a value object holding the parsed request data.

```php
<?php

declare(strict_types=1);

namespace App\AI\REST\Value;

use App\AI\DataType\Audio;
use Ibexa\Contracts\ConnectorAi\Action\RuntimeContext;

final readonly class TranscribeAudioAction
{
    public function __construct(
        private Audio $input,
        private RuntimeContext $runtimeContext
    ) {
    }

    public function getInput(): Audio
    {
        return $this->input;
    }

    public function getRuntimeContext(): RuntimeContext
    {
        return $this->runtimeContext;
    }
}
```

#### Handle output data

To transform the `TranscribeAudioAction` into a REST response you need to create:

- An `AudioText` value object holding the REST response data

```php
<?php

declare(strict_types=1);

namespace App\AI\REST\Value;

use Ibexa\ConnectorAi\REST\Value\RestActionResponse;

final class AudioText extends RestActionResponse
{
}
```

- A resolver converting the Action Response returned from the PHP API layer into the `AudioText` object. The resolver is activated when `application/vnd.ibexa.api.ai.AudioText` media type is specified in the `Accept` header:

```php
<?php

declare(strict_types=1);

namespace App\AI\REST\Output\Resolver;

use App\AI\REST\Value\AudioText;
use Ibexa\ConnectorAi\REST\Output\ResolverInterface;
use Ibexa\Contracts\ConnectorAi\ActionResponseInterface;

final class AudioTextResolver implements ResolverInterface
{
    public function getRestValue(
        ActionResponseInterface $actionResponse
    ): AudioText {
        return new AudioText(
            $actionResponse->getOutput()
        );
    }
}
```

```yaml
    App\AI\REST\Output\Resolver\AudioTextResolver:
        tags:
            - { name: ibexa.ai.action.mime_type, key: application/vnd.ibexa.api.ai.AudioText }
```

- A visitor converting the response value object into a serialized REST response:

```php
<?php

declare(strict_types=1);

namespace App\AI\REST\Output\ValueObjectVisitor;

use Ibexa\Contracts\Rest\Output\Generator;
use Ibexa\Contracts\Rest\Output\ValueObjectVisitor;
use Ibexa\Contracts\Rest\Output\Visitor;

final class AudioText extends ValueObjectVisitor
{
    private const string OBJECT_IDENTIFIER = 'AudioText';

    /**
     * @param \App\AI\REST\Value\AudioText $data
     */
    public function visit(Visitor $visitor, Generator $generator, $data): void
    {
        $mediaType = 'ai.' . self::OBJECT_IDENTIFIER;
        $text = $data->getOutput();

        $generator->startObjectElement(self::OBJECT_IDENTIFIER, $mediaType);
        $visitor->setHeader('Content-Type', $generator->getMediaType($mediaType));

        $visitor->visitValueObject($text);

        $generator->endObjectElement(self::OBJECT_IDENTIFIER);
    }
}
```

```yaml
    App\AI\REST\Output\ValueObjectVisitor\AudioText:
        parent: Ibexa\Contracts\Rest\Output\ValueObjectVisitor
        tags:
            - { name: ibexa.rest.output.value_object.visitor, type: App\AI\REST\Value\AudioText }
```

You can now execute a specific Action Configuration for the new custom Action Type through REST API by sending the following request:

```http
POST /ai/action/execute/my_action_configuration HTTP/1.1
Accept: application/vnd.ibexa.api.ai.AudioText+json
Content-Type: application/vnd.ibexa.api.ai.TranscribeAudio+json
```

```json
{
    "TranscribeAudio": {
        "Audio": {
            "base64": "audioEncodedInBase64"
        },
        "RuntimeContext": {
            "languageCode": "eng-GB"
        }
    }
}
```

### Integrate into the back office

The last step in fully integrating the Transcribe Audio Action Type embeds it directly into the back office, allowing Editors to invoke it while doing their daily work.

Extend the default editing template of the `ibexa_binaryfile` fieldtype by creating a new file called `templates/themes/admin/admin/ui/fieldtype/edit/form_fields_binary_ai.html.twig`. This template embeds the AI component, but only if a dedicated `transcript` field (of `ibexa_text` type) is available in the same content type to store the content of the transcription.

```twig
{% extends '@ibexadesign/ui/field_type/edit/ibexa_binaryfile.html.twig' %}

{% block ibexa_binaryfile_preview %}
    {{ parent() }}

    {% import '@ibexadesign/connector_ai/ui/ai_module/macros.html.twig' as ai_macros %}

    {% set transcriptFieldIdentifier = 'transcript' %}
    {% set fieldTypeIdentifiers = form.parent.parent.vars.value|keys %}

    {% if transcriptFieldIdentifier in fieldTypeIdentifiers %}
        {% set use_ai_btn_attr = {
            class: 'btn ibexa-btn ibexa-btn--secondary ibexa-ai-component--custom-btn',
            module_id: 'TranscribeAudio',
            scroll_selector: '.ibexa-edit-content',
            container_selector: '.ibexa-edit-content',
            input_selector: '.ibexa-field-edit-preview__action--preview',
            output_selector: '#ezplatform_content_forms_content_edit_fieldsData_transcript_value',
            ai_config_id: 'transcribe_audio',
        } %}

        <button {{ ai_macros.attributes(use_ai_btn_attr) }}>
            <svg class="ibexa-icon ibexa-icon--small ibexa-icon--primary">
                <use xlink:href="{{ ibexa_icon_path('ai') }}"></use>
            </svg>
            {{ 'ibexa_connector_ai.use_ai.label'|trans({}, 'ibexa_connector_ai')|desc('Use AI') }}
        </button>
    {% endif %}
{% endblock %}
```

And add it to the SiteAccess configuration for the `admin_group`:

```yaml
ibexa:
    system:
        admin_group:
            admin_ui_forms:
                content_edit:
                    form_templates:
                        - { template: '@ibexadesign/admin/ui/fieldtype/edit/form_fields_binary_ai.html.twig', priority: -10 }
```

The configuration of the AI component takes the following parameters:

- `module_id` - name of the JavaScript module to handle the invoked action. `ImgToText` is a built-in one handling alternative text use case, `TranscribeAudio` is a custom one.
- `ai_config_id` - identifier of the Action Type to load Action Configurations for. The [ibexa_ai_config Twig function](../../../templating/twig_function_reference/ai_actions_twig_functions/index.md#ibexa_ai_config) is used under the hood.
- `container_selector` - CSS selector to narrow down the HTML area which is affected by the AI component.
- `input_selector` - CSS selector indicating the input field (must be below the `container_selector` in the HTML structure).
- `output_selector` - CSS selector indicating the output field (must be below the `container_selector` in the HTML structure).
- `cancel_wrapper_selector` - CSS selector indicating the element to which the "Cancel AI" UI element is attached.

Now create the JavaScript module mentioned in the template that is responsible for:

- gathering the input data (downloading the attached binary file and converting it into base64)
- executing the Action Configuration chosen by the editor through the REST API
- attaching the response to the output field

You can find the code of the module below. Place it in a file called `assets/js/transcribe.audio.js`

```js
import BaseAIAssistantComponent from '@ibexa-connector-ai/src/bundle/Resources/public/js/core/base.ai.assistant.component';
import Textarea from '@ibexa-connector-ai-modules/ai-assistant/fields/textarea/textarea';

export default class TranscribeAudio extends BaseAIAssistantComponent {
    constructor(mainElement, extraConfig) {
        super(mainElement, extraConfig);

        this.requestHeaders = {
            Accept: 'application/vnd.ibexa.api.ai.AudioText+json',
            'Content-Type': 'application/vnd.ibexa.api.ai.TranscribeAudio+json',
        };

        this.getRequestBody = this.getRequestBody.bind(this);
        this.getResponseValue = this.getResponseValue.bind(this);

        this.replacedField = Textarea;
    }

    getAudioInBase64() {
        const request = new XMLHttpRequest();
        request.open('GET', this.inputElement.href, false);
        request.overrideMimeType('text/plain; charset=x-user-defined');
        request.send();

        if (request.status === 200) {
            return this.convertToBase64(request.responseText);
        }
    }

    getRequestBody() {
        const inputValue = this.getInputValue();
        const body = {
            TranscribeAudio: {
                Audio: {
                    base64: inputValue,
                },
                RuntimeContext: {},
            },
        };

        if (this.languageCode) {
            body.TranscribeAudio.RuntimeContext.languageCode = this.languageCode;
        }

        return JSON.stringify(body);
    }

    convertToBase64(data) {
        let binary = '';

        for (let i = 0; i < data.length; i++) {
            binary += String.fromCharCode(data.charCodeAt(i) & 0xff);
        }

        return btoa(binary);
    }

    getResponseValue(response) {
        return response.AudioText.Text.text[0];
    }

    handleAIDialogConfirm(responseText) {
        this.outputElement.value = responseText;
        this.outputElement.dispatchEvent(new Event('input'));

        super.handleAIDialogClose(responseText);
    }
}
```

The last step is adding the module to the list of AI modules in the system, by using the provided `addModule` function.

Create a file called `assets/js/addAudioModule.js`:

```js
import { addModule } from '@ibexa-connector-ai/src/bundle/Resources/public/js/core/create.ai.module';
import TranscribeAudio from './transcribe.audio';

addModule(TranscribeAudio);
```

And include it into the back office using Webpack Encore. See [configuring assets from main project files](../../../administration/back_office/back_office_elements/importing_assets_from_bundle/index.md#configuration-from-main-project-files) to learn more about this mechanism.

```js
const ibexaConfigManager = require('@ibexa/frontend-config/webpack-config/manager');
const getIbexaConfig = require('@ibexa/frontend-config/webpack-config/ibexa');
const ibexaConfig = getIbexaConfig();

ibexaConfigManager.add({
    ibexaConfig,
    entryName: 'ibexa-admin-ui-layout-js',
    newItems: [
        path.resolve(__dirname, './assets/js/addAudioModule.js')
    ],
});

module.exports = [ibexaConfig, ...customConfigs, projectConfig];
```

Your custom Action Type is now fully integrated into the back office UI and can be used by the Editors.

![Transcribe Audio Action Type integrated into the back office](https://doc.ibexa.co/en/5.0/ai/ai_actions/img/transcribe_audio.png "Transcribe Audio Action Type integrated into the back office")

## Extend Google Gemini connector (LTS Update)

The Gemini connector provides several extension points that allow you to customize available models, behavior, validation, and response handling, while remaining compatible with the AI Actions framework.

The connector builds Gemini requests in an options provider and formats responses through a response formatter. Both components can be replaced or extended to customize how requests are constructed and how responses are normalized.

### Add or customize models

You can register additional Gemini models or customize existing ones by extending the connector’s model [configuration](../configure_ai_actions/index.md#configure-default-models).

Extend the models map by defining:

- a human-readable label
- a `max_tokens` limit

Optionally, you can set the default model that would be used for the action type that you're modifying, the default allowed tokens limit and the default temperature. Default values must stay within the limits supported by the [Gemini API](https://ai.google.dev/gemini-api/docs/models).

### Add a custom Action Handler

To introduce a new Gemini-based AI action:

1. Create a handler that extends `Ibexa\Contracts\ConnectorAi\Action\AbstractActionHandler`.
2. Register the handler in `services/ai_action_handlers.yaml`.
3. Provide supporting components as needed:
   - a prompt factory
   - a form type for configuration
   - validators for action options

This follows the same extension mechanism as other [custom AI actions](#create-custom-action-handler).

### Add custom response formatting

To change how Gemini responses are post-processed or normalized:

1. Implement the `Ibexa\ConnectorGemini\Response\GeminiResponseFormatterInterface` interface.
2. Alias your implementation in the service container to override the default formatter.

### Add custom validation

Add extra validation rules for Gemini action configuration options by tagging custom validators:

- For `text-to-text` actions:

  ```yaml
  ibexa.connector_ai.action_configuration.options.validator.gemini_text_to_text
  ```

- For `image-to-text` actions:

  ```yaml
  ibexa.connector_ai.action_configuration.options.validator.gemini_image_to_text
  ```

### Replace the Gemini client implementation

To get full control over the low-level API communication without modifying the connector itself, you can swap the Gemini client implementation entirely with your own:

- Use dependency injection to bind your own implementation to `Ibexa\ConnectorGemini\Client\GeminiClientInterface`.
