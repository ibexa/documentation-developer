---
description: Inject a sub-items list into your back office customizations.
---

# Sub-items list

The Sub-items List module is meant to be used as a part of the editorial interface of [[= product_name =]].
It provides an interface for listing the sub-items of any location.

!!! caution

    If you want to load the Sub-items module, you need to load the JS code for it in your view, as it's not available by default.

## Use sub-items list

With plain JS:

``` js
const containerNode = document.querySelector('#sub-items-container');

    ReactDOM.render(
        React.createElement(ibexa.modules.SubItems, {
            parentLocationId: { Number },
            restInfo: {
                token: { String },
                siteaccess: { String }
            }
        }),
        containerNode
    );
```

With JSX:

``` jsx
const attrs = {
    parentLocationId: {Number},
    restInfo: {
        token: {String},
        siteaccess: {String}
    }
};

<SubItemsModule {...attrs}/>
```

## Properties list

The `<SubItemsModule />` module can handle additional properties.
There are two types of properties: **required** and **optional**.
All of them are listed below.

### Required props

Without all the following properties the Sub-items module cannot work.

- **parentLocationId** _{Number}_ - parent location ID
- **restInfo** _{Object}_ - backend config object:
    - **token** _{String}_ - CSRF token
    - **siteaccess** _{String}_ - SiteAccess identifier
- **handleEditItem** _{Function}_ - callback to handle edit content action
- **generateLink** _{Function}_ - callback to handle view content action

### Optional properties

Optionally, Sub-items module can take a following list of props:

- **loadContentInfo** _{Function}_ - loads content item info. Takes two params:
    - **contentIds** _{Array}_ - list of content IDs
    - **callback** _{Function}_ - a callback invoked when content info is loaded
- **loadContentTypes** _{Function}_ - loads content types. Takes one param:
    - **callback** _{Function}_ - callback invoked when content types are loaded
- **loadLocation** _{Function}_ - loads location. Takes four params:
    - **restInfo** _{Object}_ - REST info params:
        - **token** _{String}_ - the user token
        - **siteaccess** _{String}_ - the current SiteAccess
    - **queryConfig** _{Object}_ - query config:
        - **locationId** _{Number}_ - location ID
        - **limit** _{Number}_ - content item limit
        - **offset** _{Number}_ - items offset
        - **sortClauses** _{Object}_ - the Sort Clauses, for example, {LocationPriority: 'ascending'}
    - **callback** _{Function}_ - callback invoked when location is loaded
- **updateLocationPriority** - updates item location priority. Takes two params:
    - **params** _{Object}_ - parameters hash containing:
        - **priority** _{Number}_ - priority value
        - **location** _{String}_ - REST location ID
        - **token** _{String}_ - CSRF token
        - **siteaccess** _{String}_ - SiteAccess identifier
    - **callback** _{Function}_ - callback invoked when location priority is updated
- **activeView** _{String}_ - active list view identifier
- **extraActions** _{Array}_ - list of extra actions. Each action is an object containing:
    - **component** _{Element}_ - React component class
    - **attrs** _{Object}_ - additional component properties
- **items** _{Array}_ - list of location's sub-items
- **limit** _{Number}_ - items limit count
- **offset** _{Number}_ - items limit offset
- **labels** _{Object}_ - list of module labels, see [sub.items.module.js](https://github.com/ibexa/admin-ui/blob/4.6/src/bundle/ui-dev/src/modules/sub-items/sub.items.module.js) for details. Contains definitions for sub components:
    - **subItems** _{Object}_ - list of sub-items module labels
    - **tableView** _{Object}_ - list of table view component labels
    - **tableViewItem** _{Object}_ - list of table item view component labels
    - **loadMore** _{Object}_ - list of load more component labels
    - **gridViewItem** _{Object}_ - list of grid item view component labels
- **languageContainerSelector** _{String}_ - selector where the language selector should be rendered

## Reuse Sub-items list

To add a Sub-items list on a page that doesn't have the (right) action sidebar, you need to do one of the following things:

- add a `<div>` element with the `.ibexa-extra-actions-container` selector
- change the selector in the Sub-items settings by sending the `languageContainerSelector` prop which takes the selector for the element that renders the `languageSelector`.
