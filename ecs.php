<?php

declare(strict_types=1);

use Exoticca\CodingStyle;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig
    ::configure()
    ->withSets([
        CodingStyle::DEFAULT,
    ])
    ->withPaths([
        __DIR__.'/sets',
        __DIR__.'/src',
    ])
    ->withRootFiles();
