(function(global, doc) {
    let interval = null;
    const initializeSwitcher = () => {
        const injectedNode = doc.getElementsByTagName('readthedocs-flyout')[0];

        if (!injectedNode || !injectedNode.shadowRoot) {
            return;
        }

        const switcherWrapper = document.querySelector('.md-header__switcher .version-switcher');
        const switcherList = switcherWrapper.querySelector('.switcher__list');
        const versionsList = injectedNode.shadowRoot.querySelector('dl.versions');
        const version = injectedNode.querySelector('.switcher__list dl.versions dd strong a')?.innerText;

        if (!versionsList) {
            return;
        }

        versionsList.append(...Array.from(versionsList.childNodes).reverse());
        switcherList.appendChild(versionsList);
        switcherList.insertAdjacentHTML('beforebegin', `
            <div class="rst-versions switcher__selected-item" data-toggle="rst-versions" role="note" aria-label="versions">
                <div class="rst-current-version switcher__label" data-toggle="rst-current-version">
                    ${version ?? 'Change version'}
                </div>
            </div>
        `);

        clearInterval(interval);

        doc.dispatchEvent(new CustomEvent('switcher-added', { detail: { switcher: switcherWrapper }}));
    }
    
    interval = setInterval(initializeSwitcher, 100);
})(window, window.document);
