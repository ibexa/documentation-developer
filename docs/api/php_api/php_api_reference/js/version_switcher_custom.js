// (function(global, doc) {
//     const initializeSwitcher = (addedNode) => {
//         if (!addedNode?.classList?.contains('injected') || !addedNode?.querySelector('.rst-versions')) {
//             return;
//         }

//         const version = addedNode.querySelector('.rst-other-versions dd.rtd-current-item a').innerText;
//         const versionsList = addedNode.querySelector('.rst-other-versions dl').cloneNode(true);
//         const switcherWrapper = document.querySelector('.md-header__switcher .version-switcher');
//         const switcherList = switcherWrapper.querySelector('.switcher__list');
//         const currentVersionNode = switcherWrapper.querySelector('.rst-current-version');

//         currentVersionNode.innerText = version !== '' ? version : 'Change version';

//         switcherList.appendChild(versionsList);

//         const currentVersion = switcherWrapper.querySelector('.rst-other-versions dd.rtd-current-item a').href;
//         const resourceUrl = document.location.href.replace(currentVersion, '');
//         const versionsLinks = switcherList.querySelectorAll('a');

//         versionsLinks.forEach((versionLink) => {
//             versionLink.href += resourceUrl;
//         });
//     }
//     const observer = new MutationObserver((mutationList) => {
//         mutationList.forEach((mutation) => {
//             mutation.addedNodes.forEach((addedNode) => initializeSwitcher(addedNode));
//         });
//     });
//     const injectedNode = doc.querySelector('.injected');

//     observer.observe(doc.body, {
//         childList: true,
//     });
//     initializeSwitcher(injectedNode);
// })(window, window.document);
