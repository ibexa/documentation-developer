<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Collaboration\Cart;

use Ibexa\Contracts\Collaboration\Session\SessionScopeInterface;

final class CartSessionType implements SessionScopeInterface
{
    public const SCOPE_VIEW = 'view';
    public const SCOPE_EDIT = 'edit';

    public const IDENTIFIER = 'cart';

    private function __construct()
    {
        // This class is not intended to be instantiated
    }

    public function getDefaultScope(): string
    {
        return self::SCOPE_VIEW;
    }

    public function isValidScope(string $scope): bool
    {
        return in_array($scope, $this->getScopes(), true);
    }

    public function getScopes(): array
    {
        return [
            self::SCOPE_VIEW,
            self::SCOPE_EDIT,
        ];
    }
}
