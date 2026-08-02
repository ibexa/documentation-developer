# Custom policies

Create a custom policy to cover non-standard permission needs.

The content repository uses [roles and policies](../permissions/index.md) to give users access to different functions of the system.

Any bundle can expose available policies via a `PolicyProvider` which can be added to IbexaCoreBundle's [service container](../../api/php_api/php_api/index.md#service-container) extension.

## PolicyProvider

A `PolicyProvider` object provides a hash containing declared modules, functions and limitations.

- Each policy provider provides a collection of permission *modules*.
- Each module can provide *functions* (for example, in `content/read`, "content" is the module, and "read" is the function)
- Each function can provide a collection of limitations.

First level key is the module name which is limited to characters within the set `A-Za-z0-9_`, value is a hash of available functions, with function name as key. Function value is an array of available limitations, identified by the alias declared in `LimitationType` service tag. If no limitation is provided, value can be `null` or an empty array.

```php
$config = [
    'content' => [
        'read' => ['Class', 'ParentClass', 'Node', 'Language'],
        'edit' => ['Class', 'ParentClass', 'Language'],
    ],
    'custom_module' => [
        'custom_function_1' => null,
        'custom_function_2' => ['CustomLimitation'],
    ],
];
```

Limitations need to be implemented as *Limitation types* and declared as services identified with `ibexa.permissions.limitation_type` tag. Name provided in the hash for each limitation is the same value set in the `alias` attribute in the service tag.

For example:

```php
<?php

declare(strict_types=1);

namespace App\Security;

use Ibexa\Bundle\Core\DependencyInjection\Configuration\ConfigBuilderInterface;
use Ibexa\Bundle\Core\DependencyInjection\Security\PolicyProvider\PolicyProviderInterface;

class MyPolicyProvider implements PolicyProviderInterface
{
    public function addPolicies(ConfigBuilderInterface $configBuilder): void
    {
        $configBuilder->addConfig([
             'custom_module' => [
                 'custom_function_1' => null,
                 'custom_function_2' => ['CustomLimitation'],
             ],
         ]);
    }
}
```

> **Note: Extend existing policies**
>
> While a `PolicyProvider` may provide new functions to an existing policy module, or additional limitations to an existing function, it's however strongly recommended to create your own modules.
>
> It's impossible to remove an existing module, function or limitation from a policy.

### YamlPolicyProvider

An abstract class based on YAML is provided: `Ibexa\Bundle\Core\DependencyInjection\Security\PolicyProvider\YamlPolicyProvider`. It defines an abstract `getFiles()` method.

Extend `YamlPolicyProvider` and implement `getFiles()` to return absolute paths to your YAML files.

```php
<?php

declare(strict_types=1);

namespace App\Security;

use Ibexa\Bundle\Core\DependencyInjection\Security\PolicyProvider\YamlPolicyProvider;

class MyPolicyProvider extends YamlPolicyProvider
{
    /** @returns string[] */
    protected function getFiles(): array
    {
        return [
            __DIR__ . '/../Resources/config/policies.yaml',
        ];
    }
}
```

In `src/Resources/config/policies.yaml`:

```yaml
custom_module:
    custom_function_1: ~
    custom_function_2: [CustomLimitation]
```

### Translations

Provide translations for your custom policies in the `forms` domain.

For example, `translations/forms.en.yaml`:

```yaml
role.policy.custom_module: 'Custom module'
role.policy.custom_module.all_functions: 'Custom module / All functions'
role.policy.custom_module.custom_function_1: 'Custom module / Function #1'
role.policy.custom_module.custom_function_2: 'Custom module / Function #2'
```

You can also implement `TranslationContainerInterface` to provide those translations in your policy provider class:

```php
<?php

declare(strict_types=1);

namespace App\Security;

use Ibexa\Bundle\Core\DependencyInjection\Configuration\ConfigBuilderInterface;
use Ibexa\Bundle\Core\DependencyInjection\Security\PolicyProvider\PolicyProviderInterface;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;

class MyPolicyProvider implements PolicyProviderInterface, TranslationContainerInterface
{
    public function addPolicies(ConfigBuilderInterface $configBuilder): void
    {
        $configBuilder->addConfig([
             'custom_module' => [
                 'custom_function_1' => null,
                 'custom_function_2' => ['CustomLimitation'],
             ],
         ]);
    }

    /** @return array<\JMS\TranslationBundle\Model\Message> */
    public static function getTranslationMessages(): array
    {
        return [
            (new Message('role.policy.custom_module', 'forms'))->setDesc('Custom module'),
            (new Message('role.policy.custom_module.all_functions', 'forms'))->setDesc('Custom module / All functions'),
            (new Message('role.policy.custom_module.custom_function_1', 'forms'))->setDesc('Custom module / Function #1'),
            (new Message('role.policy.custom_module.custom_function_2', 'forms'))->setDesc('Custom module / Function #2'),
        ];
    }
}
```

Then, extract this translation to generate the English translation file `translations/forms.en.xlf`:

```bash
php bin/console jms:translation:extract en --domain=forms --dir=src --output-dir=translations
```

## `PolicyProvider` integration into `IbexaCoreBundle`

For a `PolicyProvider` to be active, you have to register it in the `src/Kernel.php`:

```php
<?php

declare(strict_types=1);

namespace App;

use App\Security\MyPolicyProvider;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function build(ContainerBuilder $container): void
    {
        // Retrieve "ibexa" container extension
        /** @var \Ibexa\Bundle\Core\DependencyInjection\IbexaCoreExtension $ibexaExtension */
        $ibexaExtension = $container->getExtension('ibexa');

        // Add the policy provider, you can register multiple providers by calling the method repeatedly
        $ibexaExtension->addPolicyProvider(new MyPolicyProvider());
    }
}
```

## Custom limitation type

For a custom module function, you can use existing limitation types or create custom ones.

The base of a custom limitation is a class to store values for the usage of this limitation in roles, and a class to implement the limitation's logic.

The value class extends `Ibexa\Contracts\Core\Repository\Values\User\Limitation` and says for which limitation it's used:

```php
<?php

declare(strict_types=1);

namespace App\Security\Limitation;

use Ibexa\Contracts\Core\Repository\Values\User\Limitation;

class CustomLimitationValue extends Limitation
{
    public function getIdentifier(): string
    {
        return 'CustomLimitation';
    }
}
```

The type class implements `Ibexa\Contracts\Core\Limitation\Type`.

- `accept`, `validate` and `buildValue` implement the value class usage logic.
- `evaluate` challenges a limitation value against the current user, the subject object and other context objects to return if the limitation is satisfied or not. `evaluate` is, among others, used by `PermissionResolver::canUser` (to check if a user that has access to a function can use it in its limitations) and `PermissionResolver::lookupLimitations`.

```php
<?php

declare(strict_types=1);

namespace App\Security\Limitation;

use Ibexa\Contracts\Core\Limitation\Type;
use Ibexa\Contracts\Core\Repository\Exceptions\NotImplementedException;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\CriterionInterface;
use Ibexa\Contracts\Core\Repository\Values\User\Limitation;
use Ibexa\Contracts\Core\Repository\Values\User\UserReference;
use Ibexa\Core\Base\Exceptions\InvalidArgumentException;
use Ibexa\Core\Base\Exceptions\InvalidArgumentType;
use Ibexa\Core\FieldType\ValidationError;

class CustomLimitationType implements Type
{
    public function acceptValue(Limitation $limitationValue): void
    {
        if (!$limitationValue instanceof CustomLimitationValue) {
            throw new InvalidArgumentType(
                '$limitationValue',
                CustomLimitationValue::class,
                $limitationValue
            );
        }
    }

    /** @return \Ibexa\Contracts\Core\FieldType\ValidationError[] */
    public function validate(Limitation $limitationValue): array
    {
        $validationErrors = [];
        if (!array_key_exists('value', $limitationValue->limitationValues)) {
            $validationErrors[] = new ValidationError("limitationValues['value'] is missing.");
        } elseif (!is_bool($limitationValue->limitationValues['value'])) {
            $validationErrors[] = new ValidationError("limitationValues['value'] is not a boolean.");
        }

        return $validationErrors;
    }

    public function buildValue(array $limitationValues): CustomLimitationValue
    {
        $value = false;
        if (array_key_exists('value', $limitationValues)) {
            $value = $limitationValues['value'];
        } elseif (count($limitationValues)) {
            $value = (bool)$limitationValues[0];
        }

        return new CustomLimitationValue(['limitationValues' => ['value' => $value]]);
    }

    /**
     * @param \Ibexa\Contracts\Core\Repository\Values\ValueObject[]|null $targets
     *
     * @return bool|null
     */
    public function evaluate(Limitation $value, UserReference $currentUser, object $object, ?array $targets = null): ?bool
    {
        if (!$value instanceof CustomLimitationValue) {
            throw new InvalidArgumentException('$value', 'Must be of type: CustomLimitationValue');
        }

        if ($value->limitationValues['value']) {
            return Type::ACCESS_GRANTED;
        }

        // If the limitation value is not set to `true`, then $currentUser, $object and/or $targets could be challenged to determine if the access is granted or not; Here or elsewhere. When passing the baton, a limitation can return Type::ACCESS_ABSTAIN
        return Type::ACCESS_DENIED;
    }

    public function getCriterion(Limitation $value, UserReference $currentUser): CriterionInterface
    {
        throw new NotImplementedException(__METHOD__);
    }

    public function valueSchema(): never
    {
        throw new NotImplementedException(__METHOD__);
    }
}
```

The type class is set as a service tagged `ibexa.permissions.limitation_type` with an alias to identify it, and to link it to the value.

```yaml
services:
    # …
    App\Security\Limitation\CustomLimitationType:
        tags:
            - { name: 'ibexa.permissions.limitation_type', alias: 'CustomLimitation' }
```

### Custom limitation type form

#### Form mapper

To provide support for editing custom policies in the back office, you need to implement [`Ibexa\AdminUi\Limitation\LimitationFormMapperInterface`](https://github.com/ibexa/admin-ui/blob/5.0/src/lib/Limitation/LimitationFormMapperInterface.php).

- `mapLimitationForm` adds the limitation field as a child to a provided Symfony form.
- `getFormTemplate` returns the path to the template to use for rendering the limitation form. Here it use [`form_label`](https://symfony.com/doc/7.4/form/form_customization.html#reference-forms-twig-label) and [`form_widget`](https://symfony.com/doc/7.4/form/form_customization.html#reference-forms-twig-widget) to do so.
- `filterLimitationValues` is triggered when the form is submitted and can manipulate the limitation values, such as normalizing them.

```php
<?php

declare(strict_types=1);

namespace App\Security\Limitation\Mapper;

use Ibexa\AdminUi\Limitation\LimitationFormMapperInterface;
use Ibexa\Contracts\Core\Repository\Values\User\Limitation;
use Ibexa\Core\Limitation\LimitationIdentifierToLabelConverter;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormInterface;

class CustomLimitationFormMapper implements LimitationFormMapperInterface
{
    public function mapLimitationForm(FormInterface $form, Limitation $data): void
    {
        $form->add('limitationValues', CheckboxType::class, [
            'label' => LimitationIdentifierToLabelConverter::convert($data->getIdentifier()),
            'required' => false,
            'data' => $data->limitationValues['value'],
            'property_path' => 'limitationValues[value]',
        ]);
    }

    public function getFormTemplate(): string
    {
        return '@ibexadesign/limitation/custom_limitation_form.html.twig';
    }

    public function filterLimitationValues(Limitation $limitation): void
    {
    }
}
```

Provide a template corresponding to `getFormTemplate`.

```html+twig
{# templates/themes/admin/limitation/custom_limitation_form.html.twig #}
{{ form_label(form.limitationValues) }}
{{ form_widget(form.limitationValues) }}
```

Next, register the service with the `ibexa.admin_ui.limitation.mapper.form` tag and set the `limitationType` attribute to the limitation type's identifier:

```yaml
    App\Security\Limitation\Mapper\CustomLimitationFormMapper:
        tags:
            - { name: 'ibexa.admin_ui.limitation.mapper.form', limitationType: 'CustomLimitation' }
```

#### Notable form mappers to extend

Some abstract limitation type form mapper classes are provided to help implementing common complex limitations.

- `MultipleSelectionBasedMapper` is a mapper used to build forms for limitations based on a checkbox list, where multiple items can be chosen. For example, it's used to build forms for [Content Type Limitation](../limitation_reference/index.md#content-type-limitation), [Language Limitation](../limitation_reference/index.md#language-limitation) or [Section Limitation](../limitation_reference/index.md#section-limitation).
- `UDWBasedMapper` is used to build a limitation form where a content/location must be selected. For example, it's used by the [Subtree Limitation](../limitation_reference/index.md#subtree-limitation) form.

#### Value mapper

By default, without a value mapper, the limitation value is rendered by using the block `ibexa_limitation_value_fallback` of the template [`vendor/ibexa/admin-ui/src/bundle/Resources/views/themes/admin/limitation/limitation_values.html.twig`](https://github.com/ibexa/admin-ui/blob/v5.0.9/src/bundle/Resources/views/themes/admin/limitation/limitation_values.html.twig).

To customize the rendering, a value mapper eventually transforms the limitation value and sends it to a custom template.

The value mapper implements [`Ibexa\AdminUi\Limitation\LimitationValueMapperInterface`](https://github.com/ibexa/admin-ui/blob/4.5/src/lib/Limitation/LimitationValueMapperInterface.php).

Its `mapLimitationValue` function returns the limitation value transformed for the needs of the template.

```php
<?php

declare(strict_types=1);

namespace App\Security\Limitation\Mapper;

use Ibexa\AdminUi\Limitation\LimitationValueMapperInterface;
use Ibexa\Contracts\Core\Repository\Values\User\Limitation;

class CustomLimitationValueMapper implements LimitationValueMapperInterface
{
    /**
     * @return array<bool>
     */
    public function mapLimitationValue(Limitation $limitation): array
    {
        return [$limitation->limitationValues['value']];
    }
}
```

Then register the service with the `ibexa.admin_ui.limitation.mapper.value` tag and set the `limitationType` attribute to limitation type's identifier:

```yaml
    App\Security\Limitation\Mapper\CustomLimitationValueMapper:
        tags:
            - { name: 'ibexa.admin_ui.limitation.mapper.value', limitationType: 'CustomLimitation' }
```

When a value mapper exists for a limitation, the rendering uses a Twig block named `ibexa_limitation_<lower_case_identifier>_value` where `<lower_case_identifier>` is the limitation identifier in lower case. In this example, block name is `ibexa_limitation_customlimitation_value` as the identifier is `CustomLimitation`.

This template receives a `values` variable which is the return value of the `mapLimitationValue` function from the corresponding value mapper.

```html+twig
{# templates/themes/standard/limitation/custom_limitation_value.html.twig #}
{% block ibexa_limitation_customlimitation_value %}
    {% set is_set = values | first %}
    <span style="color: {{ is_set ? 'green' : 'red' }};">{{ is_set ? 'Yes' : 'No' }}</span>
{% endblock %}
```

To have your block found, you have to register its template. Add the template to the configuration under `ibexa.system.<SCOPE>.limitation_value_templates`:

```yaml
ibexa:
    system:
        default:
            limitation_value_templates:
                - { template: '@ibexadesign/limitation/custom_limitation_value.html.twig', priority: 0 }
```

Provide translations for your custom limitation form in the `ibexa_content_forms_policies` domain. For example, `translations/ibexa_content_forms_policies.en.yaml`:

```yaml
policy.limitation.identifier.customlimitation: 'Custom limitation'
```

### Custom limitation check

Check if current user has this custom limitation set to true from a custom controller:

```php
<?php declare(strict_types=1);

namespace App\Controller;

use App\Security\Limitation\CustomLimitationValue;
use Ibexa\Contracts\AdminUi\Controller\Controller;
use Ibexa\Contracts\AdminUi\Permission\PermissionCheckerInterface;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\User\Controller\AuthenticatedRememberedCheckTrait;
use Ibexa\Contracts\User\Controller\RestrictedControllerInterface;
use Ibexa\Core\MVC\Symfony\Security\Authorization\Attribute;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomController extends Controller implements RestrictedControllerInterface
{
    use AuthenticatedRememberedCheckTrait {
        AuthenticatedRememberedCheckTrait::performAccessCheck as public traitPerformAccessCheck;
    }

    public function __construct(
        // ...,
        private readonly PermissionResolver $permissionResolver,
        private readonly PermissionCheckerInterface $permissionChecker
    ) {
    }

    // Controller actions...
    public function customAction(Request $request): Response
    {
        // ...
        if ($this->getCustomLimitationValue()) {
            // Action only for user having the custom limitation checked
        }

        return new Response('<html><body>...</body></html>');
    }

    private function getCustomLimitationValue(): bool
    {
        $hasAccess = $this->permissionResolver->hasAccess('custom_module', 'custom_function_2');

        if (is_bool($hasAccess)) {
            return $hasAccess;
        }

        $customLimitationValues = $this->permissionChecker->getRestrictions(
            $hasAccess,
            CustomLimitationValue::class
        );

        return $customLimitationValues['value'] ?? false;
    }

    #[\Override]
    public function performAccessCheck(): void
    {
        $this->traitPerformAccessCheck();
        $this->denyAccessUnlessGranted(new Attribute('custom_module', 'custom_function_2'));
    }
}
```

## Restrict access to form submissions

By default, access to a [Form content item](../../content_management/forms/form_builder_guide/index.md#forms-management) is controlled by the `content/read` policy. As a result, all users who can view a form in the back office can also [access](../../content_management/forms/form_builder_guide/index.md#view-results) its [**Submissions** tab](../../administration/back_office/back_office_tabs/back_office_tabs/index.md).

However, form submissions may require stricter access control than the form itself, for example, to conform with GDPR regulations. To tackle this, you must separate the permissions by introducing a dedicated policy that manages access to form submission:

- define a custom policy: `form/read_submissions`
- enforce the policy on the PHP API level
- enforce the policy in the back office

With this setup, users with `content/read` permission can view the form, but cannot see the **Submissions** tab, while users with `form/read_submissions` can access the submissions, export and manage submitted data (depending on other permissions).

> **Note: Implementation notes**
>
> - This implementation uses service decoration and extends internal classes.
> - Some internal methods are not publicly reusable, which may require additional calls, for example, `gateway->loadById($id)` or minor workarounds.
> - When upgrading, review these customizations to ensure compatibility with internal API changes.

### Define custom policy

First, create the `FormPolicyProvider.php` policy provider that registers the new `form` module and the `read_submissions` function by injecting the custom permission into the configuration tree:

```php
<?php declare(strict_types=1);

namespace App\Security;

use Ibexa\Bundle\Core\DependencyInjection\Configuration\ConfigBuilderInterface;
use Ibexa\Bundle\Core\DependencyInjection\Security\PolicyProvider\PolicyProviderInterface;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;

class FormPolicyProvider implements PolicyProviderInterface, TranslationContainerInterface
{
    public function addPolicies(ConfigBuilderInterface $configBuilder): void
    {
        $configBuilder->addConfig([
            'form' => [
                'read_submissions' => null,
            ],
        ]);
    }

    public static function getTranslationMessages(): array
    {
        return [
            (new Message('role.policy.form', 'forms'))->setDesc('Forms'),
            (new Message('role.policy.form.all_functions', 'forms'))->setDesc('Forms / All functions'),
            (new Message('role.policy.form.read_submissions', 'forms'))->setDesc('Forms / Read submissions'),
        ];
    }
}
```

Next, extract the [translations](#translations) to the `translations/forms.en.xlf` file.

Then, register the provider in the Kernel by overriding the `build()` method. Unlike standard Symfony runtime services, policy providers must be registered explicitly in the application kernel, because they are consumed during the container compilation phase.

```php
<?php

declare(strict_types=1);

namespace App;

use App\Security\FormPolicyProvider;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function build(ContainerBuilder $container): void
    {
        /** @var \Ibexa\Bundle\Core\DependencyInjection\IbexaCoreExtension $ibexaExtension */
        $ibexaExtension = $container->getExtension('ibexa');

        // Add the policy provider, you can register multiple providers by calling the method repeatedly
        $ibexaExtension->addPolicyProvider(new FormPolicyProvider());
    }
}
```

Then, add a service definition to `config/services.yaml`:

```yaml
services:
    # …
    App\Security\FormPolicyProvider:
        tags:
            - { name: ibexa.permissions.limitation_type }
```

Finally, add the policy definition in `src/Resources/config/policies.yaml`:

```yaml
form:
    read_submissions: ~
```

This way, after you clean the cache, the new policy becomes available when you [edit the policies assigned to a Role](../../../user/permission_management/work_with_permissions/index.md).

### Secure access on PHP API level

To enforce the policy on the PHP API level, decorate the form submission service to enforce permission checks. In `src/Security`, create the `FormSubmissionServiceDecorator.php` file:

```php
<?php declare(strict_types=1);

namespace App\Security;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo;
use Ibexa\Contracts\FormBuilder\FieldType\Model\Form;
use Ibexa\Contracts\FormBuilder\FieldType\Model\FormSubmission;
use Ibexa\Contracts\FormBuilder\FieldType\Model\FormSubmissionList;
use Ibexa\Contracts\FormBuilder\FormSubmission\FormSubmissionServiceInterface;
use Ibexa\Core\Base\Exceptions\NotFoundException;
use Ibexa\Core\Base\Exceptions\UnauthorizedException;
use Ibexa\FormBuilder\FormSubmission\Gateway\FormSubmissionGateway;

class FormSubmissionServiceDecorator implements FormSubmissionServiceInterface
{
    public function __construct(
        readonly FormSubmissionServiceInterface $innerService,
        readonly PermissionResolver $permissionResolver,
        readonly ContentService $contentService,
        readonly FormSubmissionGateway $gateway,
    ) {
    }

    public function create(ContentInfo $content, string $languageCode, Form $form, array $data): FormSubmission
    {
        return $this->innerService->create($content, $languageCode, $form, $data);
    }

    public function loadById(int $id): FormSubmission
    {
        $submissions = $this->gateway->loadById($id); // First manual data fetch

        if (empty($submissions)) {
            throw new NotFoundException('FormSubmission', $id);
        }

        $content = $this->contentService->loadContent($submissions[0]['content_id']);
        if (!$this->permissionResolver->canUser('form', 'read_submissions', $content)) {
            throw new UnauthorizedException('form', 'read_submissions', ['contentId' => $content->getId()]); // Permission check
        }

        return $this->innerService->loadById($id); // Second data fetch through inner service
    }

    // The same permission check pattern is repeated in the methods below

    public function delete(FormSubmission $submission): void
    {
        $submissionId = $submission->getId();
        $submissions = $this->gateway->loadById($submissionId);

        if (empty($submissions)) {
            throw new NotFoundException('FormSubmission', $submissionId);
        }

        $content = $this->contentService->loadContent($submissions[0]['content_id']);
        if (!$this->permissionResolver->canUser('form', 'read_submissions', $content)) {
            throw new UnauthorizedException('form', 'read_submissions', ['contentId' => $content->getId()]);
        }

        $this->innerService->delete($submission);
    }

    public function loadByContent(ContentInfo $content, ?string $languageCode = null, int $offset = 0, int $limit = 25): FormSubmissionList
    {
        if (!$this->permissionResolver->canUser('form', 'read_submissions', $content)) {
            throw new UnauthorizedException('form', 'read_submissions', ['contentId' => $content->getId()]);
        }

        return $this->innerService->loadByContent($content, $languageCode, $offset, $limit);
    }

    public function loadAllByContentForExport(ContentInfo $content, ?string $languageCode = null): array
    {
        if (!$this->permissionResolver->canUser('form', 'read_submissions', $content)) {
            throw new UnauthorizedException('form', 'read_submissions', ['contentId' => $content->getId()]);
        }

        return $this->innerService->loadAllByContentForExport($content, $languageCode);
    }

    public function loadHeaders(ContentInfo $content, ?string $languageCode = null): array
    {
        if (!$this->permissionResolver->canUser('form', 'read_submissions', $content)) {
            throw new UnauthorizedException('form', 'read_submissions', ['contentId' => $content->getId()]);
        }

        return $this->innerService->loadHeaders($content, $languageCode);
    }

    public function getCount(ContentInfo $content, ?string $languageCode = null): int
    {
        if (!$this->permissionResolver->canUser('form', 'read_submissions', $content)) {
            throw new UnauthorizedException('form', 'read_submissions', ['contentId' => $content->getId()]);
        }

        return $this->innerService->getCount($content, $languageCode);
    }
}
```

> **Note: Duplicate method calls**
>
> To perform a permission check for `$content`, it is fetched by `gateway->loadById($id)`. After permission is checked, `loadById($id)` is called again to prevent having to copy private method implementations into the decorator.

Then, add a service definition to `config/services.yaml`:

```yaml
services:
    # …
    App\Security\FormSubmissionServiceDecorator:
        decorates: Ibexa\FormBuilder\FormSubmission\FormSubmissionService
        arguments:
            $innerService: '@App\Security\FormSubmissionServiceDecorator.inner'
```

This way, users can't access the submission data unless they have the `form/read_submissions` policy added to their role.

### Secure back office access

To enforce the policy in the back office, decorate the **Submissions** tab to hide it when the user lacks permission. In `src/Security`, create the `FormSubmissionsTabDecorator.php` file:

```php
<?php declare(strict_types=1);

namespace App\Security;

use Ibexa\Contracts\AdminUi\Tab\ConditionalTabInterface;
use Ibexa\Contracts\AdminUi\Tab\OrderedTabInterface;
use Ibexa\Contracts\AdminUi\Tab\TabInterface;
use Ibexa\Contracts\Core\Repository\ContentTypeService;
use Ibexa\Contracts\Core\Repository\LanguageService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\SiteAccess\ConfigResolverInterface;
use Ibexa\Contracts\FormBuilder\FormSubmission\FormSubmissionServiceInterface;
use Ibexa\FormBuilder\FieldType\FormFactory;
use Ibexa\FormBuilder\FieldType\Type;
use Ibexa\FormBuilder\Tab\LocationView\SubmissionsTab;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

class FormSubmissionsTabDecorator extends SubmissionsTab implements TabInterface, OrderedTabInterface, ConditionalTabInterface
{
    public function __construct(
        Environment $twig,
        TranslatorInterface $translator,
        FormSubmissionServiceInterface $formSubmissionService,
        FormFactory $formFactory,
        ContentTypeService $contentTypeService,
        LanguageService $languageService,
        Type $formBuilderType,
        ConfigResolverInterface $configResolver,
        private readonly SubmissionsTab $innerTab,
        private readonly PermissionResolver $permissionResolver
    ) {
        parent::__construct($twig, $translator, $formSubmissionService, $formFactory, $contentTypeService, $languageService, $formBuilderType, $configResolver);
    }

    #[\Override]
    public function getIdentifier(): string
    {
        return $this->innerTab->getIdentifier();
    }

    #[\Override]
    public function getName(): string
    {
        return $this->innerTab->getName();
    }

    #[\Override]
    public function renderView(array $parameters): string
    {
        return $this->innerTab->renderView($parameters);
    }

    #[\Override]
    public function evaluate(array $parameters): bool
    {
        /** @var \Ibexa\Contracts\Core\Repository\Values\Content\Content $content */
        $content = $parameters['content'];

        return $this->innerTab->evaluate($parameters) &&
            $this->permissionResolver->canUser('form', 'read_submissions', $content);
    }

    #[\Override]
    public function getOrder(): int
    {
        return  $this->innerTab->getOrder();
    }
}
```

Then, add a service definition to `config/services.yaml`:

```yaml
services:
    # …
    App\Security\FormSubmissionsTabDecorator:
        parent: Ibexa\FormBuilder\Tab\LocationView\SubmissionsTab
        decorates: 'Ibexa\FormBuilder\Tab\LocationView\SubmissionsTab'
        arguments:
            $innerTab: '@.inner'
```

This way, users can't view the **Submissions** tab unless they have the `form/read_submissions` policy added to their role.
