<?php declare(strict_types=1);

namespace App\Connector\Dam\Handler;

use Ibexa\Contracts\Connector\Dam\Asset;
use Ibexa\Contracts\Connector\Dam\AssetCollection;
use Ibexa\Contracts\Connector\Dam\AssetIdentifier;
use Ibexa\Contracts\Connector\Dam\AssetMetadata;
use Ibexa\Contracts\Connector\Dam\AssetSource;
use Ibexa\Contracts\Connector\Dam\AssetUri;
use Ibexa\Contracts\Connector\Dam\Handler\Handler as HandlerInterface;
use Ibexa\Contracts\Connector\Dam\Search\AssetSearchResult;
use Ibexa\Contracts\Connector\Dam\Search\Query;

class WikimediaCommonsHandler implements HandlerInterface
{
    public function search(Query $query, int $offset = 0, int $limit = 20): AssetSearchResult
    {
        $searchUrl = 'https://commons.wikimedia.org/w/api.php?action=query&list=search&format=json&srnamespace=6'
            . '&srsearch=' . urlencode($query->getPhrase())
            . '&sroffset=' . $offset
            . '&srlimit=' . $limit
        ;

        $jsonResponse = file_get_contents($searchUrl);
        if ($jsonResponse === false) {
            return new AssetSearchResult(0, new AssetCollection([]));
        }

        $response = json_decode($jsonResponse, true);
        if (!isset($response['query']['search'])) {
            return new AssetSearchResult(0, new AssetCollection([]));
        }

        $assets = [];
        foreach ($response['query']['search'] as $result) {
            $identifier = str_replace('File:', '', $result['title']);
            $assets[] = $this->fetchAsset($identifier);
        }

        return new AssetSearchResult(
            (int) ($response['query']['searchinfo']['totalhits'] ?? 0),
            new AssetCollection($assets)
        );
    }

    public function fetchAsset(string $id): Asset
    {
        $metadataUrl = 'https://commons.wikimedia.org/w/api.php?action=query&prop=imageinfo&iiprop=extmetadata&format=json'
            . '&titles=File%3a' . urlencode($id)
        ;

        $jsonResponse = file_get_contents($metadataUrl);
        if ($jsonResponse === false) {
            throw new \RuntimeException('Couldn\'t retrieve asset metadata');
        }

        $response = json_decode($jsonResponse, true);
        if (!isset($response['query']['pages'])) {
            throw new \RuntimeException('Couldn\'t parse asset metadata');
        }

        $pageData = array_values($response['query']['pages'])[0] ?? null;
        if (!isset($pageData['imageinfo'][0]['extmetadata'])) {
            throw new \RuntimeException('Couldn\'t parse image asset metadata');
        }

        $imageInfo = $pageData['imageinfo'][0]['extmetadata'];

        return new Asset(
            new AssetIdentifier($id),
            new AssetSource('commons'),
            new AssetUri('https://commons.wikimedia.org/w/index.php?title=Special:Redirect/file/' . urlencode($id)),
            new AssetMetadata([
                'page_url' => "https://commons.wikimedia.org/wiki/File:$id",
                'author' => $imageInfo['Artist']['value'] ?? null,
                'license' => $imageInfo['LicenseShortName']['value'] ?? null,
                'license_url' => $imageInfo['LicenseUrl']['value'] ?? null,
            ])
        );
    }
}
