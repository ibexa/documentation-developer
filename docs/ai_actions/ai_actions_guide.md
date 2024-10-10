---
description: AI Actions add-on helps editors by automating repetitive tasks.
---

# AI Actions product guide

## What are AI Actions

In the evolving landscape of digital experience, artificial intelligence becomes more and more important by enhancing user interaction and automating complex tasks.
To harness AI's potential, [[= product_name =]] introduces th AI Actions add-on, which you can install and use to automate various time-consuming tasks, for example, generating alt text for images.

Built upon the PHP framework, AI Actions offer an extensible solution for integrating services provided by AI services into your workflows, all managed through a user-friendly interface.

You can extend the add-on and make it do different things, for example, transform text passages, or generate illustrations for your articles based on a prompt.
The possibilities are endless and you're not limited to a specific AI service, avoiding vendor lock-in.

## Availability

AI Actions are available as an add-on to the v4.6.x version of [[= product_name =]], regardless of its edition.
To use it's capabilities you must install the package and perform initial configuration.

## How it works

### The core concepts

#### Actions

Actions are tasks or functions that the AI is set to perform.
Each Action is a combination of an action type and an action configuration.
Action types define what kind of task the AI will perform, while the action configuration specifies how the task should be executed.
This clear separation allows for a flexible system where actions can be easily created, managed, and customized.

#### Action types

Action types are predefined by developers.
Each action type defines the structure and nature of the task that the AI service performs.
Action types could be designed to generate alt text for images, summarize a passage of text, or even translate content into another language.
By defining action types in YAML, developers can create a wide range of functionalities that can be easily deployed within the application.

#### Action configurations

AAction configurations let administrators employ action types to generate actions.
Action configurations are managed in the [Admin Panel](admin_panel.md), and allow administrators to customize and fine-tune the behavior of each action.
This might involve setting parameters for the AI, defining specific inputs, or configuring how the output should be handled.
By adjusting these configurations, administrators can ensure that the actions are tailored to meet their requirements.

#### Handlers

Once an action is defined and configured, it must be executed, and this is where handlers come into play.
Handlers are pieces of PHP code that are responsible for resolving an action.
Each handler is designed to work with a specific AI service and action type pair.
Handlers may include hardcoded prompts for conversational AI services like ChatGPT, or they may operate without prompts for other types of AI.
Handlers take configurations defined in the action type and action configuration, combine it with user input and any predefined settings or prompts, and pass this information to the AI service for processing.

### Triggering actions from the UI

Among other components, AI Actions add-on brings action management in Admin Panel and alt-text generation feature in image management UI.
Both these areas are user-friendly and well integrated with the application’s UI.
Administrators can manage atcion configurations with ease, while end-users can trigger actions by simply clicking a button. 
Processes are straightforward and intuitive, ensuring that users can quickly and easily achieve their desired outcomes.

### Triggering actions programmatically

AI Actions add-on exposes an API that allows for programmatic execution of actions.
With the API, developers can automate tasks and execute actions on batches of content by integrating them into workflows.
By issuing commands through the API, developers can trigger actions based on external events:
...

## Capabilities and use cases

### Management

...

### Extensibility

Built-in action types offer a good starting point, but the real power of AI Actions lies in extensibility.
Extending AI Actions opens up new possibilities for content management and editing.
Developers can extend the feature by adding new action types that use existing AI services or even integrating additional ones.
This involves defining a new action type in YAML, writing a handler that communicates with the new service, and creating a form for configuring the options that extends the action configuration form shown in the Admin Panel.
For example, a developer could write a handler that uses an AI service to generate complete articles based on a short description, or illustrations based on a body of an article.

### Use cases

#### ...

#### Generating Alt Text

Out of the box, the [[= product_name_base =]] AI Actions add-on comes with the generating alt text for images capability.
Organizations can benefit from it's use by improving accessibility and SEO.
Once the feature is configured, editors can generate alt text for images they upload to the system by clicking one button, while administrators can use the API to run a batch process against a larger collection of illustrations.
Before you can start generating alt text, some preliminary setup is required, which includes configuring access to an AI service.