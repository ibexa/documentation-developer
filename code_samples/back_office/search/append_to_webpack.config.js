
const ibexaConfigManager = require('./ibexa.webpack.config.manager.js');

ibexaConfigManager.add({
    ibexaConfig,
    entryName: 'ibexa-admin-ui-layout-js',
    newItems: [ path.resolve(__dirname, './assets/js/admin.search.autocomplete.product.js'), ],
});
