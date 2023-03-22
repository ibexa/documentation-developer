---
description: Learn how to create a sign-up form and how to view and manage its submissions.
edition: experience
---

# Step 5 — Create a newsletter form

The final step of this tutorial assists you in adding to the home page a Form block for signing up to a newsletter.

[[% include 'snippets/forms_caution.md' %]]
    
### Add a Form block

Start with creating a Form Content item.
In the left menu select **Forms**, click **Create content** and select **Form**.
Provide the title, for example, "Sign up for Newsletter" and click **Build form**.

In the Form Builder, add and configure (using the **Basic** and **Validation** tabs) the following form fields:

|Form field|Name|Required|Additional properties|
|-----|----|--------|---------------------|
|Single line input|Name|yes|Minimum length = 3|
|Single line input|Surname|no|Minimum length = 3|
|Dropdown|Select topic|yes|Options:</br>- News</br>- Tips </br> - Articles|
|Email|Email address|yes|—|
|Captcha|CAPTCHA|—|—|
|Button|Sign up!|—|Action: Show a message</br>Message to display: Thank you!|

The configuration should look like this:

![Adding Fields to Newsletter Form](enterprise_tut_form_creation.png "Adding Fields to Newsletter Form")

When you add all the fields, save the form and click **Publish**.
Now you can edit the Front Page and add a Form block below the Random block.
Edit the block and select the form you created. Click **Submit**.

The Page should refresh with the Form block.

![Newsletter Form Block](enterprise_tut_first_form.png "Raw Newsletter Form Block")

It clearly differs from the page design, so you also need to customize the block's layout.

### Change the block template

First, add a new template for the Form block to align it with the Random block design.
Create a `newsletter.html.twig` file in `templates/blocks/form/`:

``` html+twig hl_lines="1"
[[= include_file('code_samples/tutorials/page_tutorial/templates/blocks/form/newsletter.html.twig') =]]
```

This template extends the default block layout by adding an additional class (line 1) that shares CSS styling with the Random block.

Append the new template to the block by adding it to `config/packages/ibexa_fieldtype_page.yaml`.
Add the following configuration under the `blocks` key at the same level as other block names, e.g. `random`:

``` yaml hl_lines="1"
[[= include_file('code_samples/tutorials/page_tutorial/config/packages/ibexa_fieldtype_page.yaml', 42, 47) =]]
```

Now you have to apply the template to the block.
Go back to editing the Page.
Edit the Form block again.
In the **Design** tab, select the **Newsletter Form View** and click **Submit**.

The block remains unchanged, but the results will be visible when you add CSS styling.

### Change the field template

At this point, you need to change the field template.
This results in alternating the position and design of the Form fields.

Create a `form_field.html.twig` file in `templates/fields/`:

``` html+twig
[[= include_file('code_samples/tutorials/page_tutorial/templates/fields/form_field.html.twig') =]]
```

Next, assign the template to the Page.
In `config/packages/views.yaml`, at the same level as `pagelayout`, add:

``` yaml
[[= include_file('code_samples/tutorials/page_tutorial/config/packages/views.yaml', 7, 9) =]]
```

Clear the cache by running `bin/console cache:clear` and refresh the Page to see the results.

### Configure the Form field

Before applying the final styling of the block, you need to configure the [CAPTCHA field](forms.md#captcha-field).
In `config/packages`, add a `gregwar_captcha.yaml` file with the following configuration:

``` yaml
[[= include_file('code_samples/tutorials/page_tutorial/config/packages/gregwar_captcha.yaml') =]]
```
The configuration resizes the CAPTCHA image (line 2), changes the error message (line 3), and shortens the authentication code (line 4).

### Add stylesheet

The remaining step in configuring the block is adding CSS styling.
Add the following code to `assets/css/style.css`:

``` css
[[= include_file('code_samples/tutorials/page_tutorial/assets/css/style.css', 229, 277) =]]
```
Reinstall the assets and clear the cache by running the following commands:

``` bash
yarn encore <dev|prod>
php bin/console cache:clear
```
Your newsletter form block is ready.

![Newsletter Form Block](enterprise_tut_final_form.png "Newsletter Form Block")

Refresh the Page and enter a couple of mock submissions.

### Manage the submissions

You can view all submissions in the Back Office.
Go to **Forms** page. From the Content tree, select the Form and click the **Submissions** tab.
There, after selecting submission(s), click **Download submissions** or **Delete submission**.
To see details about a submission, click the view icon.

![Collect Form Submissions](enterprise_tut_form_collect_sub.png "Collect Form Submissions")

For more details, see [viewing form results.](https://doc.ezplatform.com/projects/userguide/en/latest/creating_forms/#viewing-results)

## Congratulations!

You have finished the tutorial and created your first customized Page.

You have learned how to:

- Create and customize a Page
- Make use of existing blocks and adapt them to your needs
- Plan content airtime using the Content Scheduler block
- Create custom blocks
- Use Form Builder and configure your form
- Apply custom styling to blocks

![Final result of the tutorial](enterprise_tut_main_screen.png "Final result of the tutorial")
