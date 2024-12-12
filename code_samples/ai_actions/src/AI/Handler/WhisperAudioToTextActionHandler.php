<?php

declare(strict_types=1);

namespace App\AI\Handler;

use App\AI\ActionType\TranscribeAudioActionType;
use Ibexa\Contracts\ConnectorAi\Action\ActionHandlerInterface;
use Ibexa\Contracts\ConnectorAi\Action\DataType\Text;
use Ibexa\Contracts\ConnectorAi\Action\Response\TextResponse;
use Ibexa\Contracts\ConnectorAi\ActionInterface;
use Ibexa\Contracts\ConnectorAi\ActionResponseInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

final class WhisperAudioToTextActionHandler implements ActionHandlerInterface
{
    private const TIMESTAMP_FORMAT = '/^\[\d{2}:\d{2}\.\d{3} --> \d{2}:\d{2}\.\d{3}]\s*/';

    public function supports(ActionInterface $action): bool
    {
        return $action->getActionTypeIdentifier() === TranscribeAudioActionType::IDENTIFIER;
    }

    public function handle(ActionInterface $action, array $context = []): ActionResponseInterface
    {
        /** @var \App\AI\DataType\Audio $input */
        $input = $action->getInput();

        $path = $this->saveInputToFile($input->getBase64());

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
            unlink($path);
            throw new ProcessFailedException($process);
        }

        $output = $process->getOutput();

        $includeTimestamps = $action->getActionContext()
            ?->getActionTypeOptions()
            ->get('include_timestamps', false)
            ?? false;

        if (!$includeTimestamps) {
            $output = $this->removeTimestamps($output);
        }

        unlink($path);

        return new TextResponse(new Text([$output]));
    }

    public static function getIdentifier(): string
    {
        return 'whisper_audio_to_text';
    }

    private function removeTimestamps(string $text): string
    {
        $lines = explode(PHP_EOL, $text);

        $processedLines = array_map(static function (string $line): string {
            return preg_replace(self::TIMESTAMP_FORMAT, '', $line) ?? '';
        }, $lines);

        return implode(PHP_EOL, $processedLines);
    }

    private function saveInputToFile(string $audioEncodedInBase64): string
    {
        $filename = uniqid('audio');
        $path = sys_get_temp_dir() . \DIRECTORY_SEPARATOR . $filename;
        file_put_contents($path, base64_decode($audioEncodedInBase64));

        return $path;
    }
}
