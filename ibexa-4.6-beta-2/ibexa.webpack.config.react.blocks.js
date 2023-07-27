const fs = require('fs');
const isReactBlockPathCreated = fs.existsSync(
    './assets/page-builder/react/blocks'
);

module.exports = {
    isReactBlockPathCreated,
};
