$(document).ready(function () {
    $(document).on("click", "[data-toggle='rst-current-version']", function() {
        $('.rst-other-versions').toggle();
    });

    // remove elements, leave only 'versions'
    var update = setInterval(function() {
        if ($('.rst-other-versions .injected').length) {
            clearInterval(update);
            $('.rst-current-version span:first').html(' Change version');
            $('.rst-other-versions .injected').html($('.rst-other-versions .injected dl:first').clone());
        }
    }, 300);

    $('img').each(function() {
        if ($(this).attr('title')) {
            $(this).wrap( "<figure></figure>" );
            $(this).after( "<figcaption>" + $(this).attr('title') + "</figcaption>" );
        }
    });

    $('.md-content a:not(.md-icon):not(.md-source)').filter(function() {
        return this.hostname && this.hostname !== location.hostname;
    }).addClass("external");

    // replace edit url
    var branchName = 'master',
        branchNameRegexp = /\/en\/([a-z0-9-_.]*)\//g.exec(document.location.href);

    if (branchNameRegexp !== null && branchNameRegexp.hasOwnProperty(1) && branchNameRegexp[1].length) {
        branchName = branchNameRegexp[1];
    }

    $('.md-content a.md-icon').each(function() {
        $(this).attr('href', $(this).attr('href').replace('master/docs/', branchName + '/docs/'));
    });
});
