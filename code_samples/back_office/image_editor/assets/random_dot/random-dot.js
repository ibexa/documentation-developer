import React, { useContext } from 'react';
import PropTypes from 'prop-types';

import {
    CanvasContext,
    ImageHistoryContext,
    AdditionalDataContext,
} from '../../vendor/ibexa/image-editor/src/bundle/ui-dev/src/modules/image-editor/image.editor.modules';

const { ibexa } = window;

const IDENTIFIER = 'dot';

const Dot = () => {
    const [canvas, setCanvas] = useContext(CanvasContext);
    const [imageHistory, dispatchImageHistoryAction] = useContext(ImageHistoryContext);
    const [additionalData, setAdditionalData] = useContext(AdditionalDataContext);
    const saveInHistory = () => {
        const newImage = new Image();

        newImage.onload = () => {
            dispatchImageHistoryAction({ type: 'ADD_TO_HISTORY', image: newImage, additionalData });
        };

        newImage.src = canvas.current.toDataURL();
    };
    const drawDot = () => {
        const ctx = canvas.current.getContext('2d');
        const positionX = Math.random() * canvas.current.width;
        const positionY = Math.random() * canvas.current.height;

        ctx.save();

        ctx.fillStyle = '#000000';

        ctx.beginPath();
        ctx.arc(positionX, positionY, 20, 0, Math.PI * 2, true);
        ctx.fill();

        ctx.restore();

        saveInHistory();
    };

    return (
        <div className="c-image-editor-dot">
            <button type="button" onClick={drawDot} className="btn btn-secondary">
                Add dot
            </button>
        </div>
    );
};

Dot.propTypes = {};

Dot.defaultProps = {};

export default Dot;

ibexa.addConfig(
    'imageEditor.actions.dot',
    {
        label: 'Dot',
        component: Dot,
        icon: ibexa.helpers.icon.getIconPath('radio-button'),
        identifier: IDENTIFIER,
    },
    true
);
