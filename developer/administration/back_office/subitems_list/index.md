# Sub-items list

Inject a sub-items list into your back office customizations or customize the view.

The Sub-items List module is meant to be used as a part of the editorial interface of Ibexa DXP. It provides an interface for listing the sub-items of any location.

## Create custom sub-items list view

You can extend the Sub-items List module to replace an existing view or add your own. The example below adds a new timeline view to highlight the modification date.

![Sub-items List module using the new Timeline view](https://doc.ibexa.co/en/5.0/administration/back_office/img/subitems/timeline_view.png "Sub-items List module using the new Timeline view")

To recreate it, start by creating the components responsible for rendering the new view. You can create two files:

- `assets/js/timeline.view.component.js` responsible for rendering the whole view

```js
import React from 'react';
import PropTypes from 'prop-types';
import TimelineViewItemComponent from './timeline.view.item.component';

const TimelineViewComponent = ({ items, generateLink }) => {
    const groupByDate = (items) => {
        return items.reduce((groups, item) => {
            const date = new Date(item.content._info.modificationDate.timestamp * 1000);
            const dateKey = date.toISOString().split('T')[0];

            if (!groups[dateKey]) {
                groups[dateKey] = [];
            }

            groups[dateKey].push(item);
            return groups;
        }, {});
    };

    const groupedItems = groupByDate(items);

    return (
        <div className="app-timeline-view">
            {Object.entries(groupedItems).map(([date, dateItems]) => (
                <div key={date} className="app-timeline-view__group">
                    <div className="app-timeline-view__date">
                        <div className="app-timeline-view__date-marker" />
                        <h3>{new Date(date).toLocaleDateString()}</h3>
                    </div>
                    <div className="app-timeline-view__items">
                        {dateItems.map((item) => (
                            <TimelineViewItemComponent key={item.id} item={item} generateLink={generateLink} />
                        ))}
                    </div>
                </div>
            ))}
        </div>
    );
};

TimelineViewComponent.propTypes = {
    items: PropTypes.array.isRequired,
    generateLink: PropTypes.func.isRequired,
};

export default TimelineViewComponent;
```

- `assets/js/timeline.view.item.component.js` responsible for rendering a single item

```js
import React from 'react';
import PropTypes from 'prop-types';
import Icon from '@ibexa-admin-ui-modules/common/icon/icon';

const { ibexa } = window;

const TimelineViewItemComponent = ({ item, generateLink }) => {
    const { content } = item;
    const contentTypeIdentifier = content._info.contentType.identifier;
    const contentTypeIconUrl = ibexa.helpers.contentType.getContentTypeIconUrl(contentTypeIdentifier);
    const time = new Date(content._info.modificationDate.timestamp * 1000).toLocaleTimeString();

    return (
        <a className="app-timeline-view-item" href={generateLink(item.id, content._info.id)}>
            <div className="app-timeline-view-item__time">{time}</div>
            <div className="app-timeline-view-item__content">
                <div className="app-timeline-view-item__info">
                    <div className="app-timeline-view-item__name">{content._name}</div>
                    <div className="app-timeline-view-item__type">
                        <Icon customPath={contentTypeIconUrl} extraClasses="ibexa-icon--small" />
                        <span className="app-timeline-view-item__type-name">{content._info.contentType.name}</span>
                    </div>
                </div>
            </div>
        </a>
    );
};

TimelineViewItemComponent.propTypes = {
    item: PropTypes.object.isRequired,
    generateLink: PropTypes.func.isRequired,
};

export default TimelineViewItemComponent;
```

Provide the necessary styling in `assets/scss/timeline.view.scss`. The example below uses Ibexa DXP's SCSS variables for consistency with the rest of the back office interface.

```scss
@use '@ibexa-admin-ui/src/bundle/Resources/public/scss/custom.scss' as *;

.app-timeline-view {
    padding: calculateRem(16px);

    &__group {
        position: relative;
        margin-bottom: calculateRem(32px);
    }

    &__date {
        display: flex;
        align-items: center;
        margin-bottom: calculateRem(16px);

        h3 {
            margin: 0;
            font-size: $ibexa-text-font-size-large;
            color: $ibexa-color-dark;
        }
    }

    &__date-marker {
        width: calculateRem(12px);
        height: calculateRem(12px);
        border-radius: 50%;
        background: $ibexa-color-primary;
        margin-right: calculateRem(16px);
    }

    &__items {
        margin-left: calculateRem(6px);
        padding-left: calculateRem(32px);
        border-left: calculateRem(2px) solid $ibexa-color-light;
    }
}

.app-timeline-view-item {
    display: flex;
    align-items: flex-start;
    padding: calculateRem(16px);
    margin-bottom: calculateRem(8px);
    text-decoration: none;
    color: inherit;
    background: $ibexa-color-light-300;
    border-radius: $ibexa-border-radius;
    transition: background-color 0.2s $ibexa-admin-transition;

    &:hover {
        background: $ibexa-color-light-400;
    }

    &__time {
        color: $ibexa-color-dark-400;
        margin-right: calculateRem(16px);
        min-width: calculateRem(80px);
    }

    &__content {
        display: flex;
        align-items: center;
    }

    &__icon {
        margin-right: calculateRem(16px);
    }

    &__name {
        font-weight: $ibexa-font-weight-bold;
        margin-bottom: calculateRem(4px);
    }

    &__type {
        font-size: $ibexa-text-font-size-small;
        color: $ibexa-color-dark-400;
        display: flex;
        align-items: center;
        gap: calculateRem(8px);
    }

    &__type-name {
        line-height: calculateRem(16px);
    }
}
```

The last step is adding the view module to the list of available views in the system, by using the provided `registerView` function.

You can create a new view by providing an unique identifier, or replace an existing one by reusing its identifier. The existing view identifiers are defined as JavaScript constants in the `@ibexa-admin-ui-modules/sub-items/constants` module:

- Grid view: `VIEW_MODE_GRID` constant
- Table view: `VIEW_MODE_TABLE` constant

Create a file called `assets/js/registerTimelineView.js`:

```js
import TimelineViewComponent from './timeline.view.component.js';
import { registerView } from '@ibexa-admin-ui-modules/sub-items/services/view.registry';

// Use the existing constants to replace a view
import { VIEW_MODE_GRID, VIEW_MODE_TABLE } from '@ibexa-admin-ui-modules/sub-items/constants';

registerView('timeline', {
    component: TimelineViewComponent,
    iconName: 'timeline',
    label: 'Timeline view',
});
```

And include it into the back office using Webpack Encore, together with your custom styles. See [configuring assets from main project files](../back_office_elements/importing_assets_from_bundle/index.md#configuration-from-main-project-files) to learn more about this mechanism.

```js
const ibexaConfigManager = require('@ibexa/frontend-config/webpack-config/manager');
const getIbexaConfig = require('@ibexa/frontend-config/webpack-config/ibexa');
const ibexaConfig = getIbexaConfig();

//…

ibexaConfigManager.add({
    ibexaConfig,
    entryName: 'ibexa-admin-ui-layout-js',
    newItems: [
        path.resolve(__dirname, './assets/js/registerTimelineView.js')
    ],
});

ibexaConfigManager.add({
    ibexaConfig,
    entryName: 'ibexa-admin-ui-layout-css',
    newItems: [
        path.resolve(__dirname, './assets/scss/timeline.view.scss'),
    ],
});

module.exports = [ibexaConfig, ...customConfigs, projectConfig];
```

Complete the task by running `composer run post-install-cmd`.

## Use sub-items list

> **Caution: Caution**
>
> If you want to load the Sub-items module from your custom code, you need to load the JS code for it in your view, as it's not available by default.

With plain JS:

```js
const containerNode = document.querySelector('#sub-items-container');

ReactDOM.render(
    React.createElement(ibexa.modules.SubItems, {
        parentLocationId: { Number },
        restInfo: {
            token: { String },
            siteaccess: { String },
        },
    }),
    containerNode,
);
```

With JSX:

```jsx
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

The `<SubItemsModule />` module can handle additional properties. There are two types of properties: **required** and **optional**. All of them are listed below.

### Required props

Without all the following properties the Sub-items module cannot work.

- **parentLocationId** *{Number}* - parent location ID
- **restInfo** *{Object}* - backend config object:
  - **token** *{String}* - CSRF token
  - **siteaccess** *{String}* - SiteAccess identifier
- **handleEditItem** *{Function}* - callback to handle edit content action
- **generateLink** *{Function}* - callback to handle view content action

### Optional properties

Optionally, Sub-items module can take a following list of props:

- **loadContentInfo** *{Function}* - loads content item info. Takes two params:
  - **contentIds** *{Array}* - list of content IDs
  - **callback** *{Function}* - a callback invoked when content info is loaded
- **loadContentTypes** *{Function}* - loads content types. Takes one param:
  - **callback** *{Function}* - callback invoked when content types are loaded
- **loadLocation** *{Function}* - loads location. Takes four params:
  - **restInfo** *{Object}* - REST info params:
    - **token** *{String}* - the user token
    - **siteaccess** *{String}* - the current SiteAccess
  - **queryConfig** *{Object}* - query config:
    - **locationId** *{Number}* - location ID
    - **limit** *{Number}* - content item limit
    - **offset** *{Number}* - items offset
    - **sortClauses** *{Object}* - the Sort Clauses, for example, {LocationPriority: 'ascending'}
  - **callback** *{Function}* - callback invoked when location is loaded
- **updateLocationPriority** - updates item location priority. Takes two params:
  - **params** *{Object}* - parameters hash containing:
    - **priority** *{Number}* - priority value
    - **location** *{String}* - REST location ID
    - **token** *{String}* - CSRF token
    - **siteaccess** *{String}* - SiteAccess identifier
  - **callback** *{Function}* - callback invoked when location priority is updated
- **activeView** *{String}* - active list view identifier
- **extraActions** *{Array}* - list of extra actions. Each action is an object containing:
  - **component** *{Element}* - React component class
  - **attrs** *{Object}* - additional component properties
- **items** *{Array}* - list of location's sub-items
- **limit** *{Number}* - items limit count
- **offset** *{Number}* - items limit offset
- **labels** *{Object}* - list of module labels, see [sub.items.module.js](https://github.com/ibexa/admin-ui/blob/5.0/src/bundle/ui-dev/src/modules/sub-items/sub.items.module.js) for details. Contains definitions for sub components:
  - **subItems** *{Object}* - list of sub-items module labels
  - **tableView** *{Object}* - list of table view component labels
  - **tableViewItem** *{Object}* - list of table item view component labels
  - **loadMore** *{Object}* - list of load more component labels
  - **gridViewItem** *{Object}* - list of grid item view component labels
- **languageContainerSelector** *{String}* - selector where the language selector should be rendered

## Reuse Sub-items list

To add a Sub-items list on a page that doesn't have the (right) action sidebar, you need to do one of the following things:

- add a `<div>` element with the `.ibexa-extra-actions-container` selector
- change the selector in the Sub-items settings by sending the `languageContainerSelector` prop which takes the selector for the element that renders the `languageSelector`.
