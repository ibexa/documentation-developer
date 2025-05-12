import React from 'react';
import PropTypes from 'prop-types';
import TimelineViewItemComponent from './timeline.view.item.component';

const TimelineViewComponent = ({ items, generateLink }) => {
    const groupByDate = (items) => {
        return items.reduce((groups, item) => {
            const date = new Date(item.content._info.modificationDate.timestamp * 1000);
            const dateKey = date.toISOString().split('T')[0];

            if (!groups[dateKey]) {
                groups[dateKey] = [];
            }

            groups[dateKey].push(item);
            return groups;
        }, {});
    };

    const groupedItems = groupByDate(items);

    return (
        <div className="app-timeline-view">
            {Object.entries(groupedItems).map(([date, dateItems]) => (
                <div key={date} className="app-timeline-view__group">
                    <div className="app-timeline-view__date">
                        <div className="app-timeline-view__date-marker" />
                        <h3>{new Date(date).toLocaleDateString()}</h3>
                    </div>
                    <div className="app-timeline-view__items">
                        {dateItems.map((item) => (
                            <TimelineViewItemComponent key={item.id} item={item} generateLink={generateLink} />
                        ))}
                    </div>
                </div>
            ))}
        </div>
    );
};

TimelineViewComponent.propTypes = {
    items: PropTypes.array.isRequired,
    generateLink: PropTypes.func.isRequired,
};

export default TimelineViewComponent;
