# Editorial workflow

!!! enterprise

    The workflow functionality passes a Content item version through a series of stages.

    For example, an editorial workflow can pass a Content item from draft stage 
    through design and proofreading.

    You can define different workflows in configuration. 
    Workflows are permission-aware.

    ## Workflow configuration

    Each workflow consists of stages and transitions between them.

    The following configuration defines a workflow where you can pass a draft 
    to technical review, then to proofreading, and to final approval.

    ``` yaml hl_lines="17 18 19 34 35 36 37 38 65 66 67 68"
    ezpublish:
        system:
            # Workflow configuration is SiteAccess-aware
            default:
                workflows:
                    # Identifier of the workflow
                    custom_workflow:
                        name: Custom Workflow
                        matchers:
                            # Which Content Types can use this workflow
                            content_type: article
                            # Which status of the Content item can use this workflow. Available statuses are draft and published.
                            # For the workflow to apply to either of statuses, pass an array with both options: [draft, published].
                            content_status: draft
                        # All stages the content goes through
                        stages:
                            draft:
                                label: Draft
                                color: '#f15a10'
                            technical:
                                label: Technical review
                                color: '#10f15a'
                            proofread:
                                label: Proofread
                                color: '#5a10f1'
                            done:
                                label: Done
                                color: '#301203'
                                # Content items in this stage don't appear on the Dashboard and in Review Queue.
                                last_stage: true
                        initial_stage: draft
                        # Available transitions between stages
                        transitions:
                            to_technical:
                                from: draft
                                to: technical
                                label: To technical review
                                icon: '/bundles/ezplatformadminui/img/ez-icons.svg#comment'
                                notification:
                                    user_group: 13
                            back_to_draft:
                                reverse: to_technical
                                label: Back to draft
                                icon: '/bundles/ezplatformadminui/img/ez-icons.svg#comment'
                                notification:
                                    user_group: 13
                            to_proofread:
                                from: technical
                                to: proofread
                                label: To proofreading
                                icon: '/bundles/ezplatformadminui/img/ez-icons.svg#comment'
                                notification:
                                    user_group: 13
                            back_to_technical:
                                reverse: to_proofread
                                label: Back to technical review
                                icon: '/bundles/ezplatformadminui/img/ez-icons.svg#comment'
                                notification:
                                    user_group: 13
                            done:
                                from: proofread
                                to: done
                                label: Done
                                icon: '/bundles/ezplatformadminui/img/ez-icons.svg#comment'
                                notification:
                                    # Which User Group or User to notify about this transition
                                    user_group: 13
                                    user: 14
    ```

    Each stage in the workflow has an identifier and can be assigned a label 
    and a color (lines 17-19).

    Each transition also has an identifier. It must state between which stages 
    it transitions, or be marked as `reverse` of a different transition.
    Transitions can also have labels and icons (lines 37-38).

    `notification` (lines 65-68) defines who will be notified when a transition 
    happens by providing the User or User Group ID.
    Notifications will be displayed in the user menu.

    You can view all configured workflows in the Admin Panel by selecting **Workflow**.

    ![Workflow in Admin Panel](img/workflow_panel.png)

    ## Permissions

    You can limit access to workflows at stage and transition level.
    Use the `workflow/change_stage` Policy to grant a User permission to change 
    stages in a specific workflow.

    This Policy can be limited with the [Workflow Transition Limitation](limitation_reference.md#workflow-transition-limitation) 
    to only allow sending content in the allowed transition.

    For example, using the example above, a `workflow/change_stage` Policy with 
    `WorkflowTransitionLimitation` set to `To Proofreading`
    will allow the Technical team to send content to proofreading after they 
    are done with technical review.

    You can also use the [Workflow Stage Limitation](limitation_reference.md#workflow-stage-limitation) together 
    with the `content/edit` and `content/publish` Policy to limit the ability 
    to edit content in specific stages.
    For example, you can use it to only allow Technical team to edit content 
    in the `technical` stage.

    ## Workflow service

    Workflow makes use of the Symfony [Workflow Component](https://symfony.com/doc/3.4/components/workflow.html),
    but special eZ Platform treatment is covered in the Workflow service.

    The service implements the following methods:

    - `start` - places a Content item in a workflow
    - `apply` - performs a transition
    - `can` - checks if a transition is possible

    !!! tip

        The methods `apply` and `can` are the same as in Symfony Workflow, 
        but the implementation in Workflow Service extends them, 
        for example by providing messages.

    You can also use the following methods to read information about workflow 
    from the database:

    - `loadWorkflowMetadataForContent` - reads all workflow information about a Content item (as `WorkflowMetadata`)
    - `loadWorkflowMetadataOriginatedByUser` - reads all workflow actions performed by the provided user (as `WorkflowMetadata`)
    - `loadAllWorkflowMetadata` - reads all workflow information from the system

    `\EzSystems\EzPlatformWorkflow\Value\WorkflowMetadata` object contains 
    all information about a workflow, such as ID, name, transitions and current stage.
    `\EzSystems\EzPlatformWorkflow\Value\WorkflowMetadata::$workflow` gives 
    you direct access to native Symfony Workflow object.

    ## Publishing content with workflow

    The workflow functionality only operates on workflow stages.
    It does not perform operations on content, such as publishing it, out of the box.

    This means it does not automatically publish a Content item when it reaches 
    the final stage of a workflow.
    It can be done with a custom implementation.

    ### Publish content that reaches final stage

    To publish a Content item once it reaches the final stage of a workflow, 
    you need to set up an event subscriber.

    You can use the [`PublishOnLastStageSubscriber.php`](https://github.com/ezsystems/ezplatform-ee-demo/blob/v2.5.6/src/AppBundle/Event/Workflow/PublishOnLastStageSubscriber.php) 
    from eZ Platform demo as a basis for the subscriber.

    The subscriber listens for the `WorkflowEvents::WORKFLOW_STAGE_CHANGE` event
    ([line 61](https://github.com/ezsystems/ezplatform-ee-demo/blob/v2.5.6/src/AppBundle/Event/Workflow/PublishOnLastStageSubscriber.php#L61)).
    When the event occurs, it publishes the relevant Content item
    ([line 87](https://github.com/ezsystems/ezplatform-ee-demo/blob/v2.5.6/src/AppBundle/Event/Workflow/PublishOnLastStageSubscriber.php#L87)).

    The subscriber must be registered as a service:

    ``` yaml hl_lines="5"
    services:
        # ...
        AppBundle\Event\Workflow\PublishOnLastStageSubscriber:
            arguments:
                $publishOnLastStageWorkflows: '%app.workflow.publish_on_last_stage%'
    ```

    You must also provide the identifier of the workflow you want the subscriber 
    to apply to.
    Do it in the `app.workflow.publish_on_last_stage` parameter:

    ``` yaml
    parameters:
        app.workflow.publish_on_last_stage: [editorial_workflow, legal_workflow]
    ```

    ### Finish workflow for published content

    With proper permissions, you can publish content even before it has gone 
    through a whole workflow.
    Afterward it will still be visible in the review queue and in the relevant 
    stage of **Content item(s) under review** tab under **Workflow** in the Admin panel.

    To avoid cluttering the tables with published content, you can use an event 
    subscriber which will automatically move content to the last stage of the 
    workflow after it has been published.

    You can use the [`EndWorkflowSubscriber.php`](https://github.com/ezsystems/ezplatform-ee-demo/blob/v2.5.6/src/AppBundle/Event/Subscriber/EndWorkflowSubscriber.php) from eZ Platform demo as a basis for the subscriber.

    The [`doEndWorkflows()`](https://github.com/ezsystems/ezplatform-ee-demo/blob/v2.5.6/src/AppBundle/Event/Subscriber/EndWorkflowSubscriber.php#L105) function in the example
    applies all transitions that are needed to bring the Content item to the final workflow stage.

    The subscriber must also be registered as a service:

    ``` yaml
    services:
        # ...
        AppBundle\Event\Subscriber\EndWorkflowSubscriber: ~
    ```
