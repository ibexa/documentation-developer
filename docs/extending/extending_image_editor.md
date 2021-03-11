# Extending the Image Editor

With the Image Editor, users can do basic image modifications.
You can [modify the Image Editor's default appearance or behavior](../guide/image_editor.md).
You can also extend it by adding custom features.
For example, you can add a button that draws a dot at a random location on the image.
Learn how to do this by following the steps below.

## Create the JavaScript component file

In `assets/random_dot/`, create the `random-dot.js` file with the following code of the React component:

``` js
[[= include_file('code_samples/back_office/image_editor/assets/random_dot/random-dot-stem.js') =]]
```

The code does not perform any action, you add the action in the following steps.

## Add configuration

Depending on whether and where you [modified the default settings](../guide/image_editor.md#configuration), in `config/packages`, either modify the `ezplatform.yaml` file or create the `image_editor.yaml` by adding settings similar to the following example:

``` yaml
[[= include_file('code_samples/back_office/image_editor/config/packages/image_editor.yaml') =]]
```

## Add entry to the Webpack configuration

Once you create and configure the React component, you must add an entry to [the Webpack configuration](../tutorials/platform_beginner/3_customize_the_front_page.md#configuring-webpack).
In the root directory of your project, modify the `webpack.config.js` file by adding the following code:

``` js
[[= include_file('code_samples/back_office/image_editor/config/webpack.config.js', 39, 44) =]]
```
At this point you should be able to see a new button in the Image Editor's UI.

!!! tip

    Before you restart [[= product_name_exp =]], run `php bin/console cache:clear` and `yarn encore <dev|prod>` to regenerate the assets.

## Expand the React component

The button that you created above does not initiate any action yet.
You must modify the JavaScript component to add a function to the button.

#### Contexts

When you create a React-based extension of the Image Editor, you can use a number of contexts that have the following functions:

- CanvasContext - Stores a canvas that displays the image, on which you can modify the image
- ImageHistoryContext - Stores the image history used by the Undo/Redo feature
- AdditionalDataContext - Stores additional data that is attached to the image, for example, focal point coordinates
- TechnicalCanvasContext - Stores a canvas, which you can use to draw elements that help modify the image, for example, a crop area or a grid, without interrupting with the actual image

The last context is not used it in this example.

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
<summary>Complete controller code</summary>
``` js
[[= include_file('code_samples/back_office/image_editor/assets/random_dot/random-dot.js') =]]
```
</details>

At this point you should be able to draw a random dot by clicking a button in the Image Editor's UI.
