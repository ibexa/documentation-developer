# Work with AI actions

Create new AI actions or modify existing ones to work faster and increase creativity.

AI actions define what results are available to editors in AI-enabled areas, such as, for example, the AI Assistant. If AI Actions, including at least one service connector, have been configured in your application, and you have the required [permissions](../../../developer/permissions/policies/index.md#ai-actions), including `Action configuration/Edit` and `Action configuration/Create`, you can reconfigure the existing AI actions, and create new ones.

> **Note: Variations in AI action settings**
>
> The following description outlines the UI options displayed when either the default OpenAI connector or the Anthropic [LTS update](../../../developer/ibexa_products/editions/index.md#lts-updates) is installed and configured.
>
> Response generation settings may vary depending on the AI service, model implementation, and action type, so the settings shown below might differ from those available in your installation.

## View AI actions

With the right permissions, you can view all AI actions configured in the application by navigating to the Admin Panel and selecting **AI actions**.

![AI actions in Admin Panel](https://doc.ibexa.co/projects/userguide/en/5.0/ai_actions/img/ai_actions_list.png)

You can narrow down the list of AI actions by filtering it by the status, either Enabled or Disabled, or by the type. Out of the box, there are two categories of AI actions present in the system:

- **Refine text** - used by default in [online editor](../../content_management/create_edit_content_items/index.md#ai-assistant) for refining text, for example: "Rewrite text in formal tone"
- **Generate alternative text** - used by default in the [image asset editing screen](../../image_management/upload_images/index.md#ai) to generate alternative text, for example: "Generate short alternative description of an image"

It may happen that a set of sample AI actions has been installed with the AI actions package, and there is already a number of existing AI actions that you can modify and clone.

> **Note: Custom action types**
>
> In your specific case, the types available can be different, and your organization's development team can create custom AI action types. For more information, see [developer documentation](../../../developer/ai/ai_actions/ai_actions/index.md).

### View AI action details

Navigate to the Admin Panel and select **AI actions**. In the **AI actions** list, click the name of an AI action to review its details. For example, in the **Properties** tab, you can see specific settings that modify the prompt that is sent to an AI service.

![AI action details](https://doc.ibexa.co/projects/userguide/en/5.0/ai_actions/img/ai_action_details.png)

## Edit existing AI actions

You can modify the existing AI actions.

1. Navigate to the Admin Panel and select **AI actions**.

2. In the **AI actions** list, click the **Edit** icon next to a name of the AI action that you want to modify.

3. In the **Global properties** section, you can change the name and description of the AI action. You can also toggle the availability of the AI action between disabled and enabled.

4. In the **Settings** area, change the settings that modify the behavior of an AI service that executes an AI action, for example:

- **Prompt** - modifies the default request by passing a verbal command, for example, "Make it short and formal."

> **Note: Default request**
>
> The default request can be seen at the top of the settings area, on a light blue background.

- **Model** - decides what AI service model is used to generate the response
- **Max tokens** - sets a maximum number of "[words](https://help.openai.com/en/articles/4936856-what-are-tokens-and-how-to-count-them)" or [tokens](https://docs.claude.com/en/docs/about-claude/glossary#tokens) that can be used in a single request by both the request and the response
- **Length of prompt output** - sets a maximum number of words of the generated result
- **Temperature** - controls the randomness of the response. Takes a value between 0 and 2, but the usual range is between 0 and 1. The output is more random at higher temperatures. For more information, see the parameter's description in [Anthropic's glossary](https://docs.claude.com/en/docs/about-claude/glossary#temperature)

![AI action options](https://doc.ibexa.co/projects/userguide/en/5.0/ai_actions/img/ai_action_options.png)

5. Click **Save and close** to apply the changes or **Discard** to discard them and close the window.

## Create new AI actions

You can create AI actions that perform actions of different types, using different models, or action handlers.

> **Note: AI action models**
>
> Before you can work with AI actions, models must be configured and enabled by your organization's development team. If there are more AI service connectors available, you might be able to create AI actions that perform the same type of actions but use different models. For more information, see [developer documentation](../../../developer/ai/ai_actions/ai_actions_guide/index.md#model).

1. Navigate to the Admin Panel and select **AI actions**.

2. In the **AI actions** list, click **Create**.

3. In the slide-out pane, make initial choices in the following fields, and click **Create**:

   - **Language** - sets the base language for the AI action
   - **Action type** - sets an action type to serve as a template for the AI action, for example, **Refine text**
   - **Action handler** - sets the AI model used to process the requests resulting from this AI action

4. In the **Global properties** section, set the name and identifier of the AI action.

5. Optionally, provide a description of the AI action.

6. When ready, toggle the status of the AI action to enabled.

7. Make settings in the **Settings** area. For a list of available settings, see [Edit existing AI actions](#edit-existing-ai-actions).

8. Click **Save and close** to apply the changes or **Discard** to discard them and close the window.

### Create AI actions that control taxonomy suggestions

If the [Taxonomy suggestions](https://doc.ibexa.co/en/5.0/content_management/taxonomy/taxonomy#taxonomy-suggestions) feature is enabled in your system, before editors can use it to pick from product categories or tags suggested by an AI service, you must configure an AI action for the product types or content types of your choice.

1. Navigate to the Admin Panel and select **AI actions**.

2. In the **AI actions** list, click **Create**.

3. In the slide-out pane, make initial choices in the following fields, and click **Create**:

   - **Language** - sets the base language for the AI action
   - **Action type** - sets an action type to serve as a template for the AI action, for example, **Suggest taxonomy**
   - **Action handler** - sets the AI model used to process the requests resulting from this AI action. Pick `taxonomy-text-to-taxonomy`

4. Make settings in the **Global properties** section, as described above.

5. Make settings in the **Settings** area:

   1. Select a group of content types or product types that you want to pick types from.
   2. Select the content types or product types in which you want to allow editors to use taxonomy suggestions.
   3. Select source fields that contain values to be sent to an AI service for processing.
   4. Select target fields (of **Taxonomy Entry Assignemnt** type) for which taxonomy entry suggestions are provided.

   ![Selecting source fields](https://doc.ibexa.co/projects/userguide/en/5.0/ai_actions/img/taxonomy_source_fields.png "Selecting source fields")

6. Make optional settings, for example:

   - Define a maximum number of returned suggestions
   - Set the maximum number of tokens to be used by each call when generating suggestions

7. Click **Save and close** to apply the changes or **Discard** to discard them and close the window.

### Create AI actions that use Ibexa Connect

If your organization uses Ibexa Connect, you can build multi-step scenarios that define the logic needed to process your input data, for example, by merging the output of multiple AI services. One such example could be sending out a text for translation by one service, and then to another to make sure that the resulting translation is written in the right tone.

> **Note: Ibexa Connect configuration required**
>
> To use AI actions that interface with Ibexa Connect, you must first [configure and initiate the connection](../../../developer/ai/ai_actions/configure_ai_actions/index.md#configure-access-to-ibexa-connect), and [define templates](https://doc.ibexa.co/projects/connect/en/latest/scenarios/scenario_templates/#creating-templates) and/or [scenarios](https://doc.ibexa.co/projects/connect/en/latest/scenarios/creating_a_scenario/) in Ibexa Connect.

1. Navigate to the Admin Panel and select **AI actions**.

2. In the **AI actions** list, click **Create**.

3. In the slide-out pane, make choices like in [Create new AI actions](#create-new-ai-actions) but in the **Action handler** field, select the model that uses an Ibexa Connect scenario to process the request, for example `connect-image-to-text`, and then click **Create**.

![Ibexa Connect handler](https://doc.ibexa.co/projects/userguide/en/5.0/ai_actions/img/ai_action_connect_handler_selection.png)

4. In the **Global properties** area, set the required properties.

5. In the **Settings** area, select an existing scenario from a drop-down list. The list contains all scenarios that exist in Ibexa Connect. They may be incompatible with the selected action type and require adjustments on the Ibexa Connect side.

6. Optionally, if there are no scenarios for the selected action type, or you want to create a custom scenario, click **Create scenario based on template** and select a template from a drop-down list.

If you do so, when you save the new AI action, a new scenario is automatically created. You must then fine-tune its settings in Ibexa Connect.

![Ibexa Connect scenario selection](https://doc.ibexa.co/projects/userguide/en/5.0/ai_actions/img/ai_action_settings_connect.png)

> **Note: Link to Ibexa Connect**
>
> Click **Go to Connect** to review all scenarios that exist in Ibexa Connect.

7. Click **Save and close** to apply the changes or **Discard** to discard them and close the window.

After you save the AI action, you can click its name in the AI actions list and see all the information, such as Scenario ID, webhook URL, or scenario label, which you may needed when working with scenarios in Ibexa Connect.

## Duplicate AI actions

You can duplicate existing actions, for example, to create a variant version of an action with slightly different settings. To do so, in the **AI actions** list, click the **Duplicate** icon next to a name of the AI action that you want to duplicate.

You can then modify the duplicated action (for example, change its name or fine-tine the instructions), enable it and save your changes. If you discard your changes, the duplicated action will appear on the actions list with status Disabled.
