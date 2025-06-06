<?php

declare(strict_types=1);

namespace App\AI\Action;

use App\AI\DataType\Audio;
use Ibexa\Contracts\ConnectorAi\Action\Action;

final class TranscribeAudioAction extends Action
{
    private Audio $audio;

    public function __construct(Audio $audio)
    {
        $this->audio = $audio;
    }

    public function getParameters(): array
    {
        return [];
    }

    public function getInput(): Audio
    {
        return $this->audio;
    }

    public function getActionTypeIdentifier(): string
    {
        return 'transcribe_audio';
    }
}
