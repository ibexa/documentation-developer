import React, { useContext } from 'react';
import PropTypes from 'prop-types';

const IDENTIFIER = 'dot';

const Dot = () => {
    return (
        <div className="c-image-editor-dot">
            <button type="button" className="btn btn-secondary">
                Add dot
            </button>
        </div>
    );
};

Dot.propTypes = {};

Dot.defaultProps = {};

export default Dot;

window.eZ.addConfig(
    'imageEditor.actions.dot', // The ID ("dot") must match the one from the configuration yaml file
    {
        label: 'Dot',
        component: Dot,
        icon: window.eZ.helpers.icon.getIconPath('radio-button'), // Path to an icon that will be displayed in the UI
        identifier: IDENTIFIER, // The identifier must match the one from the configuration yaml file
    },
    true
);
