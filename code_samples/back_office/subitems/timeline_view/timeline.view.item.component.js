import React from 'react';
import PropTypes from 'prop-types';
import Icon from '@ibexa-admin-ui-modules/common/icon/icon';

const { ibexa } = window;

const TimelineViewItemComponent = ({ item, generateLink }) => {
    const { content } = item;
    const contentTypeIdentifier = content._info.contentType.identifier;
    const contentTypeIconUrl = ibexa.helpers.contentType.getContentTypeIconUrl(contentTypeIdentifier);
    const time = new Date(content._info.modificationDate.timestamp * 1000).toLocaleTimeString();

    return (
        <a className="app-timeline-view-item" href={generateLink(item.id, content._info.id)}>
            <div className="app-timeline-view-item__time">{time}</div>
            <div className="app-timeline-view-item__content">
                <div className="app-timeline-view-item__info">
                    <div className="app-timeline-view-item__name">{content._name}</div>
                    <div className="app-timeline-view-item__type">
                        <Icon customPath={contentTypeIconUrl} extraClasses="ibexa-icon--small" />
                        <span className="app-timeline-view-item__type-name">{content._info.contentType.name}</span>
                    </div>
                </div>
            </div>
        </a>
    );
};

TimelineViewItemComponent.propTypes = {
    item: PropTypes.object.isRequired,
    generateLink: PropTypes.func.isRequired,
};

export default TimelineViewItemComponent;
