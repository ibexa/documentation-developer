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

            //replace url in version switcher
            var resourceUrl = document.location.href.replace(
                $('.rst-other-versions .injected strong dd a').attr('href'),
                ''
            );

            $('.rst-other-versions .injected dd a').each( function() {
                $(this).attr('href', $(this).attr('href') + resourceUrl);
            });
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

    if (!/^\d+\.\d+$/.test(branchName) && branchName !== 'latest') {
        branchName = 'master';
    }

    docsearch({
        apiKey: 'bfb5bd7cad971d31ef8be599174334f3',
        indexName: 'ezplatform',
        inputSelector: '#search_input',
        algoliaOptions: {
            'facetFilters': ["lang:en", "version:" + branchName],
            'hitsPerPage': 10
        },
        debug: false
    });

    $(document).on("keypress", "#search_input", function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
        }
    });

    $("#search_input, label.md-search__icon").on("click", function() {
        var toggle = document.querySelector("[data-md-toggle=search]");
        toggle.checked = true;
    });
});
