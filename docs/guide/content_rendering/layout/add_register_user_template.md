# Add user registration form

You can add to your website a registration form for your users.
Follow the instructions below to create and customize templates for the registration form and registration confirmation page.

First, make sure you [enabled user registration](../../../tutorials/platform_beginner/8_enable_account_registration.md#enable-registration).

Next, in the `config/packages/views.yaml` file, under the site, at the same level as `content_view` add the following configuration:

``` yaml
ezplatform:
    system:
        default:
            user_registration:
                templates:
                    form: user/registration_form.html.twig
```
This defines which template will be used for rendering the registration form.

Create the `templates/user/registration_form.html.twig` template:

``` html+twig
{% extends no_layout is defined and no_layout == true ? view_base_layout : page_layout %}
{% block content %}
    <section class="ez-content-edit">
        {{ form_start(form) }}

        {% for fieldForm in form.fieldsData %}
            {% set fieldIdentifier = fieldForm.vars.data.fieldDefinition.identifier %}
            <div class="col-md-6">
                {{ form_widget(fieldForm.value, {
                    'contentData': form.vars.data
                }) }}
            </div>
            {%- do fieldForm.setRendered() -%}
        {% endfor %}

        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                {{ form_widget(form.register, {'attr': {
                    'class': 'btn btn-block btn-primary'
                }}) }}
            </div>
        </div>

        {{ form_end(form) }}
    </section>
{% endblock %}
```

Now you have to define the template which renders the confirmation page displayed after a user completes the registration process.
Add the new template to the configuration. In the `config/packages/views.yaml`, add the `confirmation` key:

``` yaml
ezplatform:
    system:
        default:
            user_registration:
                templates:
                    form: user/registration_form.html.twig
                    confirmation: user/registration_confirmation.html.twig
```

In the `templates/user/registration_confirmation.html.twig`, create the confirmation template file:

``` html+twig
{% extends no_layout is defined and no_layout == true ? view_base_layout : page_layout %}
{% block content %}
    <h1>Your account has been created</h1>
    <p class="user-register-confirmation-message">
        Thank you for registering an account. You can now <a href="{{ path('login') }}">login</a>.
    </p>
{% endblock %}
```
