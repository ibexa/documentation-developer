<?php declare(strict_types=1);

namespace App\AI\Handler;

use App\AI\ActionType\TranscribeAudioActionType;
use Ibexa\Contracts\ConnectorAi\Action\ActionHandlerInterface;
use Ibexa\Contracts\ConnectorAi\Action\DataType\Text;
use Ibexa\Contracts\ConnectorAi\Action\TextToText\ActionResponse;
use Ibexa\Contracts\ConnectorAi\ActionInterface;
use Ibexa\Contracts\ConnectorAi\ActionResponseInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

final class WhisperAudioToTextActionHandler implements ActionHandlerInterface
{
    public function supports(ActionInterface $action): bool
    {
        return $action->getActionTypeIdentifier() === TranscribeAudioActionType::IDENTIFIER;
    }

    public function handle(ActionInterface $action, array $context = []): ActionResponseInterface
    {
        /** @var \App\AI\DataType\Audio $input */
        $input = $action->getInput();
        $inputText = $input->getBase64();

        $filename = uniqid('audio');
        $path = sys_get_temp_dir() . \DIRECTORY_SEPARATOR . $filename;
        file_put_contents($path, base64_decode($inputText));

        $arguments = ['whisper'];

        $language = $action->getRuntimeContext()?->get('languageCode');
        if ($language !== null) {
            $arguments[] = sprintf('--language=%s', substr($language, 0, 2));
        }

        $arguments[] = '--output_format=txt';
        $arguments[] = $path;

        $process = new Process($arguments);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output = $process->getOutput();

        unlink($path);

        return new ActionResponse(new Text([$output]));
    }

    public static function getIdentifier(): string
    {
        return 'whisper_audio_to_text';
    }
}
