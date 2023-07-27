const bundles = require('./var/encore/ibexa.config.js');
const ibexaConfigManager = require('./ibexa.webpack.config.manager.js');
const configManagers = require('./var/encore/ibexa.config.manager.js');
const configSetups = require('./var/encore/ibexa.config.setup.js');
const path = require('path');

module.exports = (Encore) => {
    Encore.setOutputPath('public/assets/ibexa/build')
        .setPublicPath('/assets/ibexa/build')
        .addExternals({
            react: 'React',
            'react-dom': 'ReactDOM',
            moment: 'moment',
            'popper.js': 'Popper',
            alloyeditor: 'AlloyEditor',
            'prop-types': 'PropTypes',
        })
        .enableSassLoader()
        .enableReactPreset()
        .enableSingleRuntimeChunk();

    configSetups.forEach((configSetupPath) => {
        const setupConfig = require(configSetupPath);

        setupConfig(Encore);
    });

    bundles.forEach((configPath) => {
        const addEntries = require(configPath);

        addEntries(Encore);
    });

    const ibexaConfig = Encore.getWebpackConfig();

    ibexaConfig.name = 'ibexa';

    ibexaConfig.module.rules[4].oneOf[1].use[1].options.url = false;
    ibexaConfig.module.rules[1].oneOf[1].use[1].options.url = false;

    configManagers.forEach((configManagerPath) => {
        const configManager = require(configManagerPath);

        configManager(ibexaConfig, ibexaConfigManager);
    });

    Encore.reset();

    return ibexaConfig;
};
