---
description: Add new functionalities to the image editor.
---

# Extend Image Editor

With the Image Editor, users can do basic image modifications.
You can configure the Image Editor's [default appearance or behavior](configure_image_editor.md).
You can also extend it by adding custom features.

The following example shows how to extend the Image Editor
by adding a button that draws a dot at a random location on the image.

## Create the JavaScript component file

In `assets/random_dot/`, create the `random-dot.js` file with the following code of the React component:

``` js
[[= include_file('code_samples/back_office/image_editor/assets/random_dot/random-dot-stem.js') =]]
```

The code does not perform any action yet, you add the action in the following steps.

## Add configuration

Depending on whether you [modified the default settings](configure_image_editor.md#configuration), and where you did it,
in `config/packages` either modify the `ibexa.yaml` file, or create an 
`image_editor.yaml` file by adding settings similar to the following example:

``` yaml
[[= include_file('code_samples/back_office/image_editor/config/packages/image_editor.yaml', 0, 9) =]][[= include_file('code_samples/back_office/image_editor/config/packages/image_editor.yaml', 36, 39) =]]
```

## Add entry to the Webpack configuration

Once you create and configure the React component, you must add an entry to [the Webpack configuration](3_customize_the_front_page.md#configuring-webpack).
In the root directory of your project, modify the `webpack.config.js` file by adding the following code:

``` js
[[= include_file('code_samples/back_office/image_editor/config/webpack.config.js', 41, 46) =]]
```
At this point you should be able to see a new button in the Image Editor's UI.

!!! tip

    Before you restart [[= product_name =]], run `php bin/console cache:clear` and `yarn encore <dev|prod>` to regenerate the assets.

## Expand the React component

The button that you created above does not initiate any action yet.
You must modify the JavaScript component to add a function to the button.

### Contexts

When you create a React-based extension of the Image Editor, you can use a number of contexts that have the following functions:

- CanvasContext - stores a canvas that displays the image, on which you can modify the image
- ImageHistoryContext - stores the image history used by the Undo/Redo feature
- AdditionalDataContext - stores additional data that is attached to the image, for example, focal point coordinates
- TechnicalCanvasContext - stores a canvas, which you can use to draw elements that help modify the image, for example, a crop area or a grid, without interrupting with the actual image

The last context is not used in this example.

### Draw a dot

Modify the `random-dot.js` file by creating a function that uses the canvas context to draw a random dot on the image:

``` js
[[= include_file('code_samples/back_office/image_editor/assets/random_dot/random-dot.js', 24, 41) =]]
```

### Store changes in history

Create another function that uses the history context to store changes, so that users can undo their edits:

``` js
[[= include_file('code_samples/back_office/image_editor/assets/random_dot/random-dot.js', 15, 24) =]]
```

<details class="tip">
<summary>Complete component code</summary>
``` js
[[= include_file('code_samples/back_office/image_editor/assets/random_dot/random-dot.js') =]]
```
</details>

At this point you should be able to draw a random dot by clicking a button in the Image Editor's UI.
