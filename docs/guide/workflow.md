# Editorial workflow

The workflow functionality passes a Content item version through a series of stages.

For example, an editorial workflow can pass a Content item from draft stage through design and proofreading.

You can define different workflow in configuration. The workflow is permission-aware.

## Workflow configuration

Each workflow consists of stages and transitions between them.

The following configuration defines a workflow where you can pass a draft to technical review, then to proofreading, and to final approval.

``` yaml hl_lines="16 17 18 33 34 35 36 37 64 65 66 67"
ezpublish:
    system:
        # Workflow configuration is SiteAccess-aware
        default:
            workflows:
                # Identifier of the workflow
                custom_workflow:
                    name: 'Custom Workflow'
                    matchers:
                        # Which Content Types can use this workflow
                        content_type: article
                        # Which status of the Content item can use this workflow. Available statuses are draft and published.
                        content_status: draft
                    # All stages the content goes through
                    stages:
                        draft:
                            label: 'Draft'
                            color: '#f15a10'
                        technical:
                            label: 'Technical review'
                            color: '#10f15a'
                        proofread:
                            label: 'Proofread'
                            color: '#5a10f1'
                        done:
                            label: 'Done'
                            color: '#301203'
                            # Content items in this stage don't appear on the Dashboard and in Review Queue.
                            last_stage: true
                    initial_stage: draft
                    # Available transitions between stages
                    transitions:
                        to_technical:
                            from: draft
                            to: technical
                            label: 'To technical review'
                            icon: '/bundles/ezplatformadminui/img/ez-icons.svg#comment'
                            notification:
                                user_group: 13
                        back_to_draft:
                            reverse: to_technical
                            label: 'Back to draft'
                            icon: '/bundles/ezplatformadminui/img/ez-icons.svg#comment'
                            notification:
                                user_group: 13
                        to_proofread:
                            from: technical
                            to: proofread
                            label: 'To proofreading'
                            icon: '/bundles/ezplatformadminui/img/ez-icons.svg#comment'
                            notification:
                                user_group: 13
                        back_to_technical:
                            reverse: to_proofread
                            label: 'Back to technical review'
                            icon: '/bundles/ezplatformadminui/img/ez-icons.svg#comment'
                            notification:
                                user_group: 13
                        done:
                            from: proofread
                            to: done
                            label: 'Done'
                            icon: '/bundles/ezplatformadminui/img/ez-icons.svg#comment'
                            notification:
                                # Which User Group or User to notify about this transition
                                user_group: 13
                                user: 14
```

Each stage in the workflow has an identifier and can be assigned a label and a color (lines 16-18).

Each transition also has an identifier. It must state between which stages it transitions, or be marked as `reverse` of a different transition.
Transitions can also have labels and icons (lines 36-37).

`notification` (lines 64-67) defines who will be notified when a transition happens by providing the User or User Group ID.
Notifications will be displayed in the user menu.

You can view all configured workflows in the Admin Panel by selecting **Workflow**.

![Workflow in Admin Panel](img/workflow_panel.png)

## Permissions

You can limit access to workflows at stage and transition level.
Use the `workflow/change_stage` Policy to grant a User permission to change stages in a specific workflow.

This Policy can be limited with the [`WorkflowTransitionLimitation`](limitations.md#workflowtransitionlimitation) to only allow sending content in the allowed transition.

For example, using the example above, a `workflow/change_stage` Policy with `WorkflowTransitionLimitation` set to `To Proofreading`
will allow the Technical team to send content to proofreading after they are done with technical review.

You can also use the [`WorkflowStageLimitation`](limitations.md#workflowstagelimitation) together with the `content/edit` and `content/publish` Policy to limit the ability to edit content in specific stages.
For example, you can use it to only allow Technical team to edit content in the `technical` stage.
