<?php declare(strict_types=1);

namespace App\AutomatedTranslation;

use Ibexa\Contracts\ConnectorAi\Action\TextToText\Action;

final class TranslateAction extends Action
{
    public function getActionTypeIdentifier(): string
    {
        return 'translate';
    }
}
