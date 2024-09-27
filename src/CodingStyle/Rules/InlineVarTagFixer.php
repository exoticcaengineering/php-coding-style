<?php

declare(strict_types=1);

namespace Exoticca\CodingStyle\Rules;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;

final class InlineVarTagFixer extends AbstractFixer
{
    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(
            'Inline `@var` tags should be included in PHPDoc annotations.',
            [
                new CodeSample(
                    <<<'PHP'
                        <?php

                        // @var string
                        $foo = $_GET['foo'];

                        // @var string $bar
                        $bar = $_GET['bar'];

                        function bat(): string {
                            // @var string
                            return $_GET['bat'];
                        }
                        PHP
                ),
            ]
        );
    }

    public function getName(): string
    {
        return 'Exoticca/inline_var_tag_fixer';
    }

    /**
     * Must run after SingleLineCommentStyleFixer.
     */
    public function getPriority(): int
    {
        return -40;
    }

    public function isCandidate(Tokens $tokens): bool
    {
        return $tokens->isAnyTokenKindsFound([T_COMMENT, T_DOC_COMMENT]);
    }

    protected function applyFix(SplFileInfo $file, Tokens $tokens): void
    {
        foreach ($tokens as $index => $token) {
            if (!$token->isGivenKind(T_COMMENT)
                && !$token->isGivenKind(T_DOC_COMMENT)) {
                continue;
            }

            $comment = $token->getContent();
            if (!str_contains($comment, '@var')
                || str_contains($comment, "\n")) {
                continue;
            }

            $content = preg_replace(
                '/
                    ^
                    (?:\#+|\/{2,}|\/\*+)
                    [ ]*
                    (@var [^@]+?)
                    [ ]*
                    (?:\*+\/)?
                    $
                /xS',
                '\1',
                trim($comment)
            );

            $fixedComment = "/** {$content} */";

            $tokens[$index] = new Token([$token->getId(), $fixedComment]);
        }
    }
}
