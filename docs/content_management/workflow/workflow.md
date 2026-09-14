---
description: Workflow controls how content items pass between stages and allows setting up editorial flows, for example for reviews and proofreading.
---

# Workflow

The workflow functionality passes a content item version through a series of stages.

For example, an editorial workflow can pass a content item from draft stage through design and proofreading.

[[= product_name =]] comes pre-configured with a Quick Review workflow.
Workflows are permission-aware.

### Reviewers

When moving a content item through a transition, the user can select a reviewer.

To be able to search for users for review, the user must have the `content/read` policy without any limitation, or with a limitation that allows reading users.
This means that, in addition to your own settings for this policy, you must add the /Users subtree to the limitation and add users in the [content type limitation](limitation_reference.md#content-type-limitation).

#### Draft locking

You can configure draft assignment in a way that when a user sends a draft to review, only the first editor of the draft can either edit the draft or unlock it for editing, and no other user can take it over.

Use the [Version Lock limitation](limitation_reference.md#version-lock-limitation), set to "Assigned only", together with the `content/edit` and `content/unlock` policies to prevent users from editing and unlocking drafts that are locked by another user.

## Workflow event timeline

Workflow event timeline displays workflow transitions.

## Permissions

You can limit access to workflows at stage and transition level.

The `workflow/change_stage` policy grants permission to change stages in a specific workflow.

You can limit this policy with the [Workflow Transition limitation](limitation_reference.md#workflow-transition-limitation) to only allow sending content in the selected transition.
