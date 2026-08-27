<?php

declare(strict_types=1);

namespace App\AI\REST\Value;

use App\AI\DataType\Audio;
use Ibexa\Contracts\ConnectorAi\Action\RuntimeContext;

final readonly class TranscribeAudioAction
{
    public function __construct(
        private Audio $input,
        private RuntimeContext $runtimeContext
    ) {
    }

    public function getInput(): Audio
    {
        return $this->input;
    }

    public function getRuntimeContext(): RuntimeContext
    {
        return $this->runtimeContext;
    }
}
