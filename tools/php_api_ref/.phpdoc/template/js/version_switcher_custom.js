(function(global, doc) {
    const initializeSwitcher = (addedNode) => {
        if (!addedNode || addedNode.tagName !== 'READTHEDOCS-FLYOUT' || !addedNode.shadowRoot) {
            return;
        }

        const switcherWrapper = document.querySelector('.md-header__switcher .version-switcher');
        const switcherList = switcherWrapper.querySelector('.switcher__list');
        const currentVersionNode = switcherWrapper.querySelector('.rst-current-version');
        const versionsList = addedNode.shadowRoot.querySelector('dl.versions');
        const version = addedNode.querySelector('.switcher__list dl.versions dd strong a')?.innerText;

        versionsList.append(...Array.from(versionsList.childNodes).reverse());
        switcherList.appendChild(versionsList);
        currentVersionNode.innerText = version ?? 'Change version';
    }
    const observer = new MutationObserver((mutationList) => {
        mutationList.forEach((mutation) => {
            mutation.addedNodes.forEach((addedNode) => initializeSwitcher(addedNode));
        });
    });
    const injectedNode = doc.getElementsByTagName('readthedocs-flyout');

    observer.observe(doc.body, {
        childList: true,
    });

    initializeSwitcher(injectedNode[0]);
})(window, window.document);
