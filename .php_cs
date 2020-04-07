<?php

$header = <<<'EOF'
@copyright Copyright (C) eZ Systems AS. All rights reserved.
@license For full copyright and license information view LICENSE file distributed with this source code.
EOF;

return return  EzSystems\EzPlatformCodeStyle\PhpCsFixer\EzPlatformInternalConfigFactory::build()
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__ . '/tests')
            ->files()->name('*.php')
    )
;
