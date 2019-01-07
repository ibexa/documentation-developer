# Content Model

## Content model overview

The content structure in eZ Platform is based on "objects". An "object" in eZ Platform is called a Content item and represents a single piece of content: an article, a blog post, an image, a product, etc. Each Content item is an instance of a "class," called a Content Type.

An introduction to the eZ content model aimed at non-developer users, is available in [eZ Platform user documentation](https://doc.ezplatform.com/projects/userguide/en/latest/content_model/).

## Content items

A Content item is the basic unit of content that is managed in eZ Platform.

A Content item is made up of different Fields and their values, as defined by the [Content Type](#content-types). These [Fields](#fields) can cover data ranging from single variables and text lines to media files or blocks of formatted text.

Aside from the Fields, each Content item also has the following general information:

#### Content item general information

**Content ID** – a unique number by which the Content item is identified in the system. These numbers are not recycled, so if an item is deleted, its ID number will not be reused when a new one is created.

**Name** – a user-friendly name for the Content item. The name is generated automatically based on a pattern specified in the Content Type definition.

!!! note

    Content item Name is always searchable, even if the Field(s) used to generate it are not.

**Type** – the Content Type on which the Content item is based.

**Owner** – the user who initially created the Content item. It is set by the system the first time the Content item is published. The ownership of an item cannot be modified and will not change even if the owner is removed from the system.

**Creation time** – date and time when the Content item was published for the first time. This is set by the system and cannot be modified.

**Modification time** – date and time when the Content item was last modified. This is set by the system and cannot be modified manually, but will change every time the item is published again.

**Status** – the current state of the Content item. It can have three statuses: 0 – Draft, 1 – Published and 2 – Archived. When an item is created, its status is set to *draft*. After publishing the status changes to *published*. When a published Content item is moved to Trash, the item becomes *archived*. If a published item is removed from the Trash (or removed without being put in the Trash first), it will be permanently deleted. 

**Section ID** – the unique number of the Section to which the Content item belongs. New Content items are placed in the Standard section by default. This behavior can be changed, but content must always belong to some Section.

**Versions** – total number of versions of this Content item. A new version is created every time the Content item is modified and it is this new version that is edited. The previous / published version along with earlier versions remain untouched and its status changed to *Archived*. A Content item always has at least one version. 

![Diagram of an example Content item](img/content_model_item_diagram.png)

The Fields of a Content item are defined by the Content Type to which the Content item belongs.

## Content Types

### Content Type metadata

Each Content Type is characterized by a set of metadata which define the general behavior of its instances:

**Name** – a user-friendly name that describes the Content Type. This name is used in the interface, but not internally by the system. It can consist of letters, digits, spaces and special characters; the maximum length is 255 characters. (Mandatory.)

!!! note

    Note that even if your Content Type defines a Field intended as a name for the Content item (for example, a title of an article or product name), do not confuse it with this Name, which is a piece of metadata, not a Field.

**Identifier** – an identifier for internal use in configuration files, templates, PHP code, etc. It must be unique, can only contain lowercase letters, digits and underscores; the maximum length is 50 characters. (Mandatory.)

**Description** – a detailed description of the Content Type. (Optional.)

**Content name pattern** – a pattern that defines what name a new Content item based on this Content Type gets. The pattern usually consists of Field identifiers that tell the system which Fields it should use when generating the name of a Content item. Each Field identifier has to be surrounded with angle brackets. Text outside the angle brackets will be included literally. If no pattern is provided, the system will automatically use the first Field. (Optional.)

**URL alias name pattern** – a pattern which controls how the virtual URLs of the Locations will be generated when Content items are created based on this Content Type. Note that only the last part of the virtual URL is affected. The pattern works in the same way as the Content name pattern. Text outside the angle brackets will be converted using the selected method of URL transformation. If no pattern is provided, the system will automatically use the name of the Content item itself. (Optional.)

!!! tip "Changing URL alias and Content name patterns"

    If you change the Content name pattern or the URL alias name pattern,
    existing Content items will not be modified automatically.
    The new pattern will only be applied after you modify the Content item and save a new version.

    The old URL aliases will continue to redirect to the same Content items.

**Container** – a flag which indicates if Content items based on this Content Type are allowed to have sub-items or not.

!!! note

    This flag was added for convenience and only affects the interface. In other words, it doesn't control any actual low-level logic, it simply controls the way the graphical user interface behaves.

**Default field for sorting children** – rule for sorting sub-items. If the instances of this Content Type can serve as containers, their children will be sorted according to what is selected here.

**Default sort order** – another rule for sorting sub-items. This decides the sort order for the criterion chosen above.

**Default content availability** – a flag which indicates if Content items of this Content Type should be available even without a corresponding language version. If this flag is not set, a Content item of this Type will not be available when it does not have a language version corresponding to the current SiteAccess. By setting this flag you can make instances of this Content Type available regardless of the language criterion.

![Creating a new Content Type](img/admin_panel_new_content_type.png)

### Field definitions

Aside from the metadata, a Content Type contains any number of Field definitions (but has to contain at least one). They determine what Fields of what Field Types will be included in all Content items based on this Content Type.

A Content Type and its Field definitions can be modified after creation, even if there are already Content items based on it in the system. When a Content Type is modified, each of its instances will be changed as well. If a new Field definition is added to a Content Type, this Field will appear (empty) in every relevant Content item. If a Field definition is deleted from the Content Type, all the corresponding Fields will be removed from Content items of this type.

![Diagram of an example Content Type](img/content_model_type_diagram.png)

!!! note

    You can assign each Field defined in a Content Type to a group by selecting one of the groups in the Category drop-down. [Available groups can be configured in the content repository](configuration.md#content-repository-configuration).

## Fields

A Field is the smallest unit of storage in the content model and the building block of all Content items. Every Field belongs to a Field Type.

### Field value validation

The values entered in a Field may undergo validation, which means the system makes sure that they are correct for the chosen Field Type and can be used without a problem.

Whether validation is performed or not depends on the settings of a particular Field Type. Validation cannot be turned off for a Field if its Field Type supports it.

### Field details

Aside from the Field Type, the Field definition in a Content Type provides the following information:

**Name** – a user-friendly name that describes the Field. This name is used in the interface, but not internally by the system. It can consist of letters, digits, spaces and special characters; the maximum length is 255 characters. If no name is provided, a unique one is automatically generated.

**Identifier** – an identifier for internal use in configuration files, templates, PHP code, etc. It can only contain lowercase letters, digits and underscores; the maximum length is 50 characters. This identifier is also used in name patterns for the Content Type.

**Description** – a detailed description of the Field.

**Required** – a flag which indicates if the Field is required for the system to accept the Content item. In other words, if a Field is flagged as Required, a user will not be able to save or publish a Content item without filling in this Field.

Note that the Required flag is in no way related to Field validation. A Field's value is validated whether the Field is set as required or not.

**[Searchable](search.md)** – a flag which indicates if the value of the Field will be indexed for searching.

The Searchable flag is not available for some Fields, because some Field Types do not allow searching through their values.

**[Translatable](internationalization.md)** – a flag which indicates if the value of the Field can be translated. This is independent of the Field Type, which means that even Fields of Types such as "Float" or "Image" can be set as translatable.

Depending on the Field Type, there may also be other, specific information to fill in. For example, the "Country" Field Type allows you to select the default country, as well as to allow selecting multiple countries at the same time.

![Diagram of content model](img/content_model_diagram.png)
