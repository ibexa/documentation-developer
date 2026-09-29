# 4.6. Update workflow

[`flex-workflow` has been combined with `ezplatform-workflow`](../../../../release_notes/ez_platform_v3.0_deprecations/index.md#flex-workflow) in the form of a Quick Review functionality.

If you used custom subscribers for events in workflow, you can now rewrite this code to use [custom actions](../../../../content_management/workflow/add_custom_workflow_action/index.md).

To migrate your content which had been using Flex Workflow to the new Quick Review workflow, run the following command:

`php bin/console ezplatform:migrate:flex-workflow`
