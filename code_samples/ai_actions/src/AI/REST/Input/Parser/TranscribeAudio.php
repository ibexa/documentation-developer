<?php declare(strict_types=1);

namespace App\AI\REST\Input\Parser;

use App\AI\REST\Value\TranscribeAudioAction;
use Ibexa\ConnectorAi\REST\Input\Parser\Action;
use Ibexa\Contracts\Rest\Input\ParsingDispatcher;

final class TranscribeAudio extends Action
{
    public const AUDIO_KEY = 'Audio';
    public const AUDIO_MEDIATYPE = 'application/vnd.ibexa.api.ai.Audio';

    public function parse(array $data, ParsingDispatcher $parsingDispatcher): TranscribeAudioAction
    {
        $this->assertInputIsValid($data);

        $input = $parsingDispatcher->parse(
            $data[self::AUDIO_KEY],
            self::AUDIO_MEDIATYPE
        );

        $runtimeContext = $this->getRuntimeContext($data);

        return new TranscribeAudioAction(
            $input,
            $runtimeContext
        );
    }

    /** @param array<mixed> $data */
    private function assertInputIsValid(array $data): void
    {
        if (!array_key_exists(self::AUDIO_KEY, $data)) {
            throw new \InvalidArgumentException('Missing audio key');
        }
    }
}
