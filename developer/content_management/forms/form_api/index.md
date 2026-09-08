# Form API

You can use PHP API to get, create and delete form submissions.

Editions: Experience

## Form submissions

To manage form submissions created in the [Form Builder](../form_builder_guide/index.md), use `FormSubmissionServiceInterface`.

> **Tip: Restricting access to form submissions**
>
> By default, back office users with access to the form content item can access the form submissions.
>
> If your form submissions require stricter access control than the form itself, you can introduce a [dedicated policy that manages access to submission data](../../../permissions/custom_policies/index.md#restrict-access-to-form-submissions).

### Getting form submissions

To get existing form submissions, use `FormSubmissionServiceInterface::loadByContent()` (which takes a `ContentInfo` object as parameter), or `FormSubmissionServiceInterface::loadById()`.

```php
$submissions = $this->formSubmissionService->loadByContent($contentInfo);
```

Through this object, you can get information about submissions, such as their total number, and submission contents.

```php
$output->writeln('Total number of submissions: ' . $submissions->getTotalCount());
foreach ($submissions as $sub) {
    $output->write($sub->getId() . '. submitted on ');
    $output->write($sub->getCreated()->format('Y-m-d H:i:s') . ' by ');
    $output->writeln((string) $this->userService->loadUser($sub->getUserId())->getName());
    foreach ($sub->getValues() as $value) {
        $output->writeln('- ' . $value->getIdentifier() . ': ' . $value->getDisplayValue());
    }
}
```

### Creating form submissions

To create a form submission, use the `FormSubmissionServiceInterface::create()` method.

This method takes:

- the `ContentInfo` object of the content item containing the form
- the language code
- the value of the field containing the form
- the array of form field values

```php
$formValue = $content->getFieldValue('form', 'eng-GB')->getFormValue();
$data = [
    ['id' => 7, 'identifier' => 'single_line', 'name' => 'Line', 'value' => 'The name'],
    ['id' => 8, 'identifier' => 'number', 'name' => 'Number', 'value' => 123],
    ['id' => 9, 'identifier' => 'checkbox', 'name' => 'Checkbox', 'value' => 0],
];

$this->formSubmissionService->create(
    $contentInfo,
    'eng-GB',
    $formValue,
    $data
);
```

### Deleting form submissions

You can delete a form submission by using the `FormSubmissionServiceInterface::delete()` method.

```php
$submission = $this->formSubmissionService->loadById(29);
$this->formSubmissionService->delete($submission);
```
