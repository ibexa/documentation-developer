# Work with websites

Use Site Factory to easily create multiple websites, with different designs and subsets of content, based on common skeletons.

Editions: Experience

If multisite support is enabled for your instance of Ibexa DXP, you can use Site Factory to create and manage multiple websites from one place. These websites can, for example, be in different languages, or customized for different audiences, and still be kept in the repository of your installation. To be able to use it, the Site Factory has to be enabled and configured by the administrator. For more information, see Developer Documentation on [Site Factory](../../../developer/multisite/site_factory/site_factory/index.md).

## Create a website

To access Site Factory, in the left panel, click the **Site Management** icon and then **Sites**. If Site Factory is enabled, and you have sufficient permissions, you should see the **Create** button. Click it to access the **Creating New Site** modal.

![Site Factory icon](https://doc.ibexa.co/projects/userguide/en/5.0/website_organization/img/site_factory_icon.png)

Here, you can create an entirely new website or a different language version of an already existing website. First, select a name, a predefined design, and a Parent location for your website.

![Create a new website - step one](https://doc.ibexa.co/projects/userguide/en/5.0/website_organization/img/site_factory_new_site_step_1.png)

If the design defines a Site skeleton, you can choose if you want to copy the entire content structure of the design with a toggle. To preview the Site skeleton architecture, click **Site management**, and then **Site skeletons**.

Next, you can decide if the website goes live after creation or is offline with the Status switcher. In this section you also define the SiteAccess URL addresses with their main languages, fallback languages, and optional paths for the website.

> **Note: Path limitation**
>
> The path can be only one directory deep. Do not use paths that have more than one element, for example, `/en/articles`.

For more information about SiteAccesses, see [Multisite](../../../developer/multisite/multisite/index.md).

![Create a new website - step two](https://doc.ibexa.co/projects/userguide/en/5.0/website_organization/img/site_factory_new_site_step_2.png)

If all required fields are filled out, click **Save and close** to create new website and add it to the website list in the **Site management** area.

> **Note: Note**
>
> A SiteAccess that you create in Site Factory is always treated with lower priority than a SiteAccess defined by the administrator as part of [configuration](../../../developer/multisite/multisite_configuration/index.md#siteaccess-configuration). For example, if you create a website that uses the `fr` path in Site Factory, and the administrator defines a French website manually in configuration files, your website is ignored by the system.

You can see all the details of created website. To do it, go to **Site management** -> **Sites** and click the three dots icon next to the website name. Then, select **Site details**.

![Site details](https://doc.ibexa.co/projects/userguide/en/5.0/website_organization/img/site_details.png)

## Edit an existing website

To edit the website, click the three dots icon that is situated next to the website name, and select **Site settings**. Here, you can edit all the elements you selected during creation of the website:

- name
- design
- visibility
- URL
- language

## Delete an existing website

To enable deleting a website you have to change the website status to offline. Live websites cannot be deleted. Next, select the **Delete** icon and confirm your choice.

![Site list](https://doc.ibexa.co/projects/userguide/en/5.0/website_organization/img/site_factory_site_list.png)
