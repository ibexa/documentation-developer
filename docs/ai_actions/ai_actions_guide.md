---
description: AI Actions add-on helps editors by automating repetitive tasks.
---

# AI Actions product guide

## What are AI Actions

In the evolving landscape of digital experience, artificial intelligence becomes more and more important by enhancing user interaction and automating complex tasks.
[[= product_name =]] can be equipped with the AI Actions add-on, which harnesses AI's potential to automate various time-consuming tasks, for example, generating alt text for images.

Out-of-the-box, AI Actions includes two essential components: a framework package and an OpenAI connector package.
By default it comes with two action types preconfigured:

- Generate alternative text: Generate alt text for accessibility purposes
- Refine text: Rewrite existing text according to parameters set in a prompt

![AI Actions schematic](<img/guide_AI Actions.png>)

You can extend its capabilities beyond the default setup by creating custom connector modules, allowing users to integrate additional AI services or customize the way data is processed and interpreted.
For example, it can transform text, or generate illustrations for your articles based on a prompt.
The possibilities are endless and you're not limited to a specific AI service, avoiding vendor lock-in.

## Availability

The AI Actions feature is an opt-in capability available as an LTS Update to the v4.6.x version of [[= product_name =]], regardless of its edition.
To begin using AI Actions, you must first install the required packages and perform initial configuration.

!!! note "API Key"

    The Open AI connector requires that you first [get an API key](https://help.openai.com/en/articles/4936850-where-do-i-find-my-openai-api-key).

## How it works

Built upon the PHP framework, AI Actions offer an extensible solution for integrating features provided by AI services into your workflows, all managed through a user-friendly interface.

The framework package is responsible for gathering information from various sources, such as Action types, Action configurations, and contextual details like SiteAccess, user details, locale settings, and more.
This data can then be combined with user input.
Then it's passed to a connector, such as the OpenAI connector, for final processing on [[= product_name =]] side.
The connector wraps the data into a prompt or another suitable format and sends it to an external AI service.

When the AI Service returns a response, the response goes through the connector and passes to the framework.
It can now be presented to the user in any way necessary.

AI Actions can also be extended beyond the default setup by creating custom connector modules, allowing users to integrate additional AI services or customize the way data is processed and interpreted.

### Core concepts

#### Action

Actions are tasks or functions that the AI is set to perform.
Each Action is a combination of an action type and an action configuration.
Action types define what kind of task the AI will perform, while the action configuration specifies how the task should be executed.
This clear separation allows for a flexible system where actions can be easily created, managed, and customized.

#### Action type

Action types are predefined by developers.
Each action type defines the structure and nature of the task that the AI service performs.
Action types could be designed to generate alt text for images, summarize a passage of text, or even translate content into another language.
By defining action types, developers can create a wide range of functionalities that can be easily deployed within the application.

#### Action configuration

Website administrators use Action configurations to employ action types to generate actions.
Action configurations are managed in the [Admin Panel](admin_panel.md), and allow administrators to customize and fine-tune the behavior of each action.
Such tuning might involve setting specific parameters used the AI service, setting an expense limit, or configuring how the output should be handled.
By making such adjustments, administrators can ensure that the actions are tailored to meet their requirements.

#### Handler

Once an action is defined and configured, it must be executed, and this is where handlers come into play.
Handlers are pieces of PHP code that are responsible for resolving an action.
Each handler is designed to work with a specific AI service and action type pair.
Handlers may include hardcoded prompts for conversational AI services like ChatGPT.
They can also operate without prompts in the case of other types of AI.
Handlers take parameters defined in the action type and action configuration, combine it with user input and any predefined settings or prompts, and pass this information to the AI service for processing.

### Triggering actions from the UI

Among other elements, AI Actions package includes UI components for:

- action management in the Admin Panel,
- alt-text generation feature in image management
- text modification in online editor

These areas are user-friendly and well integrated with the existing application’s UI.
Administrators can manage action configurations with ease, while end-users can trigger actions with a click of a button.
Procedures are straightforward and intuitive, ensuring that users can quickly achieve their desired outcomes.

### Triggering actions programmatically

AI Actions add-on exposes a REST API interface that allows for programmatic execution of actions.
With the API, developers can automate tasks and execute actions on batches of content by integrating them into workflows.
<!---By issuing commands through the API, developers can trigger actions based on external events:
...--->

## Capabilities

### Management

The AI Actions allows you to control the lifecycle of action configurations.
Users with the appropriate permissions, governed by role-based [policies](policies.md#ai-actions), can create, edit, execute, and delete action configurations.
Additionally, configurations can be enabled or disabled depending on the organization's needs.

[Configurations management screen](ai_actions_list.md)

An intuitive AI Actions interface within the Admin Panel displays a list of all available action configurations.
Here, you can search for specific configurations and filter them by type or status.
By accessing the detailed view of individual action configurations, it is possible to quickly review all the parameters.

### Extensibility

Built-in action types offer a good starting point, but the real power of AI Actions lies in extensibility.
Extending AI Actions opens up new possibilities for content management and editing.
Developers can extend the feature by adding new action types that use existing AI services or even integrating additional ones.
This involves defining a new action type, writing a handler that communicates with the new service, and creating a form for configuring the options that extends the default action configuration form shown in the Admin Panel.
For example, if this is your enterprise's requirement, a developer could write a handler that uses an AI service to generate complete articles based on a short description, or illustrations based on a body of an article.

## Use cases

Out of the box, the [[= product_name_base =]] AI Actions add-on comes with two action types that can help you roganization with the following tasks.
Before you can start start using these features, some preliminary setup is required, which includes configuring access to an AI service.

### Refining text

Content editors can benefit from using AI capabilities to enhance or modify text.
With a few clicks, they can improve content quality or reduce the workload.
While working on content, editors can select a specific passage and request that AI performs specific actions such as: adjusting the length of the text, changing the tone, or correcting grammar and spelling errors.

![AI Assistant](img/ai_assistant.png)

With seamless with the content creation UI in mind, this functionality is available in content types that include a RichText field, and certain Page Builder blocks.

### Generating alternative text

Media managers and content editors can benefit from employing AI to generate alt text for images, which results in improved accessibility and SEO.
Once the feature is configured, editors can generate alt text for images they upload to the system by clicking one button.

![Alt text generation](img/alt_text_use_ai.png)

With some customization, administrators could use the API to run a batch process against a larger collection of illustrations.