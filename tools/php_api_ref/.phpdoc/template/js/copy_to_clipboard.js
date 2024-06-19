(function(global, doc, navigator) {
    const copyBtns = doc.querySelectorAll('.copy-to-clipboard');
    const copiedPopover = doc.querySelector('.popover--copied');
    const copiedPopoverOffset = copiedPopover.offsetWidth / 2;
    const POPOVER_HIDE_TIMEOUT = 2000;
    let popoverTimeout = null;

    copyBtns.forEach((copyBtn) => {
        copyBtn.addEventListener('click', (event) => {
            const { offsetLeft, offsetTop, offsetWidth, offsetHeight, dataset } = $(event.target).closest('.copy-to-clipboard')[0];
            const popoverX = offsetLeft + offsetWidth / 2 - copiedPopoverOffset;
            const popoverY = offsetTop + offsetHeight + 8;
            const hidePopover = () => {
                copiedPopover.style.opacity = 0;

                clearTimeout(popoverTimeout);
                copiedPopover.classList.remove('popover--visible');
                copiedPopover.removeEventListener('transitionend', hidePopover, false);
            }

            hidePopover();

            copiedPopover.style.left = `${popoverX}px`;
            copiedPopover.style.top = `${popoverY}px`;
            copiedPopover.style.opacity = 1;

            copiedPopover.classList.add('popover--visible');

            navigator.clipboard.writeText(dataset.copyValue);

            popoverTimeout = setTimeout(() => {
                copiedPopover.style.opacity = 0;

                copiedPopover.addEventListener('transitionend', hidePopover, false);
            }, POPOVER_HIDE_TIMEOUT);
        });
    });
})(window, window.document, window.navigator);
