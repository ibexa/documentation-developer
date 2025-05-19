<?php

$usageFiles = call_user_func(function (array $a): array {
    asort($a);
    return $a;
}, (new Finder('./docs'))
    ->includeName('*.md')
    ->excludeWholeName('./docs/release_notes/*')//TMP
    ->excludeWholeName('./docs/snippets/*')//TMP
    ->find());

$resourceFiles = call_user_func(function (array $a): array {
    asort($a);
    return $a;
},
    // Images
    (new Finder('./docs'))
        ->includeName('*.png')
        ->includeName('*.jpg')
        ->excludeWholeName('./docs/release_notes/img/*')//TMP
        ->find(),
);

$exclusionTests = array_merge_recursive(UrlTester::getDefaultExclusionTests(), [
    'url' => [
        function (string $url, ?string $file = null): bool {
            // docs/index.md content is not Markdown but HTML with server URLs
            return 'docs/index.md' === $file && str_starts_with($url, 'docs/');
        },
        function (string $url, ?string $file = null): bool {
            // ibexa.co APIs needing authentication, namespaces, commercial aliases, etc.
            return str_starts_with($url, 'https://updates.ibexa.co') // 401
                || str_starts_with($url, 'https://flex.ibexa.co') // 404
                || str_starts_with($url, 'https://support.ibexa.co') // 302 → /login
                || str_starts_with($url, 'https://connect.ibexa.co') // 302 → https://ibexa.integromat.celonis.com/
                || str_starts_with($url, 'http://ibexa.co/namespaces/') // 301
                || str_starts_with($url, 'http://ibexa.co/xmlns/') // 301
                || str_starts_with($url, 'http://ez.no/namespaces/') //301
                || str_starts_with($url, 'https://api.cloud.ibexa.co') // 301, PLATFORMSH_CLI_API_URL
                //|| str_starts_with($url, 'https://admin.perso.ibexa.co/api/') // 400
                || str_starts_with($url, 'https://admin.perso.ibexa.co/') // 404
                || str_starts_with($url, 'https://event.perso.ibexa.co/api/') // 400
                || str_starts_with($url, 'https://event.perso.ibexa.co/ebl/') // 404
                || str_starts_with($url, 'https://import.perso.ibexa.co/api/') // 400
                || str_starts_with($url, 'https://reco.perso.ibexa.co') // 403
                ;
        },
        function (string $url, ?string $file = null): bool {
            // Third parties APIs, namespaces, etc.
            return str_starts_with($url, 'https://api.fastly.com') // 301 or 403
                || str_starts_with($url, 'https://unsplash.com') // 405
                || str_starts_with($url, 'http://docbook.org/ns/') // 301
                || str_starts_with($url, 'http://www.w3.org/1999/xlink') // 301 → https
                ;
        },
        function (string $url, ?string $file = null): bool {
            return (bool)preg_match('@(https?:)?//([a-z]+\.)?(localhost|127.0.0.1|123.456.789.0)(:[0-9]+)?(/.*|$)@', $url);
        },
        function (string $url, ?string $file = null): bool {
            // Fake, placeholders, local servers, etc.
            return str_contains($url, 'foobar.com')
                || str_contains($url, 'mydomain.com')
                || str_contains($url, '//my_site.com')
                || str_contains($url, '//address.of/')
                || str_contains($url, '//some/file/here')
                || str_contains($url, '//mydoc.pdf')
                || str_contains($url, 'var/ezdemo_site/')
                || str_contains($url, '//server_uri')
                || str_contains($url, '//FRA_server_uri')
                || str_contains($url, '//user:password@host')
                || str_contains($url, '//user:pass@localhost')
                || str_contains($url, '//elasticsearch:9200')
                || str_contains($url, '//varnish:80')
                || str_contains($url, '//my.varnish.server')
                ;
        },
        function (string $url, ?string $file = null): bool {
            return str_starts_with($url, '/assets/')
                || str_contains($url, '{{ asset(');
        },
        function (string $url, ?string $file = null): bool {
            return false !== strpos($url, 'javascript:');
        },
        function (string $url, ?string $file = null): bool {
            return str_contains($url, '{{ path(')
                //|| str_contains($url, '{{ ez_path(')
                || str_contains($url, '{{ ibexa_path(')
                || str_contains($url, '{{ ibexa_url(')
                //|| str_contains($url, "|e('html_attr')")
                || str_contains($url, '{{ image_uri }}')
                || str_contains($url, '{{ ibexa_checkout_step_path(')
                || str_contains($url, '{{ ibexa_checkout_step_url(')
                ;
        },
        function (string $url, ?string $file = null): bool {
            return str_ends_with($file, '/rest_api_authentication.md')
                && str_ends_with($url, 'web+ez:DELETE /content/locations/1/2');
        },
        function (string $url, ?string $file = null): bool {
            return str_ends_with($file, '/file_url_handling.md')
                && (str_contains($url, 'http://`') || str_contains($url, 'ftp://`'));
        },
    ],
    'location' => [
        function (string $url, string $location, ?string $file = null): bool {
            return str_starts_with($url, 'https://issues.ibexa.co/') && str_starts_with($location, 'https://issues.ibexa.co/login.jsp');
        },
        function (string $url, string $location, ?string $file = null): bool {
            return $url === $location && str_starts_with($url, 'https://twitter.com/');
        },
        function (string $url, string $location, ?string $file = null): bool {
            return str_starts_with($url, 'https://youtu.be/') && explode('/', $url)[3] . '&feature=youtu.be' === explode('?v=', $location)[1];
        },
        function (string $url, string $location, ?string $file = null): bool {
            return str_starts_with($url, 'https://www.facebook.com/') && str_starts_with($location, 'https://www.facebook.com/unsupportedbrowser');
        },
        function (string $url, string $location, ?string $file = null): bool {
            return 'https://www.json.org/' === $url && 'https://www.JSON.org/json-en.html' === $location;
        },
        function (string $url, string $location, ?string $file = null): bool {
            return $url === 'https://console.aws.amazon.com/iam/home#/users'
                && preg_match('@https://[a-z0-9-]+\.console\.aws\.amazon\.com/iam/home#/users@', $location);
        },

    ],
    'fragment' => [
        /*function (string $url, ?string $file = null): bool {
            return str_ends_with($file, '.md') && (
                    // ## Commerce [[% include 'snippets/commerce_badge.md' %]]
                    str_ends_with($url, '/permission_use_cases.md#commerce')
                    // ### Ensure proper Captcha behavior [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]
                    || str_ends_with($url, '/reverse_proxy.md#ensure-proper-captcha-behavior')
                );
        },*/
        function (string $url, ?string $file = null): bool {
            return str_starts_with($url, 'https://classic.yarnpkg.com/en/docs/')
                || str_starts_with($url, 'https://ddev.readthedocs.io/');
        },
        function (string $url, ?string $file = null): bool {
            return $url == 'https://www.paypal.com/bizsignup/#/singlePageSignup';
        }
    ],
]);

$curlUsageTests = [
    function (string $url, ?string $file = null): bool {
        return str_starts_with($url, 'https://docs.aws.amazon.com/');
    },
];

$replacements = [//TODO Get from mkdocs.yml
    '[[= symfony_doc =]]' => 'https://symfony.com/doc/5.4',
    '[[= user_doc =]]' => 'https://doc.ibexa.co/projects/userguide/en/master',
];

$find = './docs/*/';
