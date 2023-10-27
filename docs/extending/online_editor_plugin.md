# Create custom Online Editor plugin

There are different ways to [extend the Online Editor](extending_online_editor.md).
Here you can learn how to add your own plugin to the Online Editor.

Follow the procedure below to create a plugin which inserts the current date into 
a RichText Field.

!!! note

    Online Editor is based on AlloyEditor, which in turn uses CKEditor.
    As a result, you create custom Online Editor plugins in a way similar to 
    [the way you do it in CKEditor](https://ckeditor.com/docs/ckeditor4/latest/guide/plugin_sdk_sample.html).

First, create the plugin file in `assets/js/online_editor/plugins/date.js`.
The following code implements an `InsertDate` method and attaches it to the editor:

``` js
[[= include_file('code_samples/back_office/online_editor/assets/js/online_editor/plugins/date.js') =]]
```

Then, modify the Online Editor toolbar by adding a button that inserts the date.
Create a file for the button in `assets/js/online_editor/buttons/date.js`:

``` js
[[= include_file('code_samples/back_office/online_editor/assets/js/online_editor/buttons/date.js') =]]
```

Next, enable the plugin and the button.
Add the following code in the `webpack.config.js` file, under 
`// Put your config here`.
This way, [[= product_name =]] loads the plugin and button files when loading 
the Online Editor:

``` js
eZConfigManager.add({
    eZConfig,
    entryName: 'ezplatform-richtext-onlineeditor-js',
    newItems: [
        path.resolve(__dirname, 'assets/js/online_editor/buttons/date.js'),
        path.resolve(__dirname, 'assets/js/online_editor/plugins/date.js'),
    ]
});
```

Finally, add the plugin and its button to your [[= product_name =]] configuration:

``` yaml
[[= include_file('code_samples/back_office/online_editor/config/packages/custom_plugin.yaml') =]]
```

You have successfully created a custom Online Editor plugin.

You can now run the `yarn encore dev` command to regenerate the assets, and create 
a Content item with a RichText Field.
The new button appears in the toolbar when editing a Paragraph element and inserts 
the current date when clicked:

![Custom plugin inserting the current date into RichText](img/oe_custom_plugin.png)
