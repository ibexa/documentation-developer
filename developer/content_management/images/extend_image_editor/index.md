# Extend Image Editor

Add new functionalities to the image editor.

With the Image Editor, users can do basic image modifications. You can configure the Image Editor's [default appearance or behavior](../configure_image_editor/index.md). You can also extend it by adding custom features.

The following example shows how to extend the Image Editor by adding a button that draws a dot at a random location on the image.

## Create the JavaScript component file

In `assets/random_dot/`, create the `random-dot.js` file with the following code of the React component:

```js
import React, { useContext } from 'react';
import PropTypes from 'prop-types';

const { ibexa } = window;

const IDENTIFIER = 'dot';

const Dot = () => {
    return (
        <div className="c-image-editor-dot">
            <button type="button" className="btn btn-secondary">
                Add dot
            </button>
        </div>
    );
};

Dot.propTypes = {};

Dot.defaultProps = {};

export default Dot;

ibexa.addConfig(
    'imageEditor.actions.dot', // The ID ("dot") must match the one from the configuration yaml file
    {
        label: 'Dot',
        component: Dot,
        icon: ibexa.helpers.icon.getIconPath('form-radio'), // Path to an icon that will be displayed in the UI
        identifier: IDENTIFIER, // The identifier must match the one from the configuration yaml file
    },
    true,
);
```

The code doesn't perform any action yet, you add the action in the following steps.

## Add configuration

Configure the new Image Editor action under the `ibexa.system.<scope>.image_editor` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files):

```yaml
ibexa:
    system:
        default:
            image_editor:
                action_groups:
                    default:
                        id: default
                        label: Default
                        actions:
                            dot:
                                id: dot
                                priority: 50
```

## Add entry to the Webpack configuration

Once you create and configure the React component, you must add an entry to [the Webpack configuration](../../../tutorials/beginner_tutorial/3_customize_the_front_page/index.md#configuring-webpack). In the root directory of your project, modify the `webpack.config.js` file by appending the following code:

```js
/* Get ibexaConfig and ibexaConfigManager */
const ibexaConfigManager = require('@ibexa/frontend-config/webpack-config/manager');
const getIbexaConfig = require('@ibexa/frontend-config/webpack-config/ibexa');
const ibexaConfig = getIbexaConfig();

/* Add dot action to Admin UI layout JS */
ibexaConfigManager.add({
    ibexaConfig,
    entryName: 'ibexa-admin-ui-layout-js',
    newItems: [ path.resolve(__dirname, './assets/random_dot/random-dot.js'), ],
});

/* Export updated ibexaConfig and previous modules */
module.exports = [ibexaConfig, ...customConfigs, projectConfig];
```

At this point you should be able to see a new button in the Image Editor's UI.

> **Tip: Tip**
>
> Before you restart Ibexa DXP, run `php bin/console cache:clear` and `yarn encore <dev|prod>` to regenerate the assets.

## Expand the React component

The button that you created above doesn't initiate any action yet. You must modify the JavaScript component to add a function to the button.

### Contexts

When you create a React-based extension of the Image Editor, you can use a number of contexts that have the following functions:

- CanvasContext - stores a canvas that displays the image, on which you can modify the image
- ImageHistoryContext - stores the image history used by the Undo/Redo feature
- AdditionalDataContext - stores additional data that is attached to the image, for example, focal point coordinates
- TechnicalCanvasContext - stores a canvas, which you can use to draw elements that help modify the image, for example, a crop area or a grid, without interrupting with the actual image

The last context is not used in this example.

### Draw a dot

Modify the `random-dot.js` file by creating a function that uses the canvas context to draw a random dot on the image:

```js
    const drawDot = () => {
        const ctx = canvas.current.getContext('2d');
        const positionX = Math.random() * canvas.current.width;
        const positionY = Math.random() * canvas.current.height;

        ctx.save();

        ctx.fillStyle = '#ae1164';

        ctx.beginPath();
        ctx.arc(positionX, positionY, 20, 0, Math.PI * 2, true);
        ctx.fill();

        ctx.restore();

        saveInHistory();
    };
```

### Store changes in history

Create another function that uses the history context to store changes, so that users can undo their edits:

```js
    const saveInHistory = () => {
        const newImage = new Image();

        newImage.onload = () => {
            dispatchImageHistoryAction({ type: 'ADD_TO_HISTORY', image: newImage, additionalData });
        };

        newImage.src = canvas.current.toDataURL();
    };
```

Complete component code

```js
import React, { useContext } from 'react';
import PropTypes from 'prop-types';

import {
    CanvasContext,
    ImageHistoryContext,
    AdditionalDataContext,
} from '../../vendor/ibexa/image-editor/src/bundle/ui-dev/src/modules/image-editor/image.editor.modules';

const { ibexa } = window;

const IDENTIFIER = 'dot';

const Dot = () => {
    const [canvas, setCanvas] = useContext(CanvasContext);
    const [imageHistory, dispatchImageHistoryAction] = useContext(ImageHistoryContext);
    const [additionalData, setAdditionalData] = useContext(AdditionalDataContext);
    const saveInHistory = () => {
        const newImage = new Image();

        newImage.onload = () => {
            dispatchImageHistoryAction({ type: 'ADD_TO_HISTORY', image: newImage, additionalData });
        };

        newImage.src = canvas.current.toDataURL();
    };
    const drawDot = () => {
        const ctx = canvas.current.getContext('2d');
        const positionX = Math.random() * canvas.current.width;
        const positionY = Math.random() * canvas.current.height;

        ctx.save();

        ctx.fillStyle = '#ae1164';

        ctx.beginPath();
        ctx.arc(positionX, positionY, 20, 0, Math.PI * 2, true);
        ctx.fill();

        ctx.restore();

        saveInHistory();
    };

    return (
        <div className="c-image-editor-dot">
            <button type="button" onClick={drawDot} className="btn btn-secondary">
                Add dot
            </button>
        </div>
    );
};

Dot.propTypes = {};

Dot.defaultProps = {};

export default Dot;

ibexa.addConfig(
    'imageEditor.actions.dot',
    {
        label: 'Dot',
        component: Dot,
        icon: ibexa.helpers.icon.getIconPath('form-radio'),
        identifier: IDENTIFIER,
    },
    true,
);
```

Clear the cache and rebuild assets with the following commands:

```bash
php bin/console cache:clear
yarn encore dev
```

At this point you should be able to draw a random dot by clicking a button in the Image Editor's UI.
