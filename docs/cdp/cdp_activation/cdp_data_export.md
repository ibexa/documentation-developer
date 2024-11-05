---
description: Step-by-step data export procedure in Ibexa CDP.
edition: experience
---

# Data export

You need to specify a source of the user data that [[= product_name_cdp =]] will connect to.
To do so, go to **Data Manager** in **Tools** section and select **Create new dataflow**.
It will take you to a Dataflow Creator, where in five steps you will set up a data streaming.

## General Information

In the **General Information** section, specify dataflow name,
choose **Stream File** as a source of user data and **CDP** as a destination,
where they will be sent for processing.
Currently, only Stream File transport is supported and can be initialized from the configuration. 

## Download

In the **Download** section, select **Stream file**. 
Copy generated steam ID and paste it into the configuration file under `stream_id`.
It allows you to establish a datastream from the Streaming API into the Data Manager.

Next, you need to export your data to the CDP.
Go to your installation and use this command:

- for User:

```bash
php bin/console ibexa:cdp:stream-user-data --draft
```

- for Product:

```bash
php bin/console ibexa:cdp:stream-product-data --draft
```

- for Content:

```bash
php bin/console ibexa:cdp:stream-content-data --draft
```

There are two versions of this command `--draft/--no-draft`.
The first one is used to send the test user data to the Data Manager.
If it passes a validation test in the **Activation** section, use the latter one to send a full version.

Next, go back to [[= product_name_cdp =]] and select **Validate & download**.
If the file passes, you will see a confirmation message.
Now, you can go to the **File mapping** section.

## File mapping

Mapping is completed automatically, the system fills all required information and shows available columns with datapoints on the right.
You can change their names if needed or disallow empty fields by checking **Mandatory**.
If the provided file contains empty values, this option is not available.

If provided file is not recognized, the system will require you to fill in the parsing-options manually or select an appropriate format.
If you make any alterations, select the **Parse File** to generate columns with new data.

## Transform & Map

In the **Transform & Map** section you transform data and map it to a schema.
At this point, you can map **email** to **email** and **id** to **integer**  fields to get custom columns.

Next, select **Create schema based on the downloaded columns**.
It will move you to Schema Creator.
There, choose **PersonalData** as a parent and name the schema. 

![Create new schema](cdp_create_new_schema.png)

Next, select all the columns and set Person Identifier as **userid**.

![Person Identifier](cdp_person_identifier.png)

If you used PersonData or Catalog type schemas, the system will require
specifying the Write Mode that will be applied to them.

**Append** (default one) allows new data to overwrite the old one but leaves existing entries unaffected.
All entries are stored in the dataset, unchanged by updating dataflow.
For example, if a customer unsubscribes a newsletter, their email will remain in the system.
**Overwrite** completely removes the original dataset and replaces it with the new one every time the dataflow runs.

Next, select **userid** from a **Schema columns section** on the right and map it to **id**.

![Map userid to id](cdp_userid_mapid.png)

## Activation

In this section you will test the dataflow with provided test user data.
If everything passes, go to your installation and export production data with this command:

```bash
php bin/console ibexa:cdp:stream-user-data --no-draft
```

Now you can run and activate the dataflow.

## Build new Audience/Segment

Go to the **Audience Builder** and select **Build new audience**.
When naming the audience remember, you will need to find it in a drop-down list during activation.
There, you can choose conditions from `did`, `did not` or `have`.
The conditions `did` and `did not` allow you to use events like buy, visit or add to a cart from online tracking.
- `have` conditions are tied to personal characteristics and can be used to track the sum of all buys or top-visited categories.

In the Audience Builder, you can also connect created audiences to the activations.

## Activation

Activation synchronises data from [[= product_name_cdp =]] to the [[= product_name =]].
When you specify a segment, you can activate it on multiple communication channels, such as newsletters or commercials.
You can configure multiple activations based data flows.

First, from the menu bar, select **Activations** and create a new **Ibexa** activation.
Specify name of your activation, select `userid` as **Person Identifier** and click **Next**.

![General Information - Activation](cdp_activation_general_info.png)

Next, you can fill in **Ibexa information** they must match the ones provided in the YAML configuration:

- **Client Secret** and **Client ID** - are used to authenticate against Webhook endpoint. In the configuration they are taken from environment variables in `.env` file.

- **Segment Group Identifier** - identifier of the segment group in [[= product_name =]]. It points to a segment group where all the CDP audiences will be stored.
- **Base URL** - URL of your instance with added `/cdp/webhook` at the end.

![Ibexa Information - Activation](cdp_activation_ibexa_info.png)

Finally, you can specify the audiences you wish to include.

!!! note "CDP requests"

    All CDP requests are logged in with `debug` severity.
