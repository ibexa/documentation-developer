# Creating Online Editor button

You can add your own buttons to the Online Editor.

In this example you will create a button which inserts an `<hr>` element into a RichText Field.

## Creating the button

First, create the button file in `assets/js/alloyeditor/plugins/hr.js`:

``` js
import PropTypes from 'prop-types';
import AlloyEditor from 'alloyeditor';
import EzButton
    from '../../../../vendor/ezsystems/ezplatform-richtext/src/bundle/Resources/public/js/OnlineEditor/buttons/base/ez-button.js';

export default class EzBtnHr extends EzButton {
    static get key() {
        return 'hr';
    }

    addHr() {
        this.execCommand({
            tagName: 'hr',
        });
    }

    render() {
        const title = "Hr";
        return (
            <button
                className="ae-button ez-btn-ae ez-btn-ae--date"
                onClick={this.addHr.bind(this)}
                tabIndex={this.props.tabIndex}
                title={title}>
                <svg className="ez-icon ez-btn-ae__icon">
                    <use xlinkHref="/bundles/ezplatformadminui/img/ez-icons.svg#tag" />
                </svg>
            </button>
    );
    }
}

AlloyEditor.Buttons[EzBtnHr.key] = AlloyEditor.EzBtnHr = EzBtnHr;

const eZ = (window.eZ = window.eZ || {});

eZ.ezAlloyEditor = eZ.ezAlloyEditor || {};
eZ.ezAlloyEditor.ezBtnHr = EzBtnHr;

EzBtnHr.propTypes = {
    command: PropTypes.string,
    modifiesSelection: PropTypes.bool,
};

EzBtnHr.defaultProps = {
    command: 'eZAddContent',
    modifiesSelection: true,
};
```

## Enabling the button

Now you need to enable the button.

Add the following code to `webpack.config.js` under `// Put your config here`:

``` js
eZConfigManager.add({
    eZConfig,
    entryName: 'ezplatform-richtext-onlineeditor-js',
    newItems: [
        path.resolve(__dirname, 'assets/js/alloyeditor/buttons/hr.js'),
    ]
});
```

## Adding the button to configuration

Finally, add the button to your [[= product_name =]] configuration:

``` yaml
ezplatform:
    system:
        admin_group:
            fieldtypes:
                ezrichtext:
                    toolbars:
                        ezadd:
                            buttons:
                                hr:
                                    priority: 50
```

At this point you can run `yarn encore dev` and create a Content item with a RichText Field.
The new button appears in the Element toolbar and inserts an `<hr>` element when clicked:

![Custom button inserting an `<hr>` into RichText](img/oe_custom_button.png)
