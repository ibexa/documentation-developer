# Limitations

Limitations are part of the permissions system.
They limit the access granted to users by [Policies](permissions.md#permission-overview).
While a Policy grants the user access to a function, Limitations narrow it down by different criteria.

Limitations consist of two parts:

- `Limitation` (Value)
- `LimitationType`

Certain Limitations also serve as Role Limitations, which means they can be used to limit the rights of a Role assignment.
Currently this covers [Subtree](#subtreelimitation) and [Section](#sectionlimitation) Limitations.

`Limitation` represents the value, while `LimitationType` deals with the business logic surrounding how it actually works and is enforced.
`LimitationTypes` have two modes of operation in regards to permission logic (see [`eZ\Publish\SPI\Limitation\Type`](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/SPI/Limitation/Type.php) interface for more info):

| Method | Use |
|--------|-----|
| `evaluate` | Evaluates if the User has access to a given object in a certain context (for instance the context can be Locations when the object is `Content`), under the condition of the `Limitation` value(s). |
| `getCriterion` | Generates a `Criterion` using `Limitation` value and current User which `SearchService` by default applies to search criteria for filtering search based on permissions. |

## Available Limitations

!!! tip

    Core Policies with Limitations are defined in [`EzPublishCoreBundle/Resources/config/policies.yml`](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/settings/policies.yml).

Each function in one of the four modules (content, section, state and user) can be assigned different Limitations.

!!! tip "Functions without Limitations"

    If a function is not mentioned below, it can have no Limitations.

#### Content

All Content Policies can be assigned the [Content Type](#contenttypelimitation) and [Section](#sectionlimitation) Limitation.
Beyond that the following Limitations are available:

`content/read`:

- [Owner](#ownerlimitation)
- [User Group Limitation](#usergruplimitation)
- [Location](#locationlimitation)
- [Subtree](#subtreelimitation)
- [Object State](#objectstatelimitation)

`content/diff`:

- [Owner](#ownerlimitation)
- [Location](#locationlimitation)
- [Subtree](#subtreelimitation)

`content/view_embed`:

- [Owner](#ownerlimitation)
- [Location](#locationlimitation)
- [Subtree](#subtreelimitation)

`content/create`:

- [Location](#locationlimitation)
- [Subtree](#subtreelimitation)
- [Language](#languagelimitation)
- [Parent Owner](#parentownerlimitation)
- [Parent User Group](#parentusergrouplimitation)
- [Parent Content Type](#parentcontenttypelimitation)
- [Parent Depth](#parentdepthlimitation)

`content/edit`:

- [Owner](#ownerlimitation)
- [User Group Limitation](#usergruplimitation)
- [Location](#locationlimitation)
- [Subtree](#subtreelimitation)
- [Language](#languagelimitation)
- [Object State](#objectstatelimitation)
- [Workflow Stage](#workflowstagelimitation)

`content/publish`:

- [Owner](#ownerlimitation)
- [User Group Limitation](#usergruplimitation)
- [Location](#locationlimitation)
- [Subtree](#subtreelimitation)
- [Language](#languagelimitation)
- [Object State](#objectstatelimitation)
- [Workflow Stage](#workflowstagelimitation)

`content/manage_locations`:

- [Owner](#ownerlimitation)
- [Subtree](#subtreelimitation)
- [Object State](#objectstatelimitation)

`content/hide`:

- [Owner](#ownerlimitation)
- [User Group Limitation](#usergruplimitation)
- [Location](#locationlimitation)
- [Subtree](#subtreelimitation)
- [Language](#languagelimitation)

`content/translate`:

- [Owner](#ownerlimitation)
- [Location](#locationlimitation)
- [Subtree](#subtreelimitation)
- [Language](#languagelimitation)

`content/remove`:

- [Owner](#ownerlimitation)
- [Location](#locationlimitation)
- [Subtree](#subtreelimitation)
- [Object State](#objectstatelimitation)

`content/versionread`:

- [Owner](#ownerlimitation)
- [Status](#statuslimitation)
- [Location](#locationlimitation)
- [Subtree](#subtreelimitation)
- [Object State](#objectstatelimitation)

`content/versionremove`:

- [Owner](#ownerlimitation)
- [Status](#statuslimitation)
- [Location](#locationlimitation)
- [Subtree](#subtreelimitation)
- [Object State](#objectstatelimitation)

#### Section

`section/assign`:

- [Content Type](#contenttypelimitation)
- [Section](#sectionlimitation)
- [Owner](#ownerlimitation)
- [New Section](#newsectionlimitation)

#### State

`state/assign`:

- [Content Type](#contenttypelimitation)
- [Section](#sectionlimitation)
- [Owner](#ownerlimitation)
- [User Group Limitation](#usergruplimitation)
- [Location](#locationlimitation)
- [Subtree](#subtreelimitation)
- [Object State](#objectstatelimitation)
- [New Object State](#newobjectstatelimitation)

#### User

`user/assign`:

- [SiteAccess](#siteaccesslimitation)

#### Workflow

`workflow/change_stage`:

- [Workflow Transition](#workflowtransitionlimitation)

## Limitation reference

See [Limitation reference](limitation_reference.md) for detailed information about individual Limitations.
