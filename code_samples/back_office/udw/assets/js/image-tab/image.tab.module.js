import React, { useContext } from 'react';

import Tab from '@ibexa-admin-ui/src/bundle/ui-dev/src/modules/universal-discovery/components/tab/tab';
import ImagesList from './components/images.list';

const ImageTabModule = () => {
    return (
        <div className="m-image-tab">
            <Tab isContentOnTheFlyDisabled={true} isSortSwitcherDisabled={true} isViewSwitcherDisabled={true}>
                <ImagesList />
            </Tab>
        </div>
    );
};
ibexa.addConfig(
    'adminUiConfig.universalDiscoveryWidget.tabs',
    [
        {
            id: 'image',
            component: ImageTabModule,
            label: 'Image',
            icon: '/bundles/ibexaadminui/img/ibexa-icons.svg#image',
        },
    ],
    true
);

export default ImageTabModule;
