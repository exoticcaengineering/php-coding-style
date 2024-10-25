<?php

declare(strict_types=1);

use Exoticca\CodingStyle\Rules\DeclareStrictTypesFixer;
use Exoticca\CodingStyle\Rules\InlineVarTagFixer;
use Exoticca\CodingStyle\Rules\ValueObjectImportFixer;
use PhpCsFixer\Fixer\Import\FullyQualifiedStrictTypesFixer;
use PhpCsFixer\Fixer\Import\GlobalNamespaceImportFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Option as ECS;

return ECSConfig
    ::configure()
    ->withPhpCsFixerSets(
        php80Migration: true,
        phpCsFixer: true,
    )
    ->withRules([
        DeclareStrictTypesFixer::class,
        InlineVarTagFixer::class,
        ValueObjectImportFixer::class,
    ])
    ->withConfiguredRule(
        FullyQualifiedStrictTypesFixer::class,
        ['import_symbols' => true, 'phpdoc_tags' => [
            'param',
            'phpstan-param',
            'phpstan-property',
            'phpstan-property-read',
            'phpstan-property-write',
            'phpstan-return',
            'phpstan-var',
            'property',
            'property-read',
            'property-write',
            'psalm-param',
            'psalm-property',
            'psalm-property-read',
            'psalm-property-write',
            'psalm-return',
            'psalm-var',
            'return',
            'throws',
            'var',
        ]]
    )
    ->withConfiguredRule(
        GlobalNamespaceImportFixer::class,
        ['import_classes' => true, 'import_constants' => null, 'import_functions' => null]
    )
    ->withSpacing(
        indentation: ECS::INDENTATION_SPACES,
        lineEnding: PHP_EOL
    );
