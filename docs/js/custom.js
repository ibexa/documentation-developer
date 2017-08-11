$(document).ready(function () {
    $(document).on("click", "[data-toggle='rst-current-version']", function() {
        $('.rst-other-versions').toggle();
    });
});
