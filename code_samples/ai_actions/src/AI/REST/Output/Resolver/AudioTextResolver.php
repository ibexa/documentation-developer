<?php

declare(strict_types=1);

namespace App\AI\REST\Output\Resolver;

use App\AI\REST\Value\AudioText;
use Ibexa\ConnectorAi\REST\Output\ResolverInterface;
use Ibexa\Contracts\ConnectorAi\ActionResponseInterface;

final class AudioTextResolver implements ResolverInterface
{
    public function getRestValue(
        ActionResponseInterface $actionResponse
    ): AudioText {
        return new AudioText(
            $actionResponse->getOutput()
        );
    }
}
