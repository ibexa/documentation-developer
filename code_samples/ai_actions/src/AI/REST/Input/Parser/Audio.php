<?php declare(strict_types=1);

namespace App\AI\REST\Input\Parser;

use App\AI\DataType\Audio as AudioDataType;
use Ibexa\ConnectorAi\REST\Input\Parser\Action;
use Ibexa\Contracts\Rest\Input\ParsingDispatcher;

final class Audio extends Action
{
    public const BASE64_KEY = 'base64';

    public function parse(array $data, ParsingDispatcher $parsingDispatcher): AudioDataType
    {
        $data = $this->normalizeArrayInput($data, self::BASE64_KEY);

        $this->assertInputIsValid($data);

        return new AudioDataType(
            $data[self::BASE64_KEY],
        );
    }

    /** @param array<mixed> $data */
    private function assertInputIsValid(array $data): void
    {
        if (!array_key_exists(self::BASE64_KEY, $data)) {
            throw new \InvalidArgumentException('Missing base64 key');
        }
    }
}
