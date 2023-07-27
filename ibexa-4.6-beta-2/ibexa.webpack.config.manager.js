const fs = require('fs');
/*
    We changed all entry names to ibexa-, but for BC change we left possibility to still use ezplatform-
    Note that using ezplatform- is deprecate and will be removed in version 5.0
*/
const ibexifyEntryName = (entryName) => {
    let ibexaEntryName = entryName;

    if (entryName.indexOf('ezplatform-') === 0) {
        console.warn('\x1b[43m%s\x1b[0m', 'Using ezplatform- is deprecated and will be removed in 5.0');

        ibexaEntryName = entryName.replace('ezplatform-', 'ibexa-');
    } else if (entryName.indexOf('ezcommerce-') === 0) {
        console.warn('\x1b[43m%s\x1b[0m', 'Using ezcommerce- is deprecated and will be removed in 5.0');

        ibexaEntryName = entryName.replace('ezcommerce-', 'ibexa-commerce-');
    }

    return ibexaEntryName;
}
const findItems = (ibexaConfig, entryName) => {
    const items = ibexaConfig.entry[entryName];

    if (!items) {
        throw new Error(`Couldn't find entry with name: "${entryName}". Please check if there is a typo in the name.`);
    }

    return items;
};
const replace = ({ ibexaConfig, eZConfig, entryName, itemToReplace, newItem }) => {
    const config = ibexaConfig ? ibexaConfig : eZConfig;
    const ibexaEntryName = ibexifyEntryName(entryName);
    const items = findItems(config, ibexaEntryName);
    const indexToReplace = items.indexOf(fs.realpathSync(itemToReplace));

    if (indexToReplace < 0) {
        throw new Error(`Couldn't find item "${itemToReplace}" in entry "${ibexaEntryName}". Please check if there is a typo in the name.`);
    }

    items[indexToReplace] = newItem;
};
const remove = ({ ibexaConfig, eZConfig, entryName, itemsToRemove }) => {
    const config = ibexaConfig ? ibexaConfig : eZConfig;
    const ibexaEntryName = ibexifyEntryName(entryName);
    const items = findItems(config, ibexaEntryName);
    const realPathItemsToRemove = itemsToRemove.map((item) => fs.realpathSync(item));

    config.entry[ibexaEntryName] = items.filter((item) => !realPathItemsToRemove.includes(item));
};
const add = ({ ibexaConfig, eZConfig, entryName, newItems }) => {
    const config = ibexaConfig ? ibexaConfig : eZConfig;

    const ibexaEntryName = ibexifyEntryName(entryName);
    const items = findItems(config, ibexaEntryName);

    config.entry[ibexaEntryName] = [...items, ...newItems];
};

module.exports = {
    replace,
    remove,
    add
};
