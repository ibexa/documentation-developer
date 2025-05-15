import TimelineViewComponent from './timeline.view.component.js';
import { registerView } from '@ibexa-admin-ui-modules/sub-items/services/view.registry';

// Use the existing constants to replace a view
import { VIEW_MODE_GRID, VIEW_MODE_TABLE } from '@ibexa-admin-ui-modules/sub-items/constants';

registerView('timeline', {
    component: TimelineViewComponent,
    iconName: 'timeline',
    label: 'Timeline view',
});
