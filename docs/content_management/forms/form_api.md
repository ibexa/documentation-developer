---
description: You can use PHP API to get, create and delete form submissions.
edition: experience
---

# Form API

## Form submissions

To manage form submissions created in the [Form Builder](forms.md), use `FormSubmissionServiceInterface`.

### Getting form submissions

To get existing form submissions, use `FormSubmissionServiceInterface::loadByContent()`
(which takes a `ContentInfo` object as parameter), or `FormSubmissionServiceInterface::loadById()`.

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/FormSubmissionCommand.php', 54, 55) =]]
```

Through this object, you can get information about submissions, such as their total number,
and submission contents.

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/FormSubmissionCommand.php', 55, 66) =]]
```

### Creating form submissions

To create a form submission, use the `FormSubmissionServiceInterface::create()` method.

This method takes:

- the `ContentInfo` object of the Content item containing the form
- the language code
- the value of the Field containing the form
- the array of form field values

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/FormSubmissionCommand.php', 40, 53) =]]
```

### Deleting form submissions

You can delete a form submission by using the `FormSubmissionServiceInterface::delete()` method.

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/FormSubmissionCommand.php', 66, 68) =]]
```
