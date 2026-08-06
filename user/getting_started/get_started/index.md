# Get started

Get started with Ibexa DXP by logging in to the back office.

Ibexa DXP consists of the technical platform for creating and managing online experiences, designed for developers and end-users alike. It includes a web framework, APIs and a content repository. It features a customizable user interface where you can work with the content, products, media, manage other functionalities, and administer the platform.

Depending on the product edition, Ibexa DXP can provide advanced capabilities in such areas as:

- [content management](../../content_management/content_management/index.md)
- [product management](../../product_catalog/product_catalog/index.md)
- [customer management](../../customer_management/customer_management/index.md)

> **Note: Installation**
>
> Only administrators can [install](../../../developer/getting_started/install_ibexa_dxp/index.md) Ibexa DXP. They should provide you with the address of the installation.

## Access the back office

To access the back office (or the user/editor interface), add `/admin` to the address provided by the administrator. For example, if your website's URL is `www.my-site.com`, you enter the editing interface through `www.my-site.com/admin`.

If you're the administrator, use the login credentials that were set [during the installation process](../../../developer/getting_started/install_ibexa_dxp/index.md#create-a-database).

Otherwise, to log in, you must get your user credentials from the administrator, and enter them on the login screen.

![Login screen](https://doc.ibexa.co/projects/userguide/en/5.0/getting_started/img/login_form.png "Login screen")

### Onboarding

When you log in to Ibexa DXP for the first time, interactive product tours may appear if the Integrated help [LTS update](../../../developer/ibexa_products/editions/index.md#lts-updates) is configured in your installation. This in-app walkthroughs guide you through key features and help you get started quickly.

You can complete each step of the onboarding tutorials, skip them entirely if you prefer to explore on your own, or restart them anytime from your [user settings](#user-settings) under the **Browsing** section.

### View and edit user profile

If you're an editor, depending on the system configuration, you may be able to view and edit the user profile, which can contain the following information:

- Avatar image
- First and last name
- Email
- Department
- Position
- Location
- Signature
- Roles the user is assigned to
- Recent activity

> **Note: Note**
>
> To display the [recent activity](../../recent_activity/recent_activity/index.md) log, your [user role](../../permission_management/permissions_and_users/index.md) must have the **Activity Log / Read** permission.

![User profile](https://doc.ibexa.co/projects/userguide/en/5.0/getting_started/img/user_profile_preview.png "User profile")

To access your user profile, in the upper-right corner of the screen, click your avatar icon. Then, from the drop-down menu, select **Profile**.

To edit your user profile, in the **User profile** screen, in the **Summary** section, click **Edit**.

You can now modify the following entries:

- Avatar image
- First and last name
- Signature
- Department

> **Note: Note**
>
> The fields may differ depending on your system configuration.

To edit your avatar, in the **Image** area, click **Upload file** or drag and drop your photo. If necessary, you can [edit the photo with the Image Editor](../../image_management/edit_images/index.md). After you finish, the avatar is uploaded and is visible in the back office.

![Edit avatar](https://doc.ibexa.co/projects/userguide/en/5.0/getting_started/img/user_profile_avatar.png "Edit avatar")

> **Note: Note**
>
> If you don't set your own image, a default avatar with your initials is displayed.

To save changes to the user profile, click **Update**.

### User settings

You can access your user settings on the right side of the top bar:

![User preferences menu](https://doc.ibexa.co/projects/userguide/en/5.0/getting_started/img/user_preferences.png)

Here you can [change your user password](index.md#change-the-password) and define your user preferences, such as preferred timezone, short and full date, and time format, or back office language.

#### Location

| Setting                               | Description                                                                               |
| ------------------------------------- | ----------------------------------------------------------------------------------------- |
| Default currency                      | Sets the default currency used in the back office.                                        |
| Toggle In-Context translation feature | Enables or disables integration with Crowdin to navigate the interface while translating. |
| User Time Zone                        | Sets time zone in the back office.                                                        |
| Short date and time format            | Sets short date and time format used in the back office.                                  |
| Full date and time format             | Sets full date and time format used in the back office.                                   |
| Language                              | Sets the default language used in the back office.                                        |

#### Content authoring

| Setting                                                                                                                           | Description                                                  |
| --------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------ |
| [Autosave draft every given period](../../content_management/content_versions/index.md#autosave) | Enables or disables autosaving drafts.                       |
| Seconds till next draft autosave                                                                                                  | Sets time period for next autosave.                          |
| Enable character count in online editor                                                                                           | Enables or disables character count.                         |
| Automatically open block settings in builders                                                                                     | Enables or disables the behavior of blocks used in builders. |

#### Browsing

| Setting                                | Description                                                                                                                                  |
| -------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------- |
| Number of items displayed in the table | Sets the number of items displayed in sub-items.                                                                                             |
| Location preview                       | Enables or disables a thumbnail preview on the content tree.                                                                                 |
| Help center                            | Enables or disables the [help center](../discover_ui/index.md#help-center). (LTS Update) |
| Product tour                           | Enables or disables the [product tour onboarding](#onboarding) walkthroughs. (LTS Update)                                                    |
| Product tour scenarios settings        | Separate setting for each available product tour scenario. Allows you to mark each scenario as completed or reset its progress. (LTS Update) |

#### Mode

| Setting    | Description                                                                                                                   |
| ---------- | ----------------------------------------------------------------------------------------------------------------------------- |
| Focus mode | Enables or disables the [focus mode](../discover_ui/index.md#focus-mode). |

#### Dashboard

| Setting          | Description                                         |
| ---------------- | --------------------------------------------------- |
| Active dashboard | Sets which dashboard is displayed after you log in. |

### Change the password

You can change your user [password](../../../developer/users/passwords/index.md) at any time. To do it, first, access your user profile, and go to **Account settings** tab. Then, click **Change password**.

![Change password](https://doc.ibexa.co/projects/userguide/en/5.0/getting_started/img/change_password.png "Change password")

Fill in all the required fields and click **Save and close** to save changes. Click **Discard** to reject your changes and return to the previous screen.

![Editing password](https://doc.ibexa.co/projects/userguide/en/5.0/getting_started/img/editing_password.png "Editing password")
