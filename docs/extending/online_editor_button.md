# Create custom Online Editor button

There are different ways to [extend the Online Editor](extending_online_editor.md).
Here you can learn how to add your own buttons.

Follow the procedure below to create a button that inserts an `<hr>` element into 
a RichText Field.

First, create the button file in `assets/js/online_editor/buttons/hr.js`:

``` js
[[= include_file('code_samples/back_office/online_editor/assets/js/online_editor/buttons/hr.js') =]]
```

Then, enable the button.
Add the following code in the `webpack.config.js` file, under 
`// Put your config here`:

``` js
eZConfigManager.add({
    eZConfig,
    entryName: 'ezplatform-richtext-onlineeditor-js',
    newItems: [
        path.resolve(__dirname, 'assets/js/online_editor/buttons/hr.js'),
    ]
});
```

Finally, add the button to your [[= product_name =]] configuration:

``` yaml
[[= include_file('code_samples/back_office/online_editor/config/packages/custom_buttons.yaml', 0, 6) =]] [[= include_file('code_samples/back_office/online_editor/config/packages/custom_buttons.yaml', 12, 16) =]]
```

You have successfully created a custom Online Editor button.

You can now run the `yarn encore dev` command to regenerate the assets, and create 
a Content item with a RichText Field.
The new button appears in the Element toolbar and inserts an `<hr>` element when clicked:

![Custom button inserting an `<hr>` into RichText](img/oe_custom_button.png)
