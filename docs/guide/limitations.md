# Limitations

Limitations are part of the permissions system.
They limit the access granted to users by [Policies](permissions.md#permission-overview).
While a Policy grants the user access to a function, Limitations narrow it down by different criteria.

Limitations consist of two parts:

- `Limitation` (Value)
- `LimitationType`

Certain Limitations also serve as Role Limitations, which means they can be used to limit the rights of a Role assignment.
Currently this covers [Subtree](limitation_reference.md#subtreelimitation) and [Section](limitation_reference.md#sectionlimitation) Limitations.

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

All Content Policies can be assigned the [Content Type](limitation_reference.md#contenttypelimitation) and [Section](limitation_reference.md#sectionlimitation) Limitation.
Beyond that the following Limitations are available:

`content/read`:

- [Owner](limitation_reference.md#ownerlimitation)
- [User Group Limitation](limitation_reference.md#usergruplimitation)
- [Location](limitation_reference.md#locationlimitation)
- [Subtree](limitation_reference.md#subtreelimitation)
- [Object State](limitation_reference.md#objectstatelimitation)

`content/diff`:

- [Owner](limitation_reference.md#ownerlimitation)
- [Location](limitation_reference.md#locationlimitation)
- [Subtree](limitation_reference.md#subtreelimitation)

`content/view_embed`:

- [Owner](limitation_reference.md#ownerlimitation)
- [Location](limitation_reference.md#locationlimitation)
- [Subtree](limitation_reference.md#subtreelimitation)

`content/create`:

- [Location](limitation_reference.md#locationlimitation)
- [Subtree](limitation_reference.md#subtreelimitation)
- [Language](limitation_reference.md#languagelimitation)
- [Parent Owner](limitation_reference.md#parentownerlimitation)
- [Parent User Group](limitation_reference.md#parentusergrouplimitation)
- [Parent Content Type](limitation_reference.md#parentcontenttypelimitation)
- [Parent Depth](limitation_reference.md#parentdepthlimitation)

`content/edit`:

- [Owner](limitation_reference.md#ownerlimitation)
- [User Group Limitation](limitation_reference.md#usergruplimitation)
- [Location](limitation_reference.md#locationlimitation)
- [Subtree](limitation_reference.md#subtreelimitation)
- [Language](limitation_reference.md#languagelimitation)
- [Object State](limitation_reference.md#objectstatelimitation)
- [Workflow Stage](limitation_reference.md#workflowstagelimitation)

`content/publish`:

- [Owner](limitation_reference.md#ownerlimitation)
- [User Group Limitation](limitation_reference.md#usergruplimitation)
- [Location](limitation_reference.md#locationlimitation)
- [Subtree](limitation_reference.md#subtreelimitation)
- [Language](limitation_reference.md#languagelimitation)
- [Object State](limitation_reference.md#objectstatelimitation)
- [Workflow Stage](limitation_reference.md#workflowstagelimitation)

`content/manage_locations`:

- [Owner](limitation_reference.md#ownerlimitation)
- [Subtree](limitation_reference.md#subtreelimitation)
- [Object State](limitation_reference.md#objectstatelimitation)

`content/hide`:

- [Owner](limitation_reference.md#ownerlimitation)
- [User Group Limitation](limitation_reference.md#usergruplimitation)
- [Location](limitation_reference.md#locationlimitation)
- [Subtree](limitation_reference.md#subtreelimitation)
- [Language](limitation_reference.md#languagelimitation)

`content/translate`:

- [Owner](limitation_reference.md#ownerlimitation)
- [Location](limitation_reference.md#locationlimitation)
- [Subtree](limitation_reference.md#subtreelimitation)
- [Language](limitation_reference.md#languagelimitation)

`content/remove`:

- [Owner](limitation_reference.md#ownerlimitation)
- [Location](limitation_reference.md#locationlimitation)
- [Subtree](limitation_reference.md#subtreelimitation)
- [Object State](limitation_reference.md#objectstatelimitation)

`content/versionread`:

- [Owner](limitation_reference.md#ownerlimitation)
- [Status](limitation_reference.md#statuslimitation)
- [Location](limitation_reference.md#locationlimitation)
- [Subtree](limitation_reference.md#subtreelimitation)
- [Object State](limitation_reference.md#objectstatelimitation)

`content/versionremove`:

- [Owner](limitation_reference.md#ownerlimitation)
- [Status](limitation_reference.md#statuslimitation)
- [Location](limitation_reference.md#locationlimitation)
- [Subtree](limitation_reference.md#subtreelimitation)
- [Object State](limitation_reference.md#objectstatelimitation)

#### Section

`section/assign`:

- [Content Type](limitation_reference.md#contenttypelimitation)
- [Section](limitation_reference.md#sectionlimitation)
- [Owner](limitation_reference.md#ownerlimitation)
- [New Section](limitation_reference.md#newsectionlimitation)

#### State

`state/assign`:

- [Content Type](limitation_reference.md#contenttypelimitation)
- [Section](limitation_reference.md#sectionlimitation)
- [Owner](limitation_reference.md#ownerlimitation)
- [User Group Limitation](limitation_reference.md#usergruplimitation)
- [Location](limitation_reference.md#locationlimitation)
- [Subtree](limitation_reference.md#subtreelimitation)
- [Object State](limitation_reference.md#objectstatelimitation)
- [New Object State](limitation_reference.md#newobjectstatelimitation)

#### User

`user/assign`:

- [SiteAccess](limitation_reference.md#siteaccesslimitation)

#### Workflow

`workflow/change_stage`:

- [Workflow Transition](limitation_reference.md#workflowtransitionlimitation)

## Limitation reference

See [Limitation reference](limitation_reference.md) for detailed information about individual Limitations.
