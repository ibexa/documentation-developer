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
