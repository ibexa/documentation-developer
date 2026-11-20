# Collaborative editing

Learn about Collaborative editing feature and its capabilities.

Collaborative editing is a feature that allows multiple users to work on the same content simultaneously - whether to preview, review, or edit it. By giving users access to preview the content before it's published, review and collaboration become much easier. An additional option here is the ability to copy a link to the content item, which allows to share it through communication channels. It improves collaboration with members of other teams, such as subject matter experts, compliance professionals, and sales representatives, to increase content quality.

A more advanced part of the collaboration feature is the Real-time editing. Users can edit and review content in real time, making teamwork faster, more efficient, and streamlining the content review process. The system automatically tracks changes, allowing seamless collaboration within a single content item.

## Collaboration session

When you create a new draft of content item you can invite other users to join a collaboration session.

To invite collaborators, click the **Share** button, which creates a new collaboration session.

![Share button](https://doc.ibexa.co/projects/userguide/en/5.0/content_management/img/share_button.png)

Then, in a pop-up window, you can invite users to newly created session.

You can only invite users with permissions to access the shared content. Users without permissions are grayed out and you can't select them and invite them to the session.

You can invite two types of users:

- **Internal** - by searching their name or email address. These users can either edit the content item or preview it, depending on your choice. Their account permissions determine whether they can invite additional users.

![Internal users - invitation](https://doc.ibexa.co/projects/userguide/en/5.0/content_management/img/invite_internal_user.png)

- **External** - by providing their email address in the field. They can only preview the content item (editing option isn't available, it's grayed out).

![External users - invitation](https://doc.ibexa.co/projects/userguide/en/5.0/content_management/img/invite_external_user.png)

To confirm the provided email address, press the **Enter** key on your keyboard.

After inviting the user by clicking the **Invite** button, they appear in the *People with access* list. In the same pop-up window, you can change the type of access for specific user, for example, by granting them the ability to preview the content, or remove access. To do it, click the **Arrow symbol** and select the option from the list.

![Change access](https://doc.ibexa.co/projects/userguide/en/5.0/content_management/img/change_access.png)

Additionally, you can share a direct link to the collaborative session without specifying a particular user. To do it, click the **Copy link** button. Link is copied to the clipboard and you can share it with the users through communication channels.

Use the **Link settings** button to control whether a user needs an account in the system to preview content using the direct link.

After inviting users to a collaboration session, they receive a notification:

- visible when clicking the **Notification** icon on the main dashboard (internal users)
- by email (external users)

![Notification - internal user](https://doc.ibexa.co/projects/userguide/en/5.0/content_management/img/internal_notification.png)

Collaboration session begins when first invited user accepts the invitation and joins the session, and ends when the owner performs one of the action:

- save and close
- publish the content (including "Publish later" option)
- delete content draft
- discard
- move the draft in the workflow
- end collaboration session

Users can also join a collaboration session using the **Join** button:

- available in new tabs of the **My content** block on the dashboard - *My shared drafts* and *Drafts shared with me*
- by accessing a content draft in the **Drafts** menu

Each user can leave collaboration session anytime or rejoin it.

### Real-time collaboration

Real-time collaboration is an advanced option of the Collaborative editing feature. It works by syncing changes in real time, so everyone can see updates instantly.

Users can edit the content only if an administrator gives them the necessary permissions. These permissions must be set before the user is invited to the session, otherwise the **Edit** access option is unavailable (grayed out).

While editing Rich Text fields, you can see colored tracking tags with user avatar thumbnails that indicate who is currently working on it.

![Collaboration - users tags](https://doc.ibexa.co/projects/userguide/en/5.0/content_management/img/users_tags.png)

This allows other users in the same session, who are working the same content, to see what each person is editing in real time.

You can see all users belonging to a given content item's collaboration session. Avatars of the users invited to collaboration session are visible at the top of the editing screen, also in distraction free mode.

When you hover over the user avatar, the user’s first and last name is displayed. If you want to see all participants list, click at the avatars group.

![Participants list](https://doc.ibexa.co/projects/userguide/en/5.0/content_management/img/participants_list.png)

#### Real-time collaboration Terms of Service changes

Real-Time Collaboration service is only available after accepting its Terms and Conditions. When Ibexa releases a new version of this document, you will see a notification in content edit forms that the new version must be accepted before the appointed deadline.

If not done in that time, the Real-Time Collaboration service will be disabled until the latest Terms and Conditions are accepted.

To proceed with accepting the new version, contact your Ibexa DXP implementation partner.

## Editing content item

Collaborative editing is enabled in Rich Text fields. Other fields are disabled and can be only edited by the owner of the content item.

Collaboration is available for the following content types containing Rich Text fields:

- Article
- Folder
- Form
- Custom content types

There are two modes of the collaboration:

- **Real-time (online)** - editing content at the same time with real-time tracking of the presence and changes of other users
- **Asynchronous** - editing content independently

> **Warning: Warning**
>
> Only the owner can publish content, save it, delete the draft, or publish it. Changes are automatically saved when the owner saves or publishes the content. Users can continue collaboration without the owner presence, but they cannot save, or publish changes. They can also leave collaboration session any time without losing data.

## Work with draft

You can access created draft in **Content** -> **Drafts**. Here you can join your collaboration session, share with more users, edit given permissions, or delete the draft.

![Work with draft](https://doc.ibexa.co/projects/userguide/en/5.0/content_management/img/work_with_draft.png)

## Dashboard blocks

Collaborative editing feature brings two new tabs in **My content** dashboard block:

- **My shared drafts** - displays all drafts with active collaborations and shared by the user. Includes following columns: Name, Content type, Modified language, Version, Modified, Shared with (lists all the users who received the invitation to the collaboration session). From this tab, you can perform following actions: Share, Join, Edit
- **Drafts shared with me** - displays all drafts with active collaborations and shared with the user. Includes following columns: Name, Content type, Modified language, Version, Modified, Shared by (displays the user who invited to join the collaboration session). From this tab, you can perform following action: Join

From the dashboard, you can share drafts or join collaboration session for selected content draft.

![Dashboard block - My content - new tabs](https://doc.ibexa.co/projects/userguide/en/5.0/content_management/img/my_content_tabs.png)
