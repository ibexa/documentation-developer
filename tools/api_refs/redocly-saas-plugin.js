// Redocly decorators adapting the dumped OpenAPI schema to SaaS, complementing the built-in ones configured in redocly.yaml.
module.exports = function saasPlugin() {
    return {
        id: 'saas',
        decorators: {
            oas3: {
                // Edition badges are meaningless on SaaS.
                'remove-badges': () => ({
                    Operation: {
                        leave(operation) {
                            delete operation['x-badges'];
                        },
                    },
                }),
                // Tags left without operations by filter-out would still be displayed as empty groups.
                'remove-unused-tags': () => {
                    const usedTags = new Set();

                    return {
                        Operation: {
                            leave(operation) {
                                (operation.tags || []).forEach((tag) => usedTags.add(tag));
                            },
                        },
                        Root: {
                            leave(root) {
                                if (root.tags) {
                                    root.tags = root.tags.filter((tag) => usedTags.has(tag.name));
                                }
                            },
                        },
                    };
                },
            },
        },
    };
};
