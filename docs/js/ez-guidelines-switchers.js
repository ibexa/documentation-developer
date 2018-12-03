(function(global, doc) {
    const checkboxIcons = doc.querySelectorAll(".ez-checkbox-icon");
    const toggleChecked = event => {
        event.currentTarget.classList.toggle("is-checked");
        event.preventDefault();
    };

    checkboxIcons.forEach(element => element.addEventListener("click", toggleChecked, false));

    doc.querySelectorAll(".ez-preview-switcher").forEach(element => {
        const CLASS_PREVIEW_ACTION_SELECTED = 'ez-preview-switcher__action--selected';
        const previewActions = [...element.querySelectorAll('.ez-preview-switcher__action')];
        previewActions.forEach(element => element.addEventListener("click", event => {
            previewActions.forEach((action) => action.classList.remove(CLASS_PREVIEW_ACTION_SELECTED));
            event.currentTarget.classList.add(CLASS_PREVIEW_ACTION_SELECTED);
        }, false));
    }, false);
})(window, window.document);
