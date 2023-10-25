# 4.6. Update workflow

[`flex-workflow` has been combined with `ezplatform-workflow`](../../../release_notes/ez_platform_v3.0_deprecations.md#flex-workflow) in the form of a Quick Review functionality.

If you used custom subscribers for events in workflow, you can now rewrite this code
to use [custom actions](https://doc.ibexa.co/en/master/guide/extending/extending_workflow.md#adding-custom-actions).

To migrate your content which had been using Flex Workflow to the new Quick Review workflow,
run the following command:

`php bin/console ezplatform:migrate:flex-workflow`
