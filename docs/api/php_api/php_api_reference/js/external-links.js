$(() => {
    $('abbr').each((index, element) => {
        let $this = $(element);
        let fqcn = $this.attr('title');
        if (fqcn.startsWith('\\Symfony\\') && 'a' != $this.parent().prop('tagName')) {
            let href = 'https://github.com/symfony/symfony/blob/' + symfonyVersion + '/src' + fqcn.replaceAll('\\', '/') + '.php';
            $this.wrap('<a href="' + href + '" class="external">');
        }
    });
})
