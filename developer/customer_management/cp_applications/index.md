# Customer Portal applications

Customization of an approval process for new companies applications.

Editions: Experience

New business customers can apply for a company account. Applications go through the approval process in the back office where they can be accepted, rejected or put on hold. If they're accepted, the business partner receives an invitation link to the Customer Portal, where they can set up their team and manage their account.

For more information on company self-registration, see [user guide documentation](../../../user/customer_management/company_self_registration/index.md). If provided options are too limited, you can customize an approval process by yourself.

## Roles and policies

Any user can become application approver, as long as they have the `Company Application/Workflow` policy assigned to their role. There, you can define between which states the user may move applications. For example, the assistant can put new applications on hold, or reject them, and only the manager can accept them.

![Company Application policy](https://doc.ibexa.co/en/5.0/customer_management/img/cp_company_application_policy.png)

## Customer Portal application configuration

Below, you can find possible configurations for Customer Portal applications.

### Reasons for rejecting application

To change or add reasons for not accepting Corporate Portal application go to `vendor/ibexa/corporate-account/src/bundle/Resources/config/default_settings.yaml`.

```yaml
parameters:
    ibexa.site_access.config.default.corporate_accounts.reasons:
        reject: [Malicious intent / Spam]
        on_hold: [Verification in progress]
```

### Timeout

Registration form locks for 5 minutes after unsuccessful registration, if the user, for example, tried to use an email address that already exists in a Customer Portal clients database. To change that duration, go to `config/packages/ibexa.yaml`.

```yaml
framework:
    rate_limiter:
        corporate_account_application:
            policy: 'fixed_window'
            limit: 1
            interval: '5 minutes'
            lock_factory: 'lock.corporate_account_application.factory'
```

## Customization of an approval process

In this procedure, you add a new status to the approval process of business account application.

### Add new status

First, under the `ibexa.system.<scope>.corporate_accounts.application.states` add a `verify` status to the [configuration](../../administration/configuration/configuration/index.md#configuration-files):

```yaml
ibexa:
    system:
        default:
            corporate_accounts:
                application:
                    states: [ 'new', 'accept', 'on_hold', 'reject', 'verify' ]
```

### Create new Form Type

Next, create a new form type in `src/Form/VerifyType.php`. It's displayed in the application review stage.

```php
<?php

declare(strict_types=1);

namespace App\Corporate\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class VerifyType extends AbstractType
{
    private const string FIELD_APPLICATION = 'application';
    private const string FIELD_NOTES = 'notes';
    private const string FIELD_VERIFY = 'verify';

    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add(self::FIELD_APPLICATION, HiddenType::class)
            ->add('new_field', TextType::class)
            ->add(self::FIELD_NOTES, TextareaType::class, [
                'required' => false,
            ])
            ->add(self::FIELD_VERIFY, SubmitType::class);
    }
}
```

Line 29 defines where the form should be displayed, line 21 adds **Note** field, and line 22 adds the **Verify** button.

### Create event subscriber to pass the form

Add an event subscriber that passes a new form type to the frontend. Create `src/Corporate/EventSubscriber/ApplicationDetailsViewSubscriber.php` following the example below:

```php
<?php

declare(strict_types=1);

namespace App\Corporate\EventSubscriber;

use App\Corporate\Form\VerifyType;
use Ibexa\Bundle\CorporateAccount\EventSubscriber\AbstractViewSubscriber;
use Ibexa\Core\MVC\Symfony\SiteAccess\SiteAccessServiceInterface;
use Ibexa\Core\MVC\Symfony\View\View;
use Ibexa\CorporateAccount\View\ApplicationDetailsView;
use Symfony\Component\Form\FormFactoryInterface;

final class ApplicationDetailsViewSubscriber extends AbstractViewSubscriber
{
    public function __construct(
        SiteAccessServiceInterface $siteAccessService,
        private readonly FormFactoryInterface $formFactory
    ) {
        parent::__construct($siteAccessService);
    }

    /**
     * @param \Ibexa\CorporateAccount\View\ApplicationDetailsView $view
     */
    protected function configureView(View $view): void
    {
        $application = $view->getApplication();

        $view->addParameters([
            'verify_form' => $this->formFactory->create(
                VerifyType::class,
                [
                    'application' => $application->getId(),
                ]
            )->createView(),
        ]);
    }

    protected function supports(View $view): bool
    {
        return $view instanceof ApplicationDetailsView;
    }
}
```

In line 39, you can see the `verify_form` parameter that passes the `verify` form to the application review view.

### Add form template

To be able to see the changes you need to add a new template `templates/themes/admin/corporate_account/application/details.html.twig`.

```html+twig
{% extends "@IbexaCorporateAccount/themes/admin/corporate_account/application/details.html.twig" %}

{% block content %}
    {{ form_start(verify_form, { action: path('ibexa.corporate_account.application.workflow.state', {
        state: 'verify',
        applicationId: application.id,
    }), method: 'POST'}) }}
    {{ form_row(verify_form.notes) }}

    <div class="ibexa-ca-application-workflow-extra-actions__btns">
        {{ form_widget(verify_form.verify, { attr: {
            class: 'ibexa-btn ibexa-btn--primary ibexa-ca-application-workflow-extra-actions__btn',
        }}) }}
    </div>
    {{ form_end(verify_form) }}

    {{ parent() }}
{% endblock %}
```

It overrides the default view and adds a **Verify** button to the review view. To check the progress, go to **Members** -> **Applications**. Select one application from the list and inspect application review view for a new button.

![Verify button](https://doc.ibexa.co/en/5.0/customer_management/img/cp_new_status.png)

### Create event subscriber to verify state

Now, you need to pass the information that the button has been selected to the list of applications to change the application status. Create another event subscriber that passes the information from the created form to the application list `src/Corporate/EventSubscriber/VerifyStateEventSubscriber.php`.

```php
<?php

declare(strict_types=1);

namespace App\Corporate\EventSubscriber;

use App\Corporate\Form\VerifyType;
use Ibexa\Contracts\AdminUi\Notification\TranslatableNotificationHandlerInterface;
use Ibexa\Contracts\CorporateAccount\Event\Application\Workflow\ApplicationWorkflowFormEvent;
use Ibexa\Contracts\CorporateAccount\Event\Application\Workflow\MapApplicationWorkflowFormEvent;
use Ibexa\CorporateAccount\Event\ApplicationWorkflowEvents;
use Ibexa\CorporateAccount\Persistence\Legacy\ApplicationState\HandlerInterface;
use Ibexa\CorporateAccount\Persistence\Values\ApplicationStateUpdateStruct;
use JMS\TranslationBundle\Annotation\Desc;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormFactoryInterface;

final readonly class VerifyStateEventSubscriber implements EventSubscriberInterface
{
    private const string VERIFY_STATE = 'verify';

    public function __construct(
        private FormFactoryInterface $formFactory,
        private HandlerInterface $applicationStateHandler,
        private TranslatableNotificationHandlerInterface $notificationHandler
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            MapApplicationWorkflowFormEvent::class => 'mapApplicationWorkflowForm',
            ApplicationWorkflowEvents::getStateEvent(self::VERIFY_STATE) => 'applicationVerify',
        ];
    }

    public function mapApplicationWorkflowForm(MapApplicationWorkflowFormEvent $event): void
    {
        if ($event->getState() === self::VERIFY_STATE) {
            $form = $this->formFactory->create(VerifyType::class, $event->getData());

            $event->setForm($form);
        }
    }

    public function applicationVerify(ApplicationWorkflowFormEvent $event): void
    {
        $data = $event->getData();

        if (!is_array($data)) {
            return;
        }

        $applicationStateUpdateStruct = new ApplicationStateUpdateStruct($event->getApplicationState()->getId());
        $applicationStateUpdateStruct->state = self::VERIFY_STATE;

        $this->applicationStateHandler->update($applicationStateUpdateStruct);

        $this->notificationHandler->success(
            /** @Desc("Application moved to Verification state") */
            'application.state.verify.notification',
            [],
            'corporate_account_application'
        );
    }
}
```

In line 46, you can see that it handles changes to verify status. The subscriber only informs that the status has been changed (line 72).

Now, if you click the **Verify** button during application review, the application gets **Verify** status.

![Verify status](https://doc.ibexa.co/en/5.0/customer_management/img/cp_verify_status.png)
