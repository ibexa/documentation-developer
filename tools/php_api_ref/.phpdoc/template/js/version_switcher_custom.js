(function(global, doc) {
    let interval = null;
    const initializeSwitcher = () => {
        const injectedNode = doc.getElementsByTagName('readthedocs-flyout')[0];

        if (!injectedNode || !injectedNode.shadowRoot) {
            return;
        }

        const switcherWrapper = document.querySelector('.md-header__switcher .version-switcher');
        const switcherList = switcherWrapper.querySelector('.switcher__list');
        const currentVersionNode = switcherWrapper.querySelector('.rst-current-version');
        const versionsList = injectedNode.shadowRoot.querySelector('dl.versions');
        const version = injectedNode.querySelector('.switcher__list dl.versions dd strong a')?.innerText;

        versionsList.append(...Array.from(versionsList.childNodes).reverse());
        switcherList.appendChild(versionsList);
        currentVersionNode.innerText = version ?? 'Change version';

        clearInterval(interval);
    }
    
    interval = setInterval(initializeSwitcher, 100);
})(window, window.document);
