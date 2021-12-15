import PropTypes from 'prop-types';
import AlloyEditor from 'alloyeditor';
import IbexaButton
    from '../../../../vendor/ezsystems/ezplatform-richtext/src/bundle/Resources/public/js/OnlineEditor/buttons/base/ibexa-button.js';

export default class IbexaBtnHr extends IbexaButton {
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
                className="ae-button ibexa-btn-ae ibexa-btn-ae--date"
                onClick={this.addHr.bind(this)}
                tabIndex={this.props.tabIndex}
                title={title}>
                <svg className="ibexa-icon ibexa-btn-ae__icon">
                    <use xlinkHref="/bundles/ezplatformadminui/img/ez-icons.svg#tag" />
                </svg>
            </button>
    );
    }
}

AlloyEditor.Buttons[IbexaBtnHr.key] = AlloyEditor.IbexaBtnHr = IbexaBtnHr;

const ibexa = (window.ibexa = window.ibexa || {});

ibexa.ezAlloyEditor = ibexa.ezAlloyEditor || {};
ibexa.ezAlloyEditor.IbexaBtnHr = IbexaBtnHr;

IbexaBtnHr.propTypes = {
    command: PropTypes.string,
    modifiesSelection: PropTypes.bool,
};

IbexaBtnHr.defaultProps = {
    command: 'ibexaAddContent',
    modifiesSelection: true,
};
