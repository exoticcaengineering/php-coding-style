<?php

declare(strict_types=1);

namespace Exoticca\CodingStyle\Rules;

use Override;
use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\Tokens;
use SplFileInfo;

/**
 * @psalm-suppress PropertyNotSetInConstructor
 */
final class ValueObjectImportFixer extends AbstractFixer
{
    private const string CLASS_NAME_REGEX = '/\b[A-Z][a-zA-Z]+\b/S';
    private const string ALLOWED_VALUES_REGEX = '/(?:public|protected|private)\s+array\s+\$allowedValues\s=\s\[/S';

    private const array VALUE_OBJECTS_REPLACEMENTS = [
        'BoolValueObject' => 'BooleanValueObject',
        'DateTimeValueObject' => 'DateTimeValueObject',
        'EmailType' => 'EmailValueObject',
        'EnumValueObject' => 'EnumValueObject',
        'FloatValueObject' => 'FloatValueObject',
        'GenericEmailType' => 'EmailValueObject',
        'IntegerIdValueObject' => 'IdValueObject',
        'IntValueObject' => 'IntegerValueObject',
        'LimitFilterType' => 'PositiveIntegerValueObject',
        'NullableStringValueObject' => 'NullableStringValueObject',
        'PhoneNumber' => 'StringValueObject',
        'SocialLoginReferralEnum' => 'EnumValueObject',
        'SplitPaymentPercentageValueObject' => 'IntegerValueObject',
        'StringValueObject' => 'StringValueObject',
    ];

    #[Override]
    public function getDefinition(): FixerDefinitionInterface
    {
        return new FixerDefinition(
            'Replace old value objects and exceptions with new ones.',
            [
                new CodeSample(<<<'PHP'
                    <?php

                    use Exoticca\Domain\ValueObject\DateTimeValueObject;

                    new DateTimeValueObject();
                    PHP),
            ]
        );
    }

    #[Override]
    public function getName(): string
    {
        return 'Exoticca/value_object_import_fixer';
    }

    #[Override]
    public function supports(SplFileInfo $file): bool
    {
        return str_contains($file->getPath(), '/adiona/src');
    }

    #[Override]
    public function isCandidate(Tokens $tokens): bool
    {
        return true;
    }

    #[Override]
    protected function applyFix(SplFileInfo $file, Tokens $tokens): void
    {
        /** @var string $originalCode */
        $originalCode = file_get_contents($file->getPathname());

        $fixedCode = $this->replaceValueObjects($originalCode);

        if ($fixedCode !== $originalCode) {
            $tokens->setCode($fixedCode);
        }
    }

    private function replaceValueObjects(string $originalCode): string
    {
        $fixedCode = str_replace(
            search: ' Exoticca\Domain\ValueObject\\',
            replace: ' Exoticca\Shared\Domain\ValueObject\\',
            subject: $originalCode,
        );

        if ($fixedCode === $originalCode) {
            return $fixedCode;
        }

        /** @var string $fixedCode */
        $fixedCode = preg_replace_callback(
            pattern: self::CLASS_NAME_REGEX,
            callback: fn (array $matches): string => (
                self::VALUE_OBJECTS_REPLACEMENTS[$matches[0]] ?? $matches[0]
            ),
            subject: $fixedCode,
        );

        /** @var string */
        return preg_replace(
            pattern: self::ALLOWED_VALUES_REGEX,
            replacement: 'protected static array $allowedValues = [',
            subject: $fixedCode,
        );
    }
}
