import PropTypes from 'prop-types';
import AlloyEditor from 'alloyeditor';
import IbexaButton
    from '../../../../vendor/ezsystems/ezplatform-richtext/src/bundle/Resources/public/js/OnlineEditor/buttons/base/ibexa-button.js';

export default class BtnDate extends IbexaButton {
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
                className="ae-button ibexa-btn-ae ibexa-btn-ae--date"
                onClick={this.insertDate.bind(this)}
                tabIndex={this.props.tabIndex}
                title={title}>
                <svg className="ibexa-icon ibexa-btn-ae__icon">
                    <use xlinkHref="/bundles/ibexaplatformicons/img/all-icons.svg#date" />
                </svg>
            </button>
        );
    }
}

AlloyEditor.Buttons[BtnDate.key] = AlloyEditor.BtnDate = BtnDate;
ibexa.addConfig('ezAlloyEditor.BtnDate', BtnDate);

BtnDate.propTypes = {
    command: PropTypes.string,
};

BtnDate.defaultProps = {
    command: 'InsertDate',
};
