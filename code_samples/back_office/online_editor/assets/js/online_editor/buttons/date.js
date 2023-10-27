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
