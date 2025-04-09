<?php declare(strict_types=1);

/**
 * URL to be tested.
 *
 * Store an internal or external URL,
 * optionally the text of the corresponding link,
 * optionally where it has been found (in which file at which line),
 * and offers to test/check the existence of URL's destination.
 */
class TestableUrl
{
    /** @var string */
    private $url;

    /** @var null|string */
    private $text;

    /** @var null|string */
    private $file;

    /** @var null|integer */
    private $line;

    /** @var null|array */
    private $replacements;

    /** @var null|bool|string */
    private $find;

    /** @var null|bool */
    private $external;

    /** @var null|string */
    private $transformedUrl;

    /** @var null|string */
    private $solvedUrl;

    /** @var bool */
    private $tested = false;

    /** @var null|string[] */
    private $headers;

    /** @var null|int */
    private $code;

    /** @var null|TestableUrl */
    private $location;

    /** @var null|bool */
    private $fragmentFound;

    private const EXTERNAL_PATTERN = '^(https?:)?//';
    private const PATTERN_DELIMITER = '@';
    public const DEFAULT_SCHEME = 'https';

    /**
     * Represent a URL, potentially extracted from a file, which can be tested.
     *
     * @param string $url The URL itself
     * @param string|null $text The text of the link to the URL
     * @param string|null $file The file in which the URL has been found
     * @param int|string|null $line The file line the URL has been found at
     * @param string[]|null $replacements Some replacements to execute on the URL before testing it, like variables to replace by their values
     * @param bool|string|null $find By default, URL is considered absolute or relative; If true, the URL will be considered partial and the target must be searched to solve the URL; If a string is given, this string will be used as a search prefix
     * @param bool $test Set to true to test the URL immediately at construction time
     */
    public function __construct(string $url, ?string $text = null, ?string $file = null, null|int|string $line = null, ?array $replacements = null, mixed $find = false, bool $test = false)
    {
        $this->url = $url;
        $this->text = $text;
        $this->file = $file;
        $this->line = (int)$line;
        $this->replacements = $replacements;
        $this->find = $find;
        if ($test) {
            $this->test();
        }
    }

    /**
     * Test/check the URL and fill its related properties (code, headers, etc.).
     *
     * @param bool $testLocations If it's a redirection (through a `location` header), test the redirect target
     * @param bool $testFragment If the eventual fragment/hash/anchor part should be tested
     * @param bool $cache Test again even if already tested
     * @return $this Returns itself for chain like $this->test()->getCode()
     */
    public function test(bool $testLocations = true, bool $testFragment = true, bool $useCurl = false, bool $cache = true): self
    {
        if (!$this->isTested() || !$cache) {
            $test = self::testUrl($this->getSolvedUrl(), $this->isExternal(), $testFragment, $useCurl);
            $this->headers = $test['headers'];
            $this->code = $test['code'];
            $this->location = null === $test['location'] ? null : new TestableUrl($test['location'], null, $this->getFile(), $this->getLine(), null, false, $testLocations);
            $this->fragmentFound = $test['fragment_found'];
            $this->tested = true;
        }

        return $this;
    }

    /**
     * Has the URL been tested/checked.
     *
     * @return bool
     */
    public function isTested(): bool
    {
        return $this->tested;
    }

    /**
     * Get the raw URL.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Execute URL transformations like replacements.
     */
    public function getTransformedUrl(): string
    {
        if (null === $this->transformedUrl) {
            if (is_array($this->replacements)) {
                $this->transformedUrl = str_replace(array_keys($this->replacements), array_values($this->replacements), $this->getUrl());
            } else {
                $this->transformedUrl = $this->getUrl();
            }
        }

        return $this->transformedUrl;
    }

    public static function getRelativePath($sourcePath, $targetPath): string
    {
        $sourcePathInfo = pathinfo($sourcePath);
        $targetPathInfo = pathinfo($targetPath);
        $sourceDir = '.' === $sourcePathInfo['dirname'] ? [] : explode('/', $sourcePathInfo['dirname']);
        $targetDir = '.' === $targetPathInfo['dirname'] ? [] : explode('/', $targetPathInfo['dirname']);
        while (!empty($sourceDir) && !empty($targetDir) && $sourceDir[0] === $targetDir[0]) {
            // Remove common path
            array_shift($sourceDir);
            array_shift($targetDir);
        }
        while (!empty($sourceDir)) {
            // Add descending directories `..`
            array_shift($sourceDir);
            array_unshift($targetDir, '..');
        }

        return (empty($targetDir) ? '' : implode('/', $targetDir) . '/') . $targetPathInfo['basename'];
    }

    public static function solveRelativePath(string $sourcePath, string $targetPath): string
    {
        if ('/' === $targetPath[0]) {
            if (preg_match('@^(?P<scheme>[^:]+:)?//(?P<host>[^/]+)@', $sourcePath, $matches)) {
                $targetPath = "{$matches['scheme']}//{$matches['host']}$targetPath";
            }
            return $targetPath;
        }

        $targetPath = preg_replace('@^\./@', '', $targetPath);

        if ('/' === substr($sourcePath, -1)) {
            $sourcePath .= 'tmp.tmp';
        }

        $sourcePathInfo = pathinfo($sourcePath);
        if ('.' !== $sourcePathInfo['dirname']) {
            // Add common path
            $targetPath = "{$sourcePathInfo['dirname']}/$targetPath";
            // Remove descending directories `..`
            $targetPathInfo = pathinfo($targetPath);
            $targetDir = explode('/', $targetPathInfo['dirname']);
            for ($i = 0; $i < count($targetDir); $i++) {
                if ($i > 0 && '..' === $targetDir[$i]) {
                    array_splice($targetDir, $i - 1, 2);
                    $i -= 2;
                }
            }
            $targetPath = (empty($targetDir) ? '' : implode('/', $targetDir) . '/') . $targetPathInfo['basename'];
        }

        return $targetPath;
    }

    /**
     * Get testable URI.
     *
     * If the file where the URL has been found is known,
     * solve relative path of internal URL
     * or add file URL to fragment.
     *
     * @return string
     */
    public function getSolvedUrl(): string
    {
        if (null === $this->solvedUrl) {
            $url = $this->getTransformedUrl();
            if ($this->isFragment()) {
                return $this->solvedUrl = $this->getFile() . $url;
            } else if (!$this->isExternal() && $this->hasFile() && !$this->find) {
                return self::solveRelativePath($this->getFile(), $url);
            } else if (!$this->isExternal() && $this->find) {
                $findPrefix = is_string($this->find) ? $this->find : '*/';
                $urlWithoutFragment = self::getUrlWithoutFragment($url);
                $candidates = (new Finder('.'))->includeWholeName("{$findPrefix}{$urlWithoutFragment}")->find();
                if (1 === count($candidates)) {
                    return $this->solvedUrl = $candidates[0] . ($this->hasFragment() ? '#' . $this->getFragment() : '');
                } else if ($this->hasFile()) {
                    return $this->solvedUrl = self::solveRelativePath($this->getFile(), $url);
                } else {
                    return $this->solvedUrl = $url;
                }
            } else {
                return $this->solvedUrl = $url;
            }
        }

        return $this->solvedUrl;
    }


    public function hasText(): bool
    {
        return null !== $this->text;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function __toString(): string
    {
        return $this->getUrl() . ($this->hasText() ? " “{$this->getText()}”" : '') . ($this->hasLocation() ? " → {$this->getLocation()->getUrl()}" : '');
    }

    public function hasFile(): bool
    {
        return !empty($this->file);
    }

    public function getFile(): ?string
    {
        return $this->file;
    }

    public function getLine(): ?int
    {
        return (int)$this->line;
    }

    public static function isExternalUrl(string $url): bool
    {
        return (bool)preg_match(self::PATTERN_DELIMITER . self::EXTERNAL_PATTERN . self::PATTERN_DELIMITER, $url);
    }

    public function isExternal(): bool
    {
        if (null === $this->external) {
            $this->external = self::isExternalUrl($this->getTransformedUrl());
        }

        return $this->external;
    }

    public function isInternal(): bool
    {
        return !$this->isExternal();
    }

    public const NOT_TESTABLE_CODE = 999;

    /**
     * Test/check a URL and return result data.
     *
     * If the URL is external, return the response HTTP headers (as an array), the HTTP status code as an integer, the eventual `location` HTTP header used for redirection, if there is a fragment to test, if that fragment has been found in the content available at the URL
     * If the URL is internal, return the code 200 if the target exists, 404 if not, if there is a fragment to test, if that fragment has been found in the content available at the URL
     * @param string $url The URL itself
     * @param bool|null $external If it's an external URL (`true`) or not (`false`), if `null`, the system try to guess it using {@see \TestableUrl::isExternalUrl()}
     * @param bool $testFragment If the eventual fragment/hash/anchor part should be tested
     * @param int $retryCount Number of retries on time out
     * @param int $retryDelay Delay in seconds before retrying
     * @param int $tryNumber Try number (first try is numbered 1)
     * @return array ['headers' => null|array, 'code' => int, 'location' => null|string, 'fragment_found' => null|bool]
     */
    public static function testUrl(string $url, ?bool $external = null, bool $testFragment = true, bool $useCurl = false, int $retryCount = 1, int $retryDelay = 300, int $tryNumber = 1): array
    {
        $headers = null;
        $code = self::NOT_TESTABLE_CODE;
        $location = null;
        $fragmentFound = null;

        if (null === $external) {
            $external = self::isExternalUrl($url);
        }

        if ($external) {
            $defaultScheme = self::DEFAULT_SCHEME;
            $headers = self::requestHeaders('//' === substr($url, 0, 2) ? "$defaultScheme:$url" : $url, $useCurl);
            if ($headers && count($headers) && strlen($headers[0])) {
                $firstLinePart = explode(' ', $headers[0]);
                $code = (int)$firstLinePart[1];
            }
        } else {
            $code = file_exists(parse_url($url, PHP_URL_PATH)/* No query (?) nor fragment (#) */) ? 200 : 404;
        }

        switch ($code) {
            case 200: // OK
                $contents = $external || $testFragment && self::isUrlWithFragment($url) ? self::requestBody(self::getUrlWithoutFragment($url), $useCurl) : '';
                if (false === $contents) {
                    //TODO
                    break;
                }
                $refreshTagPattern = '@<meta http-equiv="refresh" content="[^"]*; ?url=(?P<url>[^"]+)"@i';
                if ($external && preg_match($refreshTagPattern, $contents, $matches)) { // Soft redirect
                    $location = preg_match('@^https?://@', $matches['url']) ? $matches['url'] : self::solveRelativePath(self::getUrlWithoutFragment($url), $matches['url']);
                    if (self::isUrlWithFragment($url)) {
                        $location .= '#' . self::getUrlFragment($url);
                    }
                } elseif ($testFragment && self::isUrlWithFragment($url)) {
                    $fragment = self::getUrlFragment($url);
                    $fragmentFound = $contents && 1 === preg_match("@(id|name)=\"$fragment\"@", $contents);
                    if (!$fragmentFound && !self::isExternalUrl($url)) {
                        if ('md' === pathinfo(TestableUrl::getUrlWithoutFragment($url), PATHINFO_EXTENSION)) {
                            //TODO: MarkDown fragment search pattern should be a config.
                            //$pattern = '@^#+\W*' . str_replace('-', '\W+', $fragment) . '\W*$@mi';
                            $pattern = '@^#+\W*' . str_replace('-', '\W+', $fragment) . '\W*( \[\[% include \'.+_badge.md\' %\]\])*$@mi';
                            $fragmentFound = (bool)preg_match($pattern, $contents);
                            //TODO: Alternatively, Markdown headers could extracted, converted to anchors, and then compared
                        }
                    }
                }
                break;
            case 301: // Moved Permanently
            case 302: // Found
            case 303: // See Other
            case 307: // Temporary Redirect
            case 308: // Permanent Redirect
                foreach ($headers as $header) {
                    if (str_starts_with(strtolower($header), 'location: ')) {
                        if (false !== preg_match('/^[Ll]ocation: (?P<location>.*)$/', $header, $matches)) {
                            $parsedUrl = parse_url($url);
                            $parsedLocation = parse_url($matches['location']);
                            foreach (array_keys($parsedUrl) as $key) {
                                if (!array_key_exists($key, $parsedLocation)) {
                                    $parsedLocation[$key] = $parsedUrl[$key];
                                }
                            }
                            if (array_key_exists('query', $parsedLocation) && !empty($parsedLocation['query'])) {
                                $query = '?' . $parsedLocation['query'];
                            } else {
                                $query = '';
                            }
                            if (array_key_exists('fragment', $parsedLocation) && !empty($parsedLocation['fragment']) && '#' !== $parsedLocation['fragment'][0]) {
                                $fragment = '#' . $parsedLocation['fragment'];
                            } else {
                                $fragment = '';
                            }
                            $location = "{$parsedLocation['scheme']}://{$parsedLocation['host']}{$parsedLocation['path']}{$query}$fragment";
                            break;
                        }
                    }
                }
                break;
            case 522: // Connection Timed Out
                if ($tryNumber <= $retryCount + 1) {
                    sleep($retryDelay);
                    return self::testUrl($url, $external, $testFragment, $useCurl, $retryCount, $retryDelay, $tryNumber++);
                }
            case 400: // Bad Request
            case 401: // Unauthorized
            case 403: // Forbidden
            case 404: // Not Found
            case 405: // Method Not Allowed
            case 500: // Internal Server Error
            default:
        }

        return [
            'headers' => $headers,
            'code' => $code,
            'location' => $location,
            'fragment_found' => $fragmentFound,
        ];
    }

    public static function requestHeaders($url, $useCurl = false): array
    {
        if ($useCurl) {
            return preg_split('/\R/', trim(shell_exec("curl -s -I $url") ?? ''));
        }
        return @get_headers($url) ?: [];
    }

    public static function requestBody($url, $useCurl = false): string
    {
        if ($useCurl) {
            return shell_exec("curl -s $url") ?? '';
        }
        return @file_get_contents($url) ?: '';
    }

    /** @return string[] */
    public function getHeaders(): array
    {
        return $this->headers ?: [];
    }

    public function getCode(): string
    {
        if (empty($this->code)) {
            return '   ';
        }

        return str_pad((string)$this->code, 3, '0', STR_PAD_LEFT);
    }

    public function hasLocation(): bool
    {
        return null !== $this->location;
    }

    public function getLocation(): ?TestableUrl
    {
        return $this->location;
    }

    /** @return TestableUrl[] */
    public function getLocations(): array
    {
        $locations = [];
        $location = $this;
        while ($location->hasLocation()) {
            $location = $location->getLocation();
            $locations[] = $location;
        }
        return $locations;
    }

    /** @return string[] */
    public function getUrls(): array
    {
        $urls = [$this->getUrl()];
        foreach ($this->getLocations() as $location) {
            $urls[] = $location->getUrl();
        }
        return $urls;
    }

    public static function isUrlWithFragment($url): bool
    {
        return str_contains($url, '#') && !str_ends_with($url, '#');
    }

    public function hasFragment(): bool
    {
        return self::isUrlWithFragment($this->getUrl());
    }

    public static function getUrlFragment($url): string
    {
        return parse_url($url, PHP_URL_FRAGMENT);
    }

    public static function getUrlWithoutFragment($url): string
    {
        if (self::isUrlWithFragment($url)) {
            return str_replace('#' . self::getUrlFragment($url), '', $url);
        }
        return $url;
    }

    public function getFragment(): string
    {
        return self::getUrlFragment($this->getUrl());
    }

    private function isFragment(): bool
    {
        return str_starts_with($this->getUrl(), '#');
    }

    public function isFragmentFound(): ?bool
    {
        return $this->fragmentFound;
    }
}


class UrlExtractor
{
    /** @var array[] */
    private $patterns;

    /** @var array|null */
    private $replacements;

    /** @var bool|null */
    private $find;

    private const PATTERN_DELIMITER = '@';
    private const LINE_PATTERN = '(?P<line>[0-9]+)?:?';

    /**
     * @param array[]|null $patterns A map of file extensions and pattern lists.
     * @param string[]|null $replacements A map of replacements ['what_to_replace'=>'by_what_to replace']
     * @param bool|string $find If the URL target must be searched for instead of just being considered as a relative path; If a string is given, it will be used as search prefix
     * @see UrlExtractor::getDefaultPatterns For an example of pattern map.
     */
    public function __construct(?array $patterns = null, ?array $replacements = null, mixed $find = false)
    {
        $this->patterns = null === $patterns ? self::getDefaultPatterns() : $patterns;
        $this->flattenPatterns();
        $this->replacements = $replacements;
        $this->find = $find;
    }

    /** @return TestableUrl[] */
    public function extract(string $file): array
    {
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        if ('zip' === $extension) {
            return $this->extractFromArchive($file);
        }

        //var_dump($this->getGrepCommand($file));
        $grepOutput = trim(shell_exec($this->getGrepCommand($file)) ?? '');
        if (empty($grepOutput)) {
            return [];
        }

        $grepLines = explode("\n", $grepOutput);
        unset($grepOutput);

        $urls = [];

        $line = 0;
        $linePattern = self::LINE_PATTERN;
        $patterns = $this->getPhpPatterns($extension);
        $patternDelimiter = self::PATTERN_DELIMITER;
        for ($index = 0; $index < count($grepLines); ++$index) {
            $grepLine = $grepLines[$index];
            $matches = [];
            foreach ($patterns as $pattern) {
                if (preg_match("{$patternDelimiter}{$linePattern}{$pattern}{$patternDelimiter}", $grepLine, $matches)) {
                    break;
                }
            }
            if (array_key_exists('line', $matches) && strlen($matches['line'])) {
                $line = $matches['line'];
            }
            if (empty($matches['url'])) {
                continue;
            }
            $urls[] = new TestableUrl($matches['url'], array_key_exists('text', $matches) ? $matches['text'] : null, $file, $line, $this->replacements, $this->find);
        }

        return $urls;
    }

    /** @return TestableUrl[] */
    private function extractFromArchive(string $archivePath): array
    {
        $urls = [];

        $dir = pathinfo($archivePath, PATHINFO_DIRNAME);
        $rawFileList = explode("\n", shell_exec("unzip -l $archivePath"));
        $rawFileList = array_slice($rawFileList, 3, -3);
        foreach ($rawFileList as $rawFileLine) {
            if (!preg_match('@ *(?P<length>[^ ]+) +(?P<date>[^ ]+) +(?P<time>[^ ]+) +(?P<name>[^ ]+)@', $rawFileLine, $matches)) {
                continue;
            }
            $subFilePath = $matches['name']; //TODO solve relative path
            if ('/' === substr($subFilePath, -1)) {
                continue;
            }
            $filePaths = (new Finder('.'))->includeWholeName("*/$subFilePath")->find();
            switch (count($filePaths)) {
                case 0:
                    $filePath = $subFilePath;
                    break;
                case 1:
                    $filePath = $filePaths[0];
                    break;
                default:
                    $filePath = $filePaths[0];
            }
            $filePath = TestableUrl::getRelativePath($archivePath, $filePath);
            $urls[] = new TestableUrl($filePath, null, $archivePath);
        }

        return $urls;
    }

    private function flattenPatterns(?string $reRunExtension = null): self
    {
        if (array_key_exists('*', $this->patterns)) {
            unset($this->patterns['*']);
        }
        if (null === $reRunExtension) {
            $oldPatterns = $this->patterns;
            $newPatterns = [];
        } else if (array_key_exists($reRunExtension, $this->patterns)) {
            $oldPatterns = [$reRunExtension => $this->patterns[$reRunExtension]];
            $newPatterns = $this->patterns;
        } else {
            throw new InvalidArgumentException("Unknown extension '$reRunExtension'");
        }

        $reRun = [];

        foreach ($oldPatterns as $extension => $patterns) {
            $newPatterns[$extension] = [];
            foreach ($patterns as $pattern) {
                if (array_key_exists($pattern, $oldPatterns)) {
                    $reRun[] = $extension;
                    $newPatterns[$extension] = array_merge($newPatterns[$extension], $oldPatterns[$pattern]);
                } else {
                    $newPatterns[$extension][] = $pattern;
                }
            }
        }

        $this->patterns = $newPatterns;

        foreach ($reRun as $extension) {
            $this->flattenPatterns($extension);
        }

        if (!$reRunExtension) {
            $allPatterns = [];
            foreach ($this->patterns as $extension => $patterns) {
                $this->patterns[$extension] = array_unique($this->patterns[$extension], SORT_REGULAR);
                $allPatterns = array_merge($allPatterns, $this->patterns[$extension]);
            }
            $this->patterns['*'] = array_unique($allPatterns, SORT_REGULAR);
        }

        return $this;
    }

    /**
     * Built-in pattern map used as default when one given in UrlExtractor::__construct
     * A pattern map is an associative array associating file extensions with pattern lists.
     * A pattern can be a PCRE Pattern without delimiters.
     * A pattern can be another file extension to include the pattern list of this extension into the current list.
     * @return array[]
     * @see UrlExtractor::getXmlTagPattern() to generate a pattern for an XML/HTML tag and attritube.
     */
    public static function getDefaultPatterns(): array
    {
        return [
            'txt' => [
                // '(?P<url>(https?:)?//[^ "<>]+[^ "<>)*,.\`])', // URL genuinely starting with double slashes without scheme are genuine but not used and confused with PHP comments
                '(?P<url>https?://[^ \'"<>]+[^ \'"<>)*,.\`])',
            ],
            'css' => [
                'url\(["\']?(?P<url>[^)"\']*)["\']?\)',
            ],
            'scss' => [
                'css',
            ],
            'html' => [
                'data-markdown="(?P<url>[^"]+)"',
                "loadAndParseMarkdown\('(?P<url>[^\)]+)'\);",
                "new Gift\('(?P<url>[^\)]+)'",
                self::getXmlTagPattern('a', 'href', true),
                self::getXmlTagPattern('link', 'href'),
                self::getXmlTagPattern('script', 'src'),
                self::getXmlTagPattern('img', 'src'),
            ],
            'md' => [
                '\[(?P<text>[^[]*)\]\((?P<url>[^ )]+)\)',
                '!\[[^[]*\]\((?P<url>[^ )]+) "(?P<text>[^"]+)"\)',
                self::getXmlTagPattern('img', 'src'),
                self::getXmlTagPattern('a', 'href', true),//TODO: shouldn't be there
                'txt',
            ],
        ];
    }

    public static function getXmlTagPattern(string $tagName, string $urlAttribute, bool $text = false): string
    {
        return "<$tagName [^>]*$urlAttribute=\"(?P<url>[^\"]+)\"" . ($text ? '[^>]*>(?P<text>[^<]*)' : '');
    }

    /** @return string[] */
    public function getPhpPatterns(string $extension): array
    {
        if (array_key_exists($extension, $this->patterns)) {
            return $this->patterns[$extension];
        } else {
            throw new InvalidArgumentException("File extension '$extension' not supported.");
        }
    }

    public function getGrepPattern(string $extension): string
    {
        return implode('|', array_map(function ($pattern) {
            return self::convertPatternFromPhpToGrep($pattern);
        }, $this->getPhpPatterns($extension)));
    }

    public function getGrepCommand(string $file): string
    {
        $pattern = str_replace('"', '\"',
            $this->getGrepPattern(pathinfo($file, PATHINFO_EXTENSION)));
        return "grep -onE \"$pattern\" $file";
    }

    public static function convertPatternFromPhpToGrep(string $pattern): string
    {
        return preg_replace('/\?P<[^>]+>/', '', $pattern);
    }

    public function getGrepUrlSearchPattern(string $extension, string $url): string
    {
        // If (.md and $find…)
        return implode('|', array_map(function (string $pattern) use ($url) {
            return
                self::convertPatternFromPhpUrlExtractionToGrepUrlSearch($pattern, $url)
                .
                '|' . str_replace($url, "./$url", self::convertPatternFromPhpUrlExtractionToGrepUrlSearch($pattern, $url));
        }, $this->getPhpPatterns($extension)));
    }

    public function getGrepUrlSearchCommand(string $file, string $url): string
    {
        $pattern = str_replace('"', '\"',
            $this->getGrepUrlSearchPattern(pathinfo($file, PATHINFO_EXTENSION), $url));
        return "grep -onE \"$pattern\" $file";
    }

    public static function convertPatternFromPhpUrlExtractionToGrepUrlSearch(string $pattern, string $url): ?string
    {
        if (null !== $phpUrlSearchPattern = self::convertPatternFromPhpUrlExtractionToPhpUrlSearch($pattern, $url)) {
            return self::convertPatternFromPhpToGrep($phpUrlSearchPattern);
        }

        return null;
    }

    private static function convertPatternFromPhpUrlExtractionToPhpUrlSearch(string $pattern, string $url): ?string
    {
        if (null !== $group = self::extractGroupFromPattern($pattern, 'url')) {
            return str_replace($group, $url, $pattern);
        }

        return null;
    }

    public static function extractGroupFromPattern($pattern, $groupName): ?string
    {
        $p = $pattern;
        $sp = "(?P<$groupName>";
        $s = strpos($p, $sp);
        if (false === $s) {
            $sp = "(?<$groupName>";
            $s = strpos($p, $sp);
            if (false === $s) {
                return null;
            }
        }
        for ($e = $s + strlen($sp), $bc = 0, $pc = 0, $f = false; !$f && $e < strlen($p); $e++) {
            if ('\\' === $p[$e]) {
                // escape next char
                $e++;
                continue;
            }
            if ('[' === $p[$e]) {
                $bc++;
            }
            if (']' === $p[$e]) {
                $bc--;
            }
            if (0 === $bc) {
                if ('(' === $p[$e]) {
                    $pc++;
                }
                if (')' === $p[$e]) {
                    $pc--;
                }
                if (')' === $p[$e] && 0 > $pc) {
                    $f = true;
                }
            }
        }
        return substr($p, $s, $e - $s);
    }
}


/**
 * Class to test/check a collection of internal and/or external URLs extract from files,
 * and to check the usage of internal ressource files by those URLs
 */
class UrlTester
{
    /** @var string[] */
    private $usageFiles = [];

    /** @var string[] */
    private $resourceFiles = [];

    /** @var array[] */
    private $exclusionTests = [
        'url' => [],
        'header' => [],
        'location' => [],
        'fragment' => [],
    ];

    private $curlUsageTests = [];

    /** @var null|string[] */
    private $replacements = [];

    /** @var null|bool */
    private $find;

    /** @var resource */
    private $output;

    /** @var resource */
    private $error;

    /** @var UrlExtractor */
    private $urlExtractor;

    /** @var TestableUrl[][] */
    private $urls = [];

    public const VERBOSITY_QUIET = 1000;
    public const VERBOSITY_LOUD = 0;
    public const VERBOSITY_DEFAULT = 300;

    /**
     * @param array<int, string> $usageFiles The list of files to extract URLs from
     * @param array<int, string> $resourceFiles The list of files that should be used by those URLs
     * @param array<string, array<int, callable>>|null $exclusionTests An associative array of arrays of functions testing if a URL should be excluded from test
     * @param array<int, callable>|null $curlUsageTests An array of functions testing if URL should be requested using `curl` instead of PHP
     * @param array<string, string>|null $replacements A replacement map to apply on each URL
     * @param bool|string $find If the URL target must be searched for instead of just being considered as a relative path; If a string is given, it will be used as search prefix
     * @param callable|null $output A callable to pass standard output message to
     * @param callable|null $error A callable to pass error message to
     */
    public function __construct(array $usageFiles = [], array $resourceFiles = [], ?array $exclusionTests = null, ?array $curlUsageTests = null, ?array $replacements = null, mixed $find = false, ?callable $output = null, ?callable $error = null)
    {
        $this->setUsageFiles($usageFiles);
        $this->setResourceFiles($resourceFiles);
        $this->setExclusionTests(is_array($exclusionTests) ? $exclusionTests : self::getDefaultExclusionTests());
        $this->curlUsageTests = $curlUsageTests ?? [];
        $this->replacements = $replacements;
        $this->find = $find;
        foreach ([
                     'STDOUT' => 'output',
                     'STDERR' => 'error',
                 ] as $defaultConstant => $argumentVariable) {
            if (null === $$argumentVariable && defined($defaultConstant)) {
                $$argumentVariable = constant($defaultConstant);
            }
            if (!is_resource($$argumentVariable) || 'stream' !== get_resource_type($$argumentVariable)) {
                throw new InvalidArgumentException("$argumentVariable must be a stream resource");
            }
            //$this->$argumentVariable = $$argumentVariable;
        }
        $this->output = $output;
        $this->error = $error;
        $this->urlExtractor = new UrlExtractor(null, $this->replacements, $this->find);
    }

    /** @return string[] */
    public function getUsageFiles(): array
    {
        return $this->usageFiles;
    }

    /** @param string[] $usageFiles */
    public function setUsageFiles(array $usageFiles): void
    {
        $this->usageFiles = $usageFiles;
    }

    /** @param string|string[] $usageFiles */
    public function addUsageFiles(...$usageFiles): void
    {
        foreach ($usageFiles as $usageFile) {
            if (is_array($usageFile)) {
                $this->usageFiles = array_merge($this->usageFiles, $usageFile);
            } elseif (is_string($usageFile)) {
                $this->usageFiles[] = $usageFile;
            }
        }
    }

    /** @return string[] */
    public function getResourceFiles(): array
    {
        return $this->resourceFiles;
    }

    /** @param string[] $resourceFiles */
    public function setResourceFiles(array $resourceFiles): void
    {
        $this->resourceFiles = $resourceFiles;
    }

    /** @param string|string[] $resourceFiles */
    public function addResourceFiles(...$resourceFiles): void
    {
        foreach ($resourceFiles as $resourceFile) {
            if (is_array($resourceFile)) {
                $this->resourceFiles = array_merge($this->resourceFiles, $resourceFile);
            } elseif (is_string($resourceFile)) {
                $this->resourceFiles[] = $resourceFile;
            }
        }
    }

    public function setExclusionTests($tests)
    {
        foreach (array_keys($this->exclusionTests) as $type) {
            if (array_key_exists($type, $tests)) {
                $this->exclusionTests[$type] = $tests[$type];
            }
        }
    }

    public static function getDefaultExclusionTests(): array
    {
        return [
            'url' => [
                function (string $url, ?string $file = null): bool {
                    return str_contains($url, 'example.com');
                },
            ],
            'header' => [
                function (string $url, int $code, array $headers, ?string $file = null) {
                    return 403 === $code && in_array('Server: cloudflare', $headers);
                },
            ],
            'location' => [
                //function (string $url, string $location, ?string $file = null): bool {
                //    return …;
                //},
            ],
            'fragment' => [
                function (string $url, ?string $file = null): bool {
                    if (str_starts_with($url, 'https://github.com/')) {
                        $fragment = TestableUrl::getUrlFragment($url);
                        if (preg_match('@^L[0-9]+(-L[0-9]+)?$@', $fragment)) {
                            return true;
                        }
                        $contents = file_get_contents(TestableUrl::getUrlWithoutFragment($url));
                        return str_contains($contents, "=\"user-content-$fragment\"") || str_contains($contents, "=\\\"user-content-$fragment\\\"");
                    }
                    return false;
                },
                function (string $url, ?string $file = null): bool {
                    return (bool)preg_match('@\.eot\?#@', $url);
                },
            ],
        ];
    }

    public function test(int $invalidityThreshold = self::VERBOSITY_DEFAULT, bool $fragmentValidity = true): bool
    {
        return $this->testUsages($invalidityThreshold, $fragmentValidity, self::VERBOSITY_QUIET) && $this->testResources(self::VERBOSITY_QUIET);
    }

    public function testUsages(int $invalidityThreshold = 300, bool $fragmentValidity = true, int $verbosityThreshold = self::VERBOSITY_DEFAULT): bool
    {
        $valid = true;

        $testableUrls = [];
        foreach ($this->getUsageFiles() as $file) {
            $fileTestableUrls = $this->urlExtractor->extract($file);
            if (empty($fileTestableUrls)) {
                if (self::VERBOSITY_LOUD >= $verbosityThreshold) {
                    $this->output("$file: No URL to test");
                }
            } else {
                $testableUrls = array_merge($testableUrls, $fileTestableUrls);
            }
        }
        $file = null;
        /** @var TestableUrl $testableUrl */
        foreach ($testableUrls as $testableUrl) {
            $mainHasBeenShown = false;
            if (self::VERBOSITY_QUIET > $verbosityThreshold) {
                if ($testableUrl->getFile() !== $file) {
                    $file = $testableUrl->getFile();
                    $this->output("\n{$file}");
                }
            }

            $url = self::formatUrl($testableUrl->getSolvedUrl());
            if (array_key_exists($url, $this->urls) && is_array($this->urls[$url])) {
                // Already tested, just the same URL found in another file or at another line, store it without re-testing it
                $this->urls[$url][] = $testableUrl;
            } else {
                if ($this->isExcludedUrl($testableUrl)) {
                    continue;
                }
                $testableUrl->test(false, $fragmentValidity, $this->mustUseCurl($testableUrl));
                if ($testableUrl->isExternal() && $this->isExcludedHeader($testableUrl)) {
                    continue;
                }
                $this->urls[$url] = [$testableUrl];
            }
            $testedUrl = $this->urls[$url][0];
            if ($testedUrl->hasLocation() && $this->isExcludedLocation($testedUrl)) {
                continue;
            }
            if ($fragmentValidity && 200 == $testedUrl->getCode() && !$testedUrl->hasLocation() && $testedUrl->hasFragment() && !$testedUrl->isFragmentFound() && !$this->isExcludedFragment($testableUrl)) {
                $this->outputUrl($testableUrl, $testedUrl);
                $valid = false;
                $mainHasBeenShown = true;
            } else if ($testedUrl->getCode() >= $invalidityThreshold) {
                $this->outputUrl($testableUrl, $testedUrl);
                $valid = false;
                $mainHasBeenShown = true;
            } else if ($testedUrl->getCode() >= $verbosityThreshold) {
                $this->outputUrl($testableUrl, $testedUrl);
                $mainHasBeenShown = true;
            }

            $location = $testedUrl;
            $loop = $testedUrl->getUrl() === ($testedUrl->hasLocation() ? $testedUrl->getLocation()->getUrl() : null);
            /** @var TestableUrl $location */
            while (!$loop && $location = $location->getLocation()) {
                $url = self::formatUrl($location->getSolvedUrl());
                if (array_key_exists($url, $this->urls)) {
                    // Already tested, retrieve the TestableUrl object on which the test has been run, the first one.
                    $testedLocation = $this->urls[$url][0];
                } else {
                    $testedLocation = $location->test(false, $fragmentValidity, $this->mustUseCurl($location));
                    $this->urls[$url] = [$testedLocation];
                }
                $this->urls[$url][] = $testedUrl;//Store that this URL is used (indirectly) by "this file at this line"
                if ($fragmentValidity && 200 == $testedLocation->getCode() && !$testedLocation->hasLocation() && $testedLocation->hasFragment() && !$testedLocation->isFragmentFound()) {
                    if (!$mainHasBeenShown) {
                        $this->outputUrl($testableUrl, $testedUrl);
                        $mainHasBeenShown = true;
                    }
                    $this->outputUrl($location, $testedLocation, false, false);
                    $valid = false;
                } else if ($testedLocation->getCode() >= $verbosityThreshold || $testableUrl->hasLocation() && 300 <= $verbosityThreshold) {
                    if (!$mainHasBeenShown) {
                        $this->outputUrl($testableUrl, $testedUrl);
                        $mainHasBeenShown = true;
                    }
                    $this->outputUrl($location, $testedLocation, false, false);
                    $valid = false;
                }
                $loop = $testedLocation->getUrl() === ($testedLocation->hasLocation() ? $testedLocation->getLocation()->getUrl() : null);
                if (!$location->hasLocation() && $testedLocation->hasLocation()) {
                    $location = $testedLocation;
                }
            }
        }
        if (self::VERBOSITY_QUIET > $verbosityThreshold) {
            if (empty($testableUrls)) {
                $this->output(PHP_EOL . 'No URL found, nothing to test.');
            } else if ($valid) {
                $this->output(PHP_EOL . 'All URLs are targeting existing resources.');
            }
            $this->output('');
        }

        return $valid;
    }

    public function testResources(int $verbosity = self::VERBOSITY_DEFAULT): bool
    {
        $valid = true;

        $resourceFiles = $this->getResourceFiles();
        foreach ($resourceFiles as $resourceFile) {
            $url = self::formatUrl($resourceFile);
            if (array_key_exists($url, $this->urls) && !empty($this->urls[$url])) {
                if (self::VERBOSITY_LOUD >= $verbosity) {
                    $testedUrl = $this->urls[$url][0];
                    $usageCount = count($this->urls[$url]);
                    $line = is_null($testedUrl->getLine()) ? '' : " at line {$testedUrl->getLine()}";
                    if ($usageCount > 1) {
                        $this->output("$url is used $usageCount times, at least in {$testedUrl->getFile()}{$line}.");
                    } else {
                        $this->output("$url is used in {$testedUrl->getFile()}{$line}.");
                    }
                }
                continue;
            }
            if (empty($this->urls)) {
                // If `testUsage()` haven't been run previously…
                $found = false;
                foreach ($this->getUsageFiles() as $usageFile) {
                    $relativeUrl = TestableUrl::getRelativePath($usageFile, $url);
                    $grepOutput = trim(shell_exec($this->urlExtractor->getGrepUrlSearchCommand($usageFile, $relativeUrl))??'');
                    if (!empty($grepOutput)) {
                        $found = true;
                        break;
                    }
                }
                if ($found) {
                    if (self::VERBOSITY_LOUD >= $verbosity) {
                        $this->output("$url is used at least in $usageFile.");
                    }
                } else {
                    $valid = false;
                    if (self::VERBOSITY_QUIET > $verbosity) {
                        $this->output("$url is not used.");
                    }
                }
            } else {
                $valid = false;
                if (self::VERBOSITY_QUIET > $verbosity) {
                    $this->output("$url is not used.");
                }
            }
        }
        if (self::VERBOSITY_QUIET > $verbosity) {
            if (empty($resourceFiles)) {
                $this->output((self::VERBOSITY_LOUD >= $verbosity ? PHP_EOL : '') . 'No resource to test.');
            } else if ($valid) {
                $this->output((self::VERBOSITY_LOUD >= $verbosity ? PHP_EOL : '') . 'All resources are used.');
            }
            $this->output('');
        }

        return $valid;
    }

    public function mustUseCurl(TestableUrl $testableUrl): bool
    {
        foreach ($this->curlUsageTests as $test) {
            if ($test(self::formatUrl($testableUrl->getSolvedUrl()), $testableUrl->getFile())) {
                return true;
            }
        }
        return false;
    }

    public function isExcludedUrl(TestableUrl $testableUrl): bool
    {
        $url = $testableUrl->getUrl();
        foreach ($this->exclusionTests['url'] as $test) {
            if ($test($url, $testableUrl->getFile())) {
                return true;
            }
        }
        $solvedUrl = self::formatUrl($testableUrl->getSolvedUrl());
        if ($url !== $solvedUrl) {
            foreach ($this->exclusionTests['url'] as $test) {
                if ($test($solvedUrl, $testableUrl->getFile())) {
                    return true;
                }
            }
        }
        return false;
    }

    public function isExcludedHeader(TestableUrl $testableUrl): bool
    {
        $headers = $testableUrl->getHeaders();
        if ($testableUrl->isExternal() && !empty($headers)) {
            $url = self::formatUrl($testableUrl->getSolvedUrl());
            foreach ($this->exclusionTests['header'] as $test) {
                if ($test($url, (int)$testableUrl->getCode(), $headers)) {
                    return true;
                }
            }
        }
        return false;
    }

    public function isExcludedLocation(TestableUrl $testableUrl): bool
    {
        foreach ($this->exclusionTests['location'] as $test) {
            if ($test(self::formatUrl($testableUrl->getSolvedUrl()), self::formatUrl($testableUrl->getLocation()->getSolvedUrl()), $testableUrl->getFile())) {
                return true;
            }
        }
        return false;
    }

    public function isExcludedFragment(TestableUrl $testableUrl): bool
    {
        foreach ($this->exclusionTests['fragment'] as $test) {
            if ($test(self::formatUrl($testableUrl->getSolvedUrl()), $testableUrl->getFile())) {
                return true;
            }
        }
        return false;
    }

    /**
     * Format URL.
     *
     * If the URL is external: possibly replace heading "//" with "https://".
     * If the URL is internal: possibly remove leading "./".
     */
    public static function formatUrl(string $url): string
    {
        if (TestableUrl::isExternalUrl($url)) {
            $url = preg_replace('@^//@', TestableUrl::DEFAULT_SCHEME . '://', $url);
        } else {
            $url = preg_replace('@^\./@', '', $url);
        }

        return $url;
    }

    private function outputUrl(TestableUrl $testableUrl, ?TestableUrl $testedUrl = null, $withFile = false, $withLine = true, $withCode = true): self
    {
        $file = $testableUrl->getFile();
        $file = $withFile && $file !== null ? "{$file}@" : '';
        $line = $testableUrl->getLine();
        $line = $withLine && null !== $line ? "{$line}: " : ': ';
        if ($withCode) {
            $code = null === $testedUrl ? $testableUrl->getCode() : $testedUrl->getCode();
            $code = null === $code ? '--- ' : "$code ";
        } else {
            $code = '';
        }
        $location = null !== $testedUrl && !$testableUrl->hasLocation() && $testedUrl->hasLocation() ? " → {$testedUrl->getLocation()->getUrl()}" : '';
        $fragment = 200 != $testedUrl->getCode() || !$testableUrl->hasFragment() || $testedUrl->hasLocation() ? '' :
            ($testedUrl->isFragmentFound() ? ' (fragment found)' : ($this->isExcludedFragment($testableUrl) ? ' (fragment excluded)' : " ! `#{$testableUrl->getFragment()}` fragment not found."));
        $this->output("{$file}{$line}{$code}{$testableUrl}{$location}{$fragment}");
        return $this;
    }

    private function output(string $line): self
    {
        fwrite($this->output, $line . PHP_EOL);
        return $this;
    }

    private function error(string $line): self
    {
        fwrite($this->error, $line . PHP_EOL);
        return $this;
    }
}


class Finder
{
    const TYPE_BLOCK = 'b';// block special
    const TYPE_CHAR = 'c';// character special
    const TYPE_DIR = 'd';// directory
    const TYPE_FILE = 'f';// regular file
    const TYPE_LINK = 'l';// symbolic link
    const TYPE_FIFO = 'p';// FIFO
    const TYPE_SOCKET = 's';// socket

    private $where;
    private $minDepth;
    private $maxDepth;
    private $includedNames = [];
    private $excludedNames = [];
    private $includedWholeNames = [];
    private $excludedWholeNames = [];
    private $includedTypes = [];
    private $excludedTypes = [];

    public function __construct(string $where = '.', ?int $minDepth = null, ?int $maxDepth = null)
    {
        $this->where = preg_replace('@/$@', '', $where);
        $this->minDepth = $minDepth;
        $this->maxDepth = $maxDepth;
    }

    public function includeName($pattern): self
    {
        $this->includedNames[] = $pattern;
        return $this;
    }

    public function inN($pattern): self
    {
        return $this->includeName($pattern);
    }

    public function excludeName($pattern): self
    {
        $this->excludedNames[] = $pattern;
        return $this;
    }

    public function exN($pattern): self
    {
        return $this->excludeName($pattern);
    }

    public function includeWholeName($pattern): self
    {
        $this->includedWholeNames[] = $pattern;
        return $this;
    }

    public function inWN($pattern): self
    {
        return $this->includeWholeName($pattern);
    }

    public function excludeWholeName($pattern): self
    {
        $this->excludedWholeNames[] = $pattern;
        return $this;
    }

    public function exWN($pattern): self
    {
        return $this->excludeWholeName($pattern);
    }

    public function includeType($type): self
    {
        $this->includedTypes[] = $type;
        return $this;
    }

    public function inT($type): self
    {
        return $this->includeType($type);
    }

    public function excludeType($type): self
    {
        $this->excludedTypes[] = $type;
        return $this;
    }

    public function exT($type): self
    {
        return $this->excludeType($type);
    }

    public function find(): array
    {
        //var_dump($this->getFindCommand());
        $rawFileList = shell_exec($this->getFindCommand());
        if (null === $rawFileList || empty($rawFileList = trim($rawFileList))) {
            return [];
        }
        return array_map(function ($path) {
            return preg_replace('@^\./@', '', $path);
        }, explode("\n", $rawFileList));
    }

    private function getFindCommand(): string
    {
        $criteria = [];

        foreach ([
                     'mindepth' => $this->minDepth,
                     'maxdepth' => $this->maxDepth,
                 ] as $option => $value) {
            if (null !== $value) {
                $criteria[] = "-{$option} $value";
            }
        }

        $groups = [];
        foreach ([
                     'name' => [
                         'in' => $this->includedNames,
                         'ex' => $this->excludedNames,
                     ],
                     'wholename' => [
                         'in' => $this->includedWholeNames,
                         'ex' => $this->excludedWholeNames,
                     ],
                     'type' => [
                         'in' => $this->includedTypes,
                         'ex' => $this->excludedTypes,
                     ],
                 ] as $type => $patterns) {
            if (!empty($patterns['in'])) {
                $groups[] = implode(' -o ', array_map(function ($pattern) use ($type) {
                    return "-{$type} '{$pattern}'";
                }, $patterns['in']));
            }
            if (!empty($patterns['ex'])) {
                $groups[] = implode(' -a ', array_map(function ($pattern) use ($type) {
                    return "! -{$type} '{$pattern}'";
                }, $patterns['ex']));
            }
        }
        if (!empty($groups)) {
            $criteria[] = '\( ' . implode(' \) -a \( ', $groups) . ' \)';
        }

        $criteria = empty($criteria) ? '' : ' ' . implode(' ', $criteria);
        return "find {$this->where}{$criteria};";
    }
}


class UrlTestCommand
{
    private static function buildFinder($where, $minDepth = null, $maxDepth = null, $includedNames = [], $excludedNames = [], $includedTypes = [], $excludedTypes = []): Finder
    {
        $finder = new Finder($where, $minDepth, $maxDepth);
        foreach ($includedNames as $includedName) {
            if (str_contains($includedName, '/')) {
                $finder->includeWholeName($includedName);
            } else {
                $finder->includeName($includedName);
            }
        }
        foreach ($excludedNames as $excludedName) {
            if (str_contains($excludedName, '/')) {
                $finder->excludeWholeName($excludedName);
            } else {
                $finder->excludeName($excludedName);
            }
        }
        foreach ($includedTypes as $includedType) {
            $finder->includeType($includedType);
        }
        foreach ($excludedTypes as $excludedType) {
            $finder->excludeType($excludedType);
        }

        return $finder;
    }

    static function newUrlTesterFromCommand(array $argv, ?array $exclusionTests = null, ?array $replacements = null, mixed $find = false): UrlTester
    {
        $finders = [
            'usage' => [],
            'resource' => [],
        ];

        if (str_contains(__FILE__, $argv[0])) {
            array_shift($argv);
        }

        $finished = false;
        $currentCategory = null;
        $nextCategory = null;
        $where = null;
        $minDepth = null;
        $maxDepth = null;
        $includedNames = [];
        $excludedNames = [];
        $includedTypes = [];
        while (!empty($argv)) {
            $arg = trim(array_shift($argv));
            if (empty($arg)) {
                continue;
            }
            switch ($arg) {
                case '-h':
                case '--help':
                case '-v':
                case '--verbose':
                    break;
                case '-c':
                case '--config':
                    array_shift($argv);
                    break;
                case '-u':
                case '--usage':
                case '--usages':
                    $finished = true;
                    $nextCategory = 'usage';
                    break;
                case '-r':
                case '--resource':
                case '--resources':
                    $finished = true;
                    $nextCategory = 'resource';
                    break;
                case '(':
                    break;
                case ')':
                    $finished = true;
                    break;
                case '-n':
                case '--inn':
                case '--name':
                case '--in-name':
                case '--include-name':
                case '--included-name':
                    $includedNames[] = array_shift($argv);
                    break;
                case '-en':
                case '-nn':
                case '--exn':
                case '--ex-name':
                case '--not-name':
                case '--exclude-name':
                case '--excluded-name':
                    $excludedNames[] = array_shift($argv);
                    break;
                case '-t':
                case '--int':
                case '--type':
                case '--include-type':
                case '--included-type':
                    $includedTypes[] = array_shift($argv);
                    break;
                case '-et':
                case '-nt':
                case '--ext':
                case '--ex-type':
                case '--not-type':
                case '--exclude-type':
                case '--excluded-type':
                    $excludedTypes[] = array_shift($argv);
                    break;
                case '--mind':
                case '--mindepth':
                case '--min-depth':
                    $minDepth = array_shift($argv);
                    break;
                case '--maxd':
                case '--maxdepth':
                case '--max-depth':
                    $maxDepth = array_shift($argv);
                    break;
                case '-d':
                case '--dir';
                case '--directory';
                case '-w':
                case '--where';
                    $where = array_shift($argv);
                    break;
                default:
                    $where = $arg;
            }

            if ($finished || empty($argv)) {
                if (!empty($currentCategory) && array_key_exists($currentCategory, $finders) && !empty($where)) {
                    if (empty($includedTypes)) {
                        $includedTypes[] = Finder::TYPE_FILE;
                    }
                    $finders[$currentCategory][] = self::buildFinder($where, $minDepth, $maxDepth, $includedNames, $excludedNames, $includedTypes, $excludedTypes ?? []);
                }

                $finished = false;
                $currentCategory = $nextCategory ?: $currentCategory;
                $nextCategory = null;
                $where = null;
                $minDepth = null;
                $maxDepth = null;
                $includedNames = [];
                $excludedNames = [];
                $includedTypes = [];
            }
        }

        $files = [
            'usage' => [],
            'resource' => [],
        ];

        foreach (array_keys($finders) as $category) {
            foreach ($finders[$category] as $finder) {
                $files[$category] = array_merge($files[$category], $finder->find());
            }
            $files[$category] = call_user_func(function (array $a): array {
                asort($a);
                return $a;
            }, array_unique($files[$category]));
        }

        return new UrlTester($files['usage'], $files['resource'], $exclusionTests, null, $replacements, $find);
    }
}


$options = array_slice($argv, 1);

if (!empty($options)) {
    foreach (['-c', '--config'] as $option) {
        if (in_array($option, $options)) {
            $argIndex = array_search($option, $options);
            $configFile = $options[1 + $argIndex];
            if (!file_exists($configFile)) {
                if (file_exists(__DIR__ . '/' . $configFile)) {
                    $configFile = __DIR__ . '/' . $configFile;
                } else {
                    throw new InvalidArgumentException("Config file $configFile not found.");
                }
            }
            include_once $configFile;
            array_splice($options, $argIndex, 2);
        }
    }
}

$usageFiles = $usageFiles ?? [];
$resourceFiles = $resourceFiles ?? [];
$helpDesc = $helpDesc ?? '';
$exclusionTests = $exclusionTests ?? null;
$curlUsageTests = $curlUsageTests ?? null;
$replacements = $replacements ?? null;
$find = $find ?? false;

if (!empty($options) && (in_array('-h', $options) || in_array('--help', $options))) {
    echo <<<HELP
Check that links point to existing resources (internal or external) and that every resources is used.

Usage: {$argv[0]} [OPTIONS]
$helpDesc
HELP;
    exit(0);
}

if (!empty($options) && (in_array('-v', $options) || in_array('--verbose', $options))) {
    $verbosity = UrlTester::VERBOSITY_LOUD;
    $options = array_values(array_filter($options, function ($arg): bool {
        return !in_array($arg, ['-v', '--verbose']);
    }));
} else {
    $verbosity = UrlTester::VERBOSITY_DEFAULT;
}

$urlTester = !empty($options) ? UrlTestCommand::newUrlTesterFromCommand($options, $exclusionTests, $replacements, $find)
    : new UrlTester($usageFiles, $resourceFiles, $exclusionTests, $curlUsageTests, $replacements, $find);

$usageTestSuccess = $urlTester->testUsages(300, true, $verbosity);
$resourceTestSuccess = $urlTester->testResources($verbosity);

exit(1 * !$usageTestSuccess + 2 * !$resourceTestSuccess);
