const containerNode = document.querySelector('#sub-items-container');

ReactDOM.render(
    React.createElement(ibexa.modules.SubItems, {
        parentLocationId: { Number },
        restInfo: {
            token: { String },
            siteaccess: { String },
        },
    }),
    containerNode,
);
