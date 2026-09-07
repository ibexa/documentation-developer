---
description: You can use PHP API to get, create and delete form submissions.
---

# Form API

## Form submissions

To manage form submissions created in the [Form Builder](form_builder_guide.md), use `FormSubmissionServiceInterface`.

### Getting form submissions

To get existing form submissions, use `FormSubmissionServiceInterface::loadByContent()` (which takes a `ContentInfo` object as parameter), or `FormSubmissionServiceInterface::loadById()`.

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/FormSubmissionCommand.php', 50, 50, remove_indent=True) =]]
```

Through this object, you can get information about submissions, such as their total number, and submission contents.

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/FormSubmissionCommand.php', 52, 60, remove_indent=True) =]]
```

### Creating form submissions

To create a form submission, use the `FormSubmissionServiceInterface::create()` method.

This method takes:

- the `ContentInfo` object of the content item containing the form
- the language code
- the value of the field containing the form
- the array of form field values

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/FormSubmissionCommand.php', 36, 48, remove_indent=True) =]]
```

### Deleting form submissions

You can delete a form submission by using the `FormSubmissionServiceInterface::delete()` method.

``` php
[[= include_code('code_samples/api/public_php_api/src/Command/FormSubmissionCommand.php', 62, 63, remove_indent=True) =]]
```
