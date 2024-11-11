<?php declare(strict_types=1);

namespace App\AI\DataType;

use Ibexa\Contracts\ConnectorAi\DataType;

/**
 * @implements DataType<string>
 */
final class Audio implements DataType
{
    /** @var non-empty-array<string> */
    private array $base64;

    /**
     * @param non-empty-array<string> $base64
     */
    public function __construct(array $base64)
    {
        $this->base64 = $base64;
    }

    public function getBase64(): string
    {
        return reset($this->base64);
    }

    public function getList(): array
    {
        return $this->base64;
    }

    public static function getIdentifier(): string
    {
        return 'audio';
    }
}
