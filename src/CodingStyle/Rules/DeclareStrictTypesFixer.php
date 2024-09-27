<?php

declare(strict_types=1);

namespace Exoticca\CodingStyle\Rules;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer as GlobalDeclareStrictTypesFixer;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;

final class DeclareStrictTypesFixer extends AbstractFixer
{
    public GlobalDeclareStrictTypesFixer $globalFixer;

    public function __construct()
    {
        parent::__construct();

        $this->globalFixer = new GlobalDeclareStrictTypesFixer();
    }

    public function getDefinition(): FixerDefinitionInterface
    {
        return $this->globalFixer->getDefinition();
    }

    public function getName(): string
    {
        return 'Exoticca/declare_strict_types';
    }

    public function getPriority(): int
    {
        return $this->globalFixer->getPriority();
    }

    public function supports(SplFileInfo $file): bool
    {
        return str_contains($file->getPath(), '/adiona/src');
    }

    public function isCandidate(Tokens $tokens): bool
    {
        return $this->globalFixer->isCandidate($tokens);
    }

    protected function applyFix(SplFileInfo $file, Tokens $tokens): void
    {
        $this->globalFixer->applyFix($file, $tokens);
    }
}
