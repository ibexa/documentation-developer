---
description: See how you can enable external users to register and contribute to your site.
---

# Step 8 — Enable account registration

In this step you enable other users to create accounts on your site, access the back office and create content.

## Enable registration

In the main menu, go to **Admin** (gear icon) -> **Roles**, and click the **Anonymous** role.

![Available roles](step_8_role_mgmt_screen.png)

Add the `User/Register` policy to the Anonymous user.
This allows any visitor to the website to access the registration form.

![Policies for the Anonymous Role](step8_admin_anonymous_policies.png)

Then go to `<yourdomain>/register`.
The registration form is unstyled, so you need to add templates to it.

## Customize registration forms

In the `config/packages/views.yaml` file add a `user_registration` key under `site`, at the same level as `content_view`:

``` yaml
ibexa:
    system:
        site:
            # existing content_view keys
            user_registration:
                templates:
                    form: user/registration_form.html.twig
```

This indicates which template is used to render the registration form.

Create the file `templates/user/registration_form.html.twig`:

``` html+twig hl_lines="10"
{% extends "main_layout.html.twig" %}

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

In line 10 you can see that another file is imported: `registration_content_form.html.twig`.
The second template renders the actual fields of the registration form.
Create this file as well (as `templates/user/registration_content_form.html.twig`):

``` html+twig
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
            {{ form_widget(form.register, {'attr': {
                'class': 'btn btn-block btn-primary'
            }}) }}
        </div>
    </div>

    {{ form_end(form) }}
{% endmacro %}
```

The third template you need to prepare covers the confirmation page that is displayed when a user completes the registration.
First, point to the new template in the configuration.
Add a `confirmation` key to `config/packages/views.yaml`:

``` yaml hl_lines="4"
user_registration:
    templates:
        form: user/registration_form.html.twig
        confirmation: user/registration_confirmation.html.twig
```

Then create the `templates/user/registration_confirmation.html.twig` template:

``` html+twig
{% extends "main_layout.html.twig"  %}

{% block page_head %}
  {% set title = 'Registration complete'|trans %}

  {{ parent() }}
{% endblock %}

{% block content %}
    <div class="container">
        <section class="user-form-confirmation col-md-4 col-md-offset-4">
            <h2>{{ 'Registration completed'|trans }}</h2>

            <div class="row confirmation-label">
                {{ 'You're all set up and ready to go'|trans }}
            </div>

            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <button type="button" class="btn btn-block btn-primary" onclick="window.location='{{ path('login') }}';">{{ 'Log in'|trans }}</button>
                </div>
            </div>
        </section>
    </div>
{% endblock %}
```

Now return to `<yourdomain>/register`:

![Complete Register page with the layout](step8_register_page.png)

Fill in the form and register a user.

!!! tip

    If you log in as the new user at this point, you need to go to the back office (`<yourdomain>/admin`) to log out again re-log in as Admin.

## Set up Permissions

Users created through the registration form are placed in the _Guest accounts_ user group.
The user you created has the roles assigned to this group.

!!! tip

    You can change the group in which new users are placed (but you don't need to do it for this tutorial).
    For more information, see [Registering new users](user_registration.md).

At this point you don't want anyone who registers to be able to add content to the website.
That's why you need to create a new user group with additional permissions.
When the administrator accepts a new user, they can move them to this new group.

### Create a user group

In the back office, go to **Admin** -> **Users**, click the **Create content** button and create a user group named `Go Bike Members`.

### Create a Folder for contributed Rides

Go to the `All Rides` Folder and create inside it a new Folder named `Member Rides`.
Go Bike Members are only able to create Content in this Folder.

### Set permissions for Go Bike Members

From Admin in the **Roles** screen, create a new role named *Contributors*.

Now add the following policies to the Contributors role.

- User/Login
- User/Password
- Content/Read
- Content/Versionread
- Content/Create with limitations: content type limited to Ride and Landmark content types and subtree to the `Member Rides`
- Content/Publish with limitations: content type limited to Ride and Landmark content types and subtree to the `Member Rides`
- Content/Edit with limitation: Owner limited to `Self`
- Section/View
- Content/Reverserelatedlist

!!! tip

    The limitations are a powerful tool for fine-tuning the permission management of the users.
    See [the documentation about limitations for more technical details](limitation_reference.md#content-type-group-limitation).

Once the policies are set, go to the **Assignments** tab and assign the role to the user group *Go Bike Members*.

Next, go to the users page.
Select the user you created and move them into the *Go Bike Members* user group.

### Create content as a Go Bike Member

Log out as admin and then log in again into the back office with the credentials of the new user.
You now have the ability to create new Rides and Landmarks in the selected folder.

## Congratulations!

Now you have created your first website with [[= product_name =]].

**You learned how to:**

- create a content model
- organize files in an [[= product_name =]] project
- configure views for different content types
- add assets to an [[= product_name =]] project
- use and configure Webpack Encore
- use Twig templates and controllers to display content
- enable user registration
- manage user permissions
