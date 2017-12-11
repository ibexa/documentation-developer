# Step 7 - Customize the User forms

We want to have a consistent design over our web site. When using the pagelayout for the user forms, you see the design of your website. We want to welcome our new users with a pretty register page.

## Use custom template for user forms


At the same level than `pagelayout` add a `user_registration` directive so the beginning of your `views.yml` file looks like this:

```yaml
ezpublish:
    system:
        default:
            pagelayout: pagelayout.html.twig
            user:
                layout: pagelayout.html.twig
            user_registration:
                templates:
                    form: user/registration_form.html.twig
                    confirmation: user/registration_confirmation.html.twig
```
Then clear the cache with the command we have seen before: `php app/console cache:clear` to see the consequences of the addition you made. 
## Create the overriding templates files

You will create 3 Twig templates to manage the registration and the login forms, including confirmation page.

 * `registration_form.html.twig`: the main form file
 * `registration_content_form.html.twig`: the file with the design details for each field
 * `registration_confirmation.html.twig`: the page the user will see after registration

!!! note
    All the Twig templates come from the eZPlatform Demo, you can retrieve it on the Github repository: https://github.com/ezsystems/ezplatform-demo/tree/master/app/Resources/views/themes/demo/user

### Create the register form custom template

Let's begin with the register form. Create the file `/app/Resources/views/user/registration_form.html.twig` and fill it with this Twig tags.

``` html
{% extends pagelayout %}

{% block page_head %}
    {% set title = 'Register user'|trans %}

    {{ parent() }}
{% endblock %}

{% block content %}
    {% import 'user/registration_content_form.html.twig' as registrationForm %}

    <div class="container">
        <section class="user-form col-md-6 col-md-offset-3">
            <h2>{{ 'Member Registration'|trans }}</h2>
            <div class="legend">* {{ 'All fields are required'|trans }}</div>

            {{ registrationForm.display_form(form) }}
        </section>
    </div>
{% endblock %}
```
At the line 8, you see the import Twig function, that is calling the `user/registration_content_form.html.twig` file. So create this file along the previous file, and fill it with these Twig tags:
```html
{% macro display_form(form) %}
    {{ form_start(form) }}

    {% for fieldForm in form.fieldsData %}
        {% set fieldIdentifier = fieldForm.vars.data.fieldDefinition.identifier %}

        {% if fieldIdentifier == 'first_name' or fieldIdentifier == 'last_name' %}
            {% if fieldIdentifier == 'first_name' %}
                <div class="row">
            {% endif %}
            <div class="col-md-6">
                <div class="field-name">
                    <label class="required">{{ fieldForm.children.value.vars.label }}:</label>
                </div>
                {{ form_errors(fieldForm.value) }}
                {{ form_widget(fieldForm.value, {
                    'contentData': form.vars.data
                }) }}
            </div>
            {% if fieldIdentifier == 'last_name' %}
                </div>
            {% endif %}
        {% endif %}

        {% if fieldIdentifier == 'user_account' %}
            <div class="row">
                <div class="col-md-6">
                    {{ form_widget(fieldForm.value, {
                        'contentData': form.vars.data
                    }) }}
                </div>
            </div>
        {% endif %}

        {%- do fieldForm.setRendered() -%}
    {% endfor %}

    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            {{ form_widget(form.publish, {'attr': {
                'class': 'btn btn-block btn-primary'
            }}) }}
        </div>
    </div>

    {{ form_end(form) }}
{% endmacro %}
```
If you want to check the look of your new page, first clear the cache, then get your <yourdomain>/register URL.

### Create the confirmation page template
Now create a file `app/Resources/views/user/registration_confirmation.html.twig` along the previous files.

Put these Twig tags in the file:
```html
{% extends pagelayout %}

{% block page_head %}
  {% set title = 'Registerstration complete'|trans %}

  {{ parent() }}
{% endblock %}

{% block content %}
  <div class="container">
    <section class="user-form-confirmation col-md-4 col-md-offset-4">
      <h2>{{ 'Registration completed'|trans }}</h2>

      <div class="row confirmation-label">
        {{ 'You are all set up and ready to go'|trans }}
      </div>

      <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <button type="button" class="btn btn-block btn-primary"
                  onclick="window.location='{{ path('login') }}';">{{ 'Log in'|trans }}</button>
        </div>
      </div>
    </section>
  </div>
{% endblock %}

```

Now you are able to customize the user registration of your website.
