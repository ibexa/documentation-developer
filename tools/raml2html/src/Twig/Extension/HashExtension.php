<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace EzSystems\Raml2Html\Twig\Extension;

use RuntimeException;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class HashExtension extends AbstractExtension
{
    private $hashes = [];

    public function getFunctions(): array
    {
        return [
            new TwigFunction('hash', function (string ...$values): string {
                $hash = hash('sha256', json_encode($values));

                if (isset($this->hashes[$hash])) {
                    throw new RuntimeException('Hash is generated twice for ' . json_encode($values));
                }

                $this->hashes[$hash] = $hash;

                return $hash;
            }),
        ];
    }
}
