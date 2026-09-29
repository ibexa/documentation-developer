# Step 5 — Create a newsletter form

Learn how to create a sign-up form and how to view and manage its submissions.

Editions: Experience

The final step of this tutorial assists you in adding to the home page a Form block for signing up to a newsletter.

> **Caution: Known limitation**
>
> To have multiple instances of the same form on one page, create several identical form blocks. Otherwise, you may encounter issues with submitting data from all forms at the same time.

## Add a Form block

Start with creating a Form content item. In the main menu, go to **Content** -> **Forms**, click **Create content** and select **Form**. Provide the title, for example, "Sign up for Newsletter" and click **Build form**.

In the Form Builder, add and configure (using the **Basic** and **Validation** tabs) the following form fields:

| Form field        | Name          | Required | Additional properties                                 |
| ----------------- | ------------- | -------- | ----------------------------------------------------- |
| Single line input | Name          | yes      | Minimum length = 3                                    |
| Single line input | Surname       | no       | Minimum length = 3                                    |
| Dropdown          | Select topic  | yes      | Options: - News - Tips - Articles                     |
| Email             | Email address | yes      | —                                                     |
| Captcha           | CAPTCHA       | —        | —                                                     |
| Button            | Sign up!      | —        | Action: Show a message Message to display: Thank you! |

The configuration should look like this:

![Adding fields to Newsletter Form](https://doc.ibexa.co/en/5.0/tutorials/page_and_form_tutorial/img/enterprise_tut_form_creation.png "Adding fields to Newsletter Form")

When you add all the fields, save the form and click **Publish**. Now you can edit the front page and add a Form block below the Random block. Edit the block and select the form you created. Click **Submit**.

The Page should refresh with the Form block.

![Newsletter Form Block](https://doc.ibexa.co/en/5.0/tutorials/page_and_form_tutorial/img/enterprise_tut_first_form.png "Raw Newsletter Form Block")

It clearly differs from the page design, so you also need to customize the block's layout.

## Change the block template

First, add a new template for the Form block to align it with the Random block design. Create a `newsletter.html.twig` file in `templates/blocks/form/`:

```html+twig
<div class="row">
    <div class="block-form {{ block_class }}">
        {{ ibexa_http_cache_tag_relation_location_ids(locationId) }}
        {{ render(controller('ibexa_content::viewAction', {
            'contentId': contentId,
            'locationId': locationId,
            'viewType': 'embed'
        })) }}
        <style type="text/css">{{ block_style|raw }}</style>
    </div>
</div>
```

This template extends the default block layout by adding an additional class (line 1) that shares CSS styling with the Random block.

Append the new template to the block by adding it to `config/packages/ibexa_fieldtype_page.yaml`. Add the following configuration under the `blocks` key at the same level as other block names, for example, `random`:

```yaml
        form:
            views:
                default:
                    template: blocks/form/newsletter.html.twig
                    name: Newsletter Form View
```

Now you have to apply the template to the block. Go back to editing the page. Edit the Form block again. In the **Design** tab, select the **Newsletter Form View** and click **Submit**.

The block remains unchanged, but the results are visible when you add CSS styling.

## Change the field template

At this point, you need to change the field template. This results in alternating the position and design of the Form fields.

Create a `form_field.html.twig` file in `templates/fields/`:

```html+twig
{% block ibexa_form_field %}
    {% set formValue = field.value.getForm() %}
    {% if formValue %}
        {% set form = formValue.createView() %}
        {% form_theme form 'bootstrap_4_layout.html.twig' %}
        {% apply spaceless %}
            {% if not ibexa_field_is_empty(content, field) %}
                {{ form(form) }}
            {% endif %}
        {% endapply %}
    {% endif %}
{% endblock %}
```

Next, assign the template to the page. In `config/packages/views.yaml`, at the same level as `page_layout`, add:

```yaml
            field_templates:
                - { template: fields/form_field.html.twig, priority: 30 }
```

Clear the cache by running `bin/console cache:clear` and refresh the page to see the results.

## Configure the Form field

Before applying the final styling of the block, you need to configure the [CAPTCHA field](../../../content_management/forms/work_with_forms/index.md#captcha-field). In `config/packages`, add a `gregwar_captcha.yaml` file with the following configuration:

```yaml
gregwar_captcha:
    width: 150
    invalid_message: Please, enter again.
    length: 4
```

The configuration resizes the CAPTCHA image (line 2), changes the error message (line 3), and shortens the authentication code (line 4).

## Add stylesheet

The remaining step in configuring the block is adding CSS styling. Add the following code to `assets/css/style.css`:

```css
/* Newsletter Form block */
.block-form {
    border: 1px solid #8b7f7b;
    border-radius: 5px;
    padding: 0 25px 25px 25px;
    margin-top: 15px;
}

.block-form .ibexa_string-field {
    display: inline-block;
    font-variant: small-caps;
    font-size: 1.2em;
    width: 100%;
    text-align: right;
    padding-top: 20px;
}

.block-form .col-form-label {
    display: none;
}

.block-form .form-group {
    font-variant: small-caps;
    font-size: 1em;
    margin-top: 12px;
}

.captcha_image {
    padding-left: 10px;
    padding-bottom: 10px;
}

.captcha_reload {
    font-variant: all-small-caps;
    padding-left: 5px;
}

.btn-primary {
    background-color: rgb(103,85,80);
    border-color: rgb(103,85,80);
    margin-top: 15px;
    margin-bottom: -20px;
}

.block-form h3 {
    font-variant: all-small-caps;
    text-align: center;
}
```

Reinstall the assets and clear the cache by running the following commands:

```bash
yarn encore <dev|prod>
php bin/console cache:clear
```

Your newsletter form block is ready.

![Newsletter Form Block](https://doc.ibexa.co/en/5.0/tutorials/page_and_form_tutorial/img/enterprise_tut_final_form.png "Newsletter Form Block")

Refresh the page and enter a couple of mock submissions.

## Manage the submissions

You can view all submissions in the back office. Go to **Forms** page. From the content tree, select the Form and click the **Submissions** tab. There, after selecting submission(s), click **Download submissions** or **Delete submission**. To see details about a submission, click the view icon.

![Collect Form Submissions](https://doc.ibexa.co/en/5.0/tutorials/page_and_form_tutorial/img/enterprise_tut_form_collect_sub.png "Collect Form Submissions")

For more information, see [viewing form results](../../../../user/content_management/work_with_forms/index.md#view-results).

## Congratulations!

You have finished the tutorial and created your first customized page.

You have learned how to:

- Create and customize a Page
- Make use of existing blocks and adapt them to your needs
- Plan content airtime using the Content Scheduler block
- Create custom blocks
- Use Form Builder and configure your form
- Apply custom styling to blocks

![Final result of the tutorial](https://doc.ibexa.co/en/5.0/tutorials/page_and_form_tutorial/img/enterprise_tut_main_screen.png "Final result of the tutorial")
