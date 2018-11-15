(function(global, doc) {
    const checkboxIcon = doc.querySelector(".ez-checkbox-icon");
    const toggleChecked = event =>
        event.currentTarget.classList.toggle(".is-checked");

    checkboxIcon.addEventListener("click", toggleChecked, false);
})(window, window.document);
