<?php

declare(strict_types=1);

namespace Exoticca\CodingStyle\Rules;

use Override;
use PhpCsFixer\AbstractFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer as GlobalDeclareStrictTypesFixer;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class DeclareStrictTypesFixer extends AbstractFixer
{
    private readonly GlobalDeclareStrictTypesFixer $globalFixer;

    /**
     * @psalm-suppress PossiblyUnusedMethod
     */
    public function __construct()
    {
        parent::__construct();

        $this->globalFixer = new GlobalDeclareStrictTypesFixer();
    }

    #[Override]
    public function getDefinition(): FixerDefinitionInterface
    {
        return $this->globalFixer->getDefinition();
    }

    #[Override]
    public function getName(): string
    {
        return 'Exoticca/declare_strict_types';
    }

    #[Override]
    public function getPriority(): int
    {
        return $this->globalFixer->getPriority();
    }

    #[Override]
    public function supports(SplFileInfo $file): bool
    {
        return str_contains($file->getPath(), '/adiona/src');
    }

    #[Override]
    public function isCandidate(Tokens $tokens): bool
    {
        return $this->globalFixer->isCandidate($tokens);
    }

    #[Override]
    protected function applyFix(SplFileInfo $file, Tokens $tokens): void
    {
        $this->globalFixer->applyFix($file, $tokens);
    }
}
