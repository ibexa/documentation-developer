const ibexaConfigManager = require('@ibexa/frontend-config/webpack-config/manager');
const getIbexaConfig = require('@ibexa/frontend-config/webpack-config/ibexa');
const ibexaConfig = getIbexaConfig();

ibexaConfigManager.add({
    ibexaConfig,
    entryName: 'ibexa-admin-ui-layout-js',
    newItems: [path.resolve(__dirname, './assets/js/admin.search.autocomplete.product.js')],
});

module.exports = [ibexaConfig, ...customConfigs, projectConfig];
