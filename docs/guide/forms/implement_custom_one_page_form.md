# Implement custom one-page form [[% include 'snippets/commerce_badge.md' %]]

This example shows how to implement a form for ordering the product catalog in a printed form.

The user inputs their email address and confirms that they want to order the catalog.
An email is then sent to the shop administrator.

## Step 1: Build the form components

The basic form components are:

- Form entity
- Form type
- Form template

### Form entity

Form entity is a simple class that holds the data. No business logic is defined here.
This is the place where you have to define:

- form attributes
- [validation](form_api/form_api.md#form-validators)

Every form entity has to extend `AbstractFormEntity`.

``` php
namespace Company\Bundle\ProjectBundle\Form;

use Silversolutions\Bundle\EshopBundle\Entities\Forms\AbstractFormEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Silversolutions\Bundle\EshopBundle\Entities\Forms\Constraints as SesAssert;

class OrderCatalog extends AbstractFormEntity
{
    /**
     * @Assert\NotBlank()
     * 
     * @var bool
     */
    protected $orderCatalog;

    /**
    * @Assert\NotBlank()
    * @SesAssert\Email() 
    *
    * @var string
    */
    protected $email;   

    /**
     * @return string
     */
    public function getOrderCatalog()
    {
        return $this->orderCatalog;
    }

    /**
     * @param string $orderCatalog
     */
    public function setOrderCatalog($orderCatalog)
    {
        $this->orderCatalog = $orderCatalog;
    }

    /**
    * @return string
    */
    public function getEmail()
    {
        return $this->email;
    }

    /**
    * @param string $email
    */
    public function setEmail($email)
    {
        $this->email = $email;
    }
}
```

### Form type

Form type defines which form attributes are rendered and how.
You can define other data here, such as labels, CSS classes, data attributes, etc.

You define this type as a service, so you can inject any logic that you need.

``` php
namespace Company\Bundle\ProjectBundle\Form\Type;

use eZ\Publish\Core\MVC\ConfigResolverInterface;
use Silversolutions\Bundle\TranslationBundle\Services\TransService;
use Siso\Bundle\ToolsBundle\Service\CountryServiceInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraint;

class OrderCatalogType extends AbstractType
{
    /**
    * Dependency to the silversolutions translation service.
    *
    * @var \Silversolutions\Bundle\TranslationBundle\Services\TransService
    */
    protected $transService;

    /**    
     * @param TransService $transService   
     */
    public function __construct(       
        TransService $transService       
    ) {       
        $this->transService = $transService;       
    }

    /**
     * Builds the form with all fields in required type and sets fields options
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder  
            ->add('email', 'text', array(               
                'required' => true,
                'label' => $this->transService->translate('email')
            ))  
            ->add('orderCatalog', 'checkbox', array(
                'required' => true,
                'label' => $this->transService->translate('orderCatalog')
            ))
        ;
    }

    /**
     * configure form options
     *
     * @param OptionsResolver $resolver
     * @return void
     *
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => function(FormInterface $form) {
                $groups = array();
                $groups[] = Constraint::DEFAULT_GROUP;
                return $groups;
            },
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'company_order_catalog_type';
    }
}
```

Service definition:

``` xml
<service id="company.order_catalog_type" class="Company\Bundle\ProjectBundle\Form\Type\OrderCatalogType">
    <argument type="service" id="silver_trans.translator" />    
</service>
```

### Form template

Then you need to prepare template that renders the form.
See [How to render Symfony forms](https://symfony.com/doc/3.4/form/form_customization.html) for more information.

``` html+twig
{% extends "SilversolutionsEshopBundle::pagelayout.html.twig"|st_resolve_template %}
 
{% block content %}
<form action="{{ path('silversolutions_service', {'formTypeResolver': 'order_catalog'}) }}"
  method="post" {{ form_enctype(form) }}>
  {{ form_errors(form) }} 
    
    <div{% if form.email.vars.errors is not empty %} class="error"{% endif %}>
      {{ form_label(form.email) }}
      {{ form_widget(form.email) }}
    </div>
    <div{% if form.orderCatalog.vars.errors is not empty %} class="error"{% endif %}>
      {{ form_label(form.orderCatalog) }}
      {{ form_widget(form.orderCatalog) }}
    </div>
 {{ form_rest(form) }}
  <span>* {{ 'required fields'|st_translate }}</span>
  <button type="submit" class="button right" name="order_catalog">{{ 'Order Catalog'|st_translate }}</button>
</form>
{% endblock %} 
```

## Step 2: Prefill the form and implement the processes behind

### Prefill the form

You can implement a service that pre-fills the form with default data.
This uses `preDataProcessor`.

This step is optional.

``` php
namespace Company\Bundle\ProjectBundle\Service\DataProcessor;

use Silversolutions\Bundle\EshopBundle\Services\Forms\DataProcessor\AbstractDataProcessor;
use Silversolutions\Bundle\EshopBundle\Services\CustomerProfileData\CustomerProfileDataServiceInterface;
use Company\Bundle\ProjectBundle\Form\OrderCatalog;

class PreFillOrderCatalogDataProcessor extends AbstractDataProcessor
{
    const SUCCESSFUL_LAST_RESULT_KEY = 'order_catalog';

    /** @var CustomerProfileDataServiceInterface */
    protected $customerProfileDataService;

    public function __construct(
        CustomerProfileDataServiceInterface $customerProfileDataService,    
    ) {
        $this->customerProfileDataService = $customerProfileDataService;        
    }

    /**
     * @param NormalizedEntity $formEntity
     * @param null $lastResult
     * @param Response $response
     * @return mixed|null
     * @throws \Silversolutions\Bundle\EshopBundle\Exceptions\FormDataProcessorException
     */
    public function execute(NormalizedEntity $formEntity, $lastResult = null, Response $response = null)
    {             
        if (!$this->customerProfileDataService->isUserAnonymous()) {

            /** @var OrderCatalog $orderCatalog */
            $orderCatalog = $formEntity->getOriginalForm();

            //prefill form with user email address
            $customerProfileData = $this->customerProfileDataService->getCustomerProfileData();
            $orderCatalog->setEmail($customerProfileData->sesUser->email);
        }        

        return $lastResult;
    }    
} 
```

Service definition:

``` xml
<service id="company.pre_data_processor.pre_fill_order_catalog"
         class="Company\Bundle\ProjectBundle\Service\DataProcessor\PreFillOrderCatalogDataProcessor">    
    <argument type="service" id="ses.customer_profile_data.ez_erp" />
</service>
```

### Implement the processes behind

Implement one or more `dataProcessors` that are executed after the form is submitted.

``` php
namespace Company\Bundle\ProjectBundle\Service\DataProcessor;

use Silversolutions\Bundle\EshopBundle\Entities\Forms\Normalize\Entity as NormalizedEntity;
use Silversolutions\Bundle\EshopBundle\Services\Forms\DataProcessor\AbstractDataProcessor;
use Silversolutions\Bundle\TranslationBundle\Services\TransService;
use Siso\Bundle\ToolsBundle\Service\MailHelperServiceInterface;

class OrderCatalogSendEmailDataProcessor extends AbstractDataProcessor
{
    const SUCCESSFUL_LAST_RESULT_KEY = 'mail_send';
    const SUBJECT_CONTACT_FORM = 'Order catalog e-mail';

    /** @var TransService $translation */
    protected $translation;  

    /** @var MailHelperServiceInterface */
    protected $mailService;

    /**
     * contains mail values from the configuration such as mail receiver or mail sender
     *
     * @var array $mailValues
     */
    protected $mailValues;

    /**
     * @param MailHelperServiceInterface $mailService
     * @param \Silversolutions\Bundle\TranslationBundle\Services\TransService $translation    
     */
    public function __construct(
        MailHelperServiceInterface $mailService,
        TransService $translation       
    ) {
        $this->mailService = $mailService;
        $this->translation = $translation;       
    }

    /**
     * sets mail values from the configuration
     *
     * @param array $mailValues
     */
    public function setMailValues($mailValues)
    {
        $this->mailValues = $mailValues;
    }

    /**
     * @param NormalizedEntity $formEntity
     * @param array|null $lastResult
     * @param Response $response
     * @return mixed|null
     * @throws \Silversolutions\Bundle\EshopBundle\Exceptions\FormDataProcessorException
     */
    public function execute(NormalizedEntity $formEntity, $lastResult = null, Response $response = null)
    {
        try {
            $sender = $this->mailValues['mailSender'];
            $recipient = $this->mailValues['orderCatalogMailReceiver'];

            $this->mailService->sendMailWithRenderedTemplate(
                $sender,
                $recipient,
                self::SUBJECT_CONTACT_FORM,
                'CompanyBundle:Emails:order_catalog.txt.twig',
                'CompanyBundle:Emails:order_catalog.html.twig',
                array(
                    'orderCatalogMailReceiver' => $recipient,
                    'form' => $formEntity->originalForm,
                )
            );           

            $lastResult[self::SUCCESSFUL_LAST_RESULT_KEY] = true;

        } catch (\Exception $e) {            
            $lastResult['_exceptions'][] = 'Error occured when sending the email.';
        }

        return $lastResult;
    }
} 
```

Service definition:

``` xml
<service id="company.data_processor.order_catalog_send_email"
         class="Company\Bundle\ProjectBundle\Service\DataProcessor\OrderCatalogSendEmailDataProcessor">
    <argument type="service" id="siso_tools.mailer_helper" />
    <argument type="service" id="silver_trans.translator" />    
    <call method="setMailValues">
        <argument>$ses_swiftmailer;siso_core$</argument>
    </call>
</service>
```

## Step 3: Configure the form

Create form configuration to build a fully-functional one-page form:

``` yaml
parameters:
    ses_forms.configs.order_catalog:
        modelClass: Company\Bundle\ProjectBundle\Form\OrderCatalog
        typeService: company.order_catalog_type
        template: CompanyProjectBundle:Forms:order_catalog.html.twig
        invalidMessage: error_message_order_catalog
        validMessage: success_order_catalog
        preDataProcessor: company.pre_data_processor.pre_fill_order_catalog       
        dataProcessors:
            - company.data_processor.order_catalog_send_email
```

### Form URL

You can use any of the predefined [`FormsController::formsAction` routes](form_templates.md) to call the form,
or even define a new one. In this example use following route:

``` html+twig
<form action="{{ path('silversolutions_service', {'formTypeResolver': 'order_catalog'}) }}"
  method="post" {{ form_enctype(form) }}>
```

Call the form by the `/service/order_catalog` URL.
