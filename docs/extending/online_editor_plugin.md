# Creating Online Editor plugin

You can add your own plugins to the Online Editor.

Online Editor is based on AlloyEditor, which in turn uses CKEditor,
so creating a custom plugin is similar to [the way you do it in CKEditor](https://ckeditor.com/docs/ckeditor4/latest/guide/plugin_sdk_sample.html).

In this example you will create a plugin which inserts the current date into a RichText Field.

## Creating the plugin

First, create the plugin file in `assets/js/alloyeditor/plugins/date.js`:

``` js
(function (global) {
    if (CKEDITOR.plugins.get('date')) {
        return;
    }

    const InsertDate = {
        exec: function (editor) {
            const now = new Date();
            editor.insertHtml( now.toString() );
        },
    };
    
    global.CKEDITOR.plugins.add('date', {
        init: (editor) => editor.addCommand('InsertDate', InsertDate),
    });
})(window);
```

This file implements an `InsertDate` command and attaches it to the editor.

## Creating a button

Next, you need to add a button for inserting the date to the Online Editor toolbar.

Create a file for the button in `assets/js/alloyeditor/buttons/date.js`:

``` js
import PropTypes from 'prop-types';
import AlloyEditor from 'alloyeditor';
import EzButton
    from '../../../../vendor/ezsystems/ezplatform-richtext/src/bundle/Resources/public/js/OnlineEditor/buttons/base/ez-button.js';

export default class BtnDate extends EzButton {
    static get key() {
        return 'date';
    }

    insertDate(data) {
        this.execCommand(data);
    }

    render() {
        const title = 'Date';

        return (
            <button
                className="ae-button ez-btn-ae ez-btn-ae--date"
                onClick={this.insertDate.bind(this)}
                tabIndex={this.props.tabIndex}
                title={title}>
                <svg className="ez-icon ez-btn-ae__icon">
                    <use xlinkHref="/bundles/ezplatformadminui/img/ez-icons.svg#date" />
                </svg>
            </button>
        );
    }
}

AlloyEditor.Buttons[BtnDate.key] = AlloyEditor.BtnDate = BtnDate;
eZ.addConfig('ezAlloyEditor.BtnDate', BtnDate);

BtnDate.propTypes = {
    command: PropTypes.string,
};

BtnDate.defaultProps = {
    command: 'InsertDate',
};
```

## Enabling the plugin

Now you need to enable the plugin and the button.

Add the following code to `webpack.config.js` under `// Put your config here`:

``` js
eZConfigManager.add({
    eZConfig,
    entryName: 'ezplatform-richtext-onlineeditor-js',
    newItems: [
        path.resolve(__dirname, 'assets/js/alloyeditor/buttons/date.js'),
        path.resolve(__dirname, 'assets/js/alloyeditor/plugins/date.js'),
    ]
});
```

This file loads the plugin and button files when loading Online Editor.

## Adding the plugin to configuration

Finally, add the plugin and its button to your [[= product_name =]] configuration:

``` yaml
ezplatform:
    system:
        admin_group:
            fieldtypes:
                ezrichtext:
                    toolbars:
                        paragraph:
                            buttons:
                                date:
                                    priority: 0
ezrichtext:
    alloy_editor:
        extra_plugins: [date]
```

At this point you can run `yarn encore dev` and create a Content item with a RichText Field.
The new button appears in the toolbar when editing a Paragraph element and inserts the current date when clicked:

![Custom plugin inserting the current date into RichText](img/oe_custom_plugin.png)
