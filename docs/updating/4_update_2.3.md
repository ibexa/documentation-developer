# Updating from <2.3
    
If you are updating from a version prior to 2.2, you have implement all the changes from [Updating from <2.2](4_update_2.2.md) before following the steps below.

!!! note

    During database update, you have to go through all the changes between your current version and your final version
    **e.g. during update from v2.2 to v2.5 you have to perform all the steps from: <2.3, <2.4 and <2.5**.
    Only after applying all changes your database will work properly.

## Database update script

Apply the following database update script:

`mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-7.2.0-to-7.3.0.sql`

## Changes to timestamp

A new timestamp column has been added in order to keep track of when items were trashed, this is exposed in the API but not yet in UI.

To apply this change, use the following database update script:

``` bash
mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-7.2.0-to-7.3.0.sql
```

## Form builder

!!! enterprise

    To create the *Forms* container under the content tree root use the following command:

    ``` bash
    php bin/console ezplatform:form-builder:create-forms-container
    ```

    You can also specify Content Type, Field values and language code of the container, e.g.:

    ``` bash
    php bin/console ezplatform:form-builder:create-forms-container --content-type custom --field title --value 'My Forms' --field description --value 'Custom container for the forms' --language-code eng-US
    ```

    You also need to run a script to add database tables for the Form Builder.
    You can find it in https://github.com/ezsystems/ezplatform-ee-installer/blob/2.3/Resources/sql/schema.sql#L136

    !!! caution "Form (ezform) Field Type"

        After the update, in order to create forms, you have to add a new Content Type (e.g. named "Form") that contains `Form` Field (this Content Type can contain other fields
        as well). After that you can use forms inside Landing Pages via Embed block.
 
You can now follow the steps from [Updating from <2.4](4_update_2.4.md).