<?php

declare(strict_types=1);

use Exoticca\CodingStyle\Rules\DeclareStrictTypesFixer;
use Exoticca\CodingStyle\Rules\InlineVarTagFixer;
use Exoticca\CodingStyle\Rules\ValueObjectImportFixer;
use PhpCsFixer\Fixer\Import\FullyQualifiedStrictTypesFixer;
use PhpCsFixer\Fixer\Import\GlobalNamespaceImportFixer;
use Symplify\CodingStandard\Fixer\Strict\BlankLineAfterStrictTypesFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Option as ECS;

return ECSConfig
    ::configure()
    ->withPhpCsFixerSets(
        php80Migration: true,
        phpCsFixer: true,
    )
    ->withRules([
        FullyQualifiedStrictTypesFixer::class,
        DeclareStrictTypesFixer::class,
        InlineVarTagFixer::class,
        ValueObjectImportFixer::class,
        BlankLineAfterStrictTypesFixer::class,
    ])
    ->withConfiguredRule(
        GlobalNamespaceImportFixer::class,
        ['import_classes' => true, 'import_constants' => null, 'import_functions' => null]
    )
    ->withSpacing(
        indentation: ECS::INDENTATION_SPACES,
        lineEnding: PHP_EOL
    );
