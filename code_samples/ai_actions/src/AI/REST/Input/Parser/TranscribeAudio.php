<?php declare(strict_types=1);

namespace App\AI\REST\Input\Parser;

use App\AI\DataType\Audio as AudioDataType;
use App\AI\REST\Value\TranscribeAudioAction;
use Ibexa\ConnectorAi\REST\Input\Parser\Action;
use Ibexa\Contracts\Rest\Input\ParsingDispatcher;

final class TranscribeAudio extends Action
{
    public const AUDIO_KEY = 'Audio';
    public const BASE64_KEY = 'base64';

    public function parse(array $data, ParsingDispatcher $parsingDispatcher): TranscribeAudioAction
    {
        $this->assertInputIsValid($data);
        $runtimeContext = $this->getRuntimeContext($data);

        return new TranscribeAudioAction(
            new AudioDataType([$data[self::AUDIO_KEY][self::BASE64_KEY]]),
            $runtimeContext
        );
    }

    /** @param array<mixed> $data */
    private function assertInputIsValid(array $data): void
    {
        if (!array_key_exists(self::AUDIO_KEY, $data)) {
            throw new \InvalidArgumentException('Missing audio key');
        }

        if (!array_key_exists(self::BASE64_KEY, $data[self::AUDIO_KEY])) {
            throw new \InvalidArgumentException('Missing base64 key');
        }
    }
}
