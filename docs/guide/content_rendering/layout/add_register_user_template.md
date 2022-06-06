# Create user registration form

You can create a registration form for users to your website.
Follow the instructions below to create and customize templates for a registration form, and a registration confirmation page.

First, make sure you [enabled user registration](../../permission_use_cases.md#register-users).

Next, in the `config/packages/views.yaml` file add the following configuration:

``` yaml
ibexa:
    system:
        default:
            user_registration:
                templates:
                    form: '@ibexadesign/user/registration_form.html.twig'
                    confirmation: '@ibexadesign/user/registration_confirmation.html.twig'
```
This defines which templates will be used for rendering the registration form and confirmation page.

In the `templates/themes/<theme_name>/user/registration_form.html.twig` create the template for registration form.

Example registration form:

``` html+twig
{% extends no_layout is defined and no_layout == true ? view_base_layout : page_layout %}
{% block content %}
    <section class="ibexa-content-edit">
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

In the `templates/themes/<theme_name>/user/registration_confirmation.html.twig`, create the template for confirmation form.

Example confirmation form:

``` html+twig
{% extends no_layout is defined and no_layout == true ? view_base_layout : page_layout %}
{% block content %}
    <h1>Your account has been created</h1>
    <p class="user-register-confirmation-message">
        Thank you for registering an account. You can now <a href="{{ path('login') }}">login</a>.
    </p>
{% endblock %}
```
To add a link redirecting to the login form, in the page layout template, provide the following code:

```html+twig
<a href="{{ path('ibexa.user.register') }}">Register</a>
```
