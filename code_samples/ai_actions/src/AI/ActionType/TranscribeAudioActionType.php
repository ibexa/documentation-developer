<?php declare(strict_types=1);

namespace App\AI\ActionType;

use App\AI\Action\TranscribeAudioAction;
use App\AI\DataType\Audio;
use Ibexa\Contracts\ConnectorAi\Action\DataType\Text;
use Ibexa\Contracts\ConnectorAi\ActionInterface;
use Ibexa\Contracts\ConnectorAi\ActionType\ActionTypeInterface;
use Ibexa\Contracts\ConnectorAi\DataType;
use Ibexa\Contracts\Core\Exception\InvalidArgumentException;

final class TranscribeAudioActionType implements ActionTypeInterface
{
    public const IDENTIFIER = 'transcribe_audio';

    /** @var iterable<\Ibexa\Contracts\ConnectorAi\Action\ActionHandlerInterface> */
    private iterable $actionHandlers;

    /** @param iterable<\Ibexa\Contracts\ConnectorAi\Action\ActionHandlerInterface> $actionHandlers*/
    public function __construct(iterable $actionHandlers)
    {
        $this->actionHandlers = $actionHandlers;
    }

    public function getIdentifier(): string
    {
        return self::IDENTIFIER;
    }

    public function getName(): string
    {
        return 'Transcribe audio';
    }

    public function getInputIdentifier(): string
    {
        return Audio::getIdentifier();
    }

    public function getOutputIdentifier(): string
    {
        return Text::getIdentifier();
    }

    public function getOptions(): array
    {
        return [];
    }

    public function createAction(DataType $input, array $parameters = []): ActionInterface
    {
        if (!$input instanceof Audio) {
            throw new InvalidArgumentException(
                'audio',
                'expected \App\AI\DataType\Audio type, ' . get_debug_type($input) . ' given.'
            );
        }

        return new TranscribeAudioAction($input);
    }

    public function getActionHandlers(): iterable
    {
        return $this->actionHandlers;
    }
}
