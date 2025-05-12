import TimelineViewComponent from './timeline.view.component.js';
import { registerView } from '@ibexa-admin-ui-modules/sub-items/services/view.registry';

registerView('timeline', {
    component: TimelineViewComponent,
    iconName: 'timeline',
    label: 'Timeline view',
});
