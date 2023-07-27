import React from 'react';
import { createRoot } from 'react-dom/client';

(function (global, doc) {
    const reactComponents = {};
    const cache = {};
    const context = require.context(
        '../page-builder/react/blocks',
        true,
        /\.js$/
    );

    if (!context) {
        return;
    }

    context.keys().forEach((key) => (cache[key] = context(key)));

    for (const key in cache) {
        const components = cache[key].default;

        for (const component in components) {
            reactComponents[component] = components[component];
        }
    }

    const reactBlocks = [...doc.querySelectorAll('.ibexa-react-block')];

    reactBlocks.forEach((reactBlock) => {
        const { componentName, props: componentProps } = reactBlock.dataset;
        const props = JSON.parse(componentProps).attributes;
        const ReactComponent = reactComponents[componentName];
        const reactBlockRoot = createRoot(reactBlock);

        reactBlockRoot.render(<ReactComponent {...props} />);
    });

    window.getReactComponent = (name) => {
        return reactComponents[name];
    };

    window.renderReactComponent = (container, Component, props) => {
        const reactBlockRoot = createRoot(container);

        reactBlockRoot.render(<Component {...props} />);
    };
})(window, document);
