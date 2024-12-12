<?php

declare(strict_types=1);

namespace App\AI\REST\Value;

use App\AI\DataType\Audio;
use Ibexa\Contracts\ConnectorAi\Action\RuntimeContext;

final class TranscribeAudioAction
{
    private Audio $input;

    private RuntimeContext $runtimeContext;

    public function __construct(
        Audio $input,
        RuntimeContext $runtimeContext
    ) {
        $this->input = $input;
        $this->runtimeContext = $runtimeContext;
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
