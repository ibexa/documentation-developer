---
description: Install the AI Actions LTS update.
---

# Install AI Actions

AI Actions are available as an LTS update to [[= product_name =]] in version v4.6.x or higher, regardless of its edition.
To use this feature you must first install the packages and configure them.

## Install packages

Run the following command to install the bundle:

``` bash
composer require ibexa/connector-ai
composer require ibexa/connector-openai
```

This command adds the framework code, a service connector with the OpenAI service, service handlers, Twig templates, and configurations required for using AI Actions.
It also modifies the permission system to account for the new functionality.

## Configure AI Actions

Once the packages are installed, before you can start using AI Actions, you must enable them by following these instructions.

### Configure access to OpenAI

Create an OpenAI account, [get an API key](https://help.openai.com/en/articles/4936850-where-do-i-find-my-openai-api-key), and make sure that you [set up a billing method](https://help.openai.com/en/articles/9038407-how-can-i-set-up-billing-for-my-account).

Then, in the root folder of your project, modify the `.env` file: find the `OPENAI_API_KEY` key and replace a placeholder value with the API key that you got from the AI service.

```bash
###> ibexa/connector-openai ###
OPENAI_API_KEY=sk-svcacct-AFCrCt1h2s3i4s5i6s7t8h9e0a1p2i3c4o5d6e
###< ibexa/connector-openai ###
```

### Modify the database schema

Create the `add_ai_actions.sql` file that contains the following code:

```sql
[[= include_file('code_samples/ai_actions/config/add_ai_actions.sql') =]]
```

Run the following command. where `<database_name>` is the same name that you defined when you [installed [[= product_name =]]](../getting_started/install_ibexa_dxp.md#change-installation-parameters).

```bash
mysql -u root <database_name> < add_ai_actions.sql
```

This command modifies the existing database schema by adding database configuration required for using AI Actions.

You can now restart you application and start [working with the AI Actions feature]([[= user_doc =]]/ai_actions/work_with_ai_actions//).

### Install sample AI action configurations (optional)

By installing a collection of sample AI action configurations you can quickly start using the feature.
You do it by following a standard [data migration](importing_data.md) procedure:

```bash
php bin/console ibexa:migrations:import vendor/ibexa/connector-openai/src/bundle/Resources/migrations/action_configurations.yaml
php bin/console ibexa:migrations:migrate
```

Based on these examples, which reflect the most common use cases, you can learn to configure your own AI actions with greater ease.