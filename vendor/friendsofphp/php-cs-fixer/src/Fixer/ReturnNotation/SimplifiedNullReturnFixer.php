<?php

declare (strict_types=1);
/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace PhpCsFixer\Fixer\ReturnNotation;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\CT;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * @author Graham Campbell <hello@gjcampbell.co.uk>
 */
final class SimplifiedNullReturnFixer extends \PhpCsFixer\AbstractFixer
{
    /**
     * {@inheritdoc}
     */
    public function getDefinition() : \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
    {
        return new \PhpCsFixer\FixerDefinition\FixerDefinition('A return statement wishing to return `void` should not return `null`.', [new \PhpCsFixer\FixerDefinition\CodeSample("<?php return null;\n"), new \PhpCsFixer\FixerDefinition\CodeSample(<<<'EOT'
<?php

namespace ECSPrefix20220225;

function foo()
{
    return null;
}
function bar() : int
{
    return null;
}
function baz() : ?int
{
    return null;
}
function xyz() : void
{
    return null;
}

EOT
)]);
    }
    /**
     * {@inheritdoc}
     *
     * Must run before NoUselessReturnFixer, VoidReturnFixer.
     */
    public function getPriority() : int
    {
        return 16;
    }
    /**
     * {@inheritdoc}
     */
    public function isCandidate(\PhpCsFixer\Tokenizer\Tokens $tokens) : bool
    {
        return $tokens->isTokenKindFound(\T_RETURN);
    }
    /**
     * {@inheritdoc}
     */
    protected function applyFix(\SplFileInfo $file, \PhpCsFixer\Tokenizer\Tokens $tokens) : void
    {
        foreach ($tokens as $index => $token) {
            if (!$token->isGivenKind(\T_RETURN)) {
                continue;
            }
            if ($this->needFixing($tokens, $index)) {
                $this->clear($tokens, $index);
            }
        }
    }
    /**
     * Clear the return statement located at a given index.
     */
    private function clear(\PhpCsFixer\Tokenizer\Tokens $tokens, int $index) : void
    {
        while (!$tokens[++$index]->equals(';')) {
            if ($this->shouldClearToken($tokens, $index)) {
                $tokens->clearAt($index);
            }
        }
    }
    /**
     * Does the return statement located at a given index need fixing?
     */
    private function needFixing(\PhpCsFixer\Tokenizer\Tokens $tokens, int $index) : bool
    {
        if ($this->isStrictOrNullableReturnTypeFunction($tokens, $index)) {
            return \false;
        }
        $content = '';
        while (!$tokens[$index]->equals(';')) {
            $index = $tokens->getNextMeaningfulToken($index);
            $content .= $tokens[$index]->getContent();
        }
        $content = \ltrim($content, '(');
        $content = \rtrim($content, ');');
        return 'null' === \strtolower($content);
    }
    /**
     * Is the return within a function with a non-void or nullable return type?
     *
     * @param int $returnIndex Current return token index
     */
    private function isStrictOrNullableReturnTypeFunction(\PhpCsFixer\Tokenizer\Tokens $tokens, int $returnIndex) : bool
    {
        $functionIndex = $returnIndex;
        do {
            $functionIndex = $tokens->getPrevTokenOfKind($functionIndex, [[\T_FUNCTION]]);
            if (null === $functionIndex) {
                return \false;
            }
            $openingCurlyBraceIndex = $tokens->getNextTokenOfKind($functionIndex, ['{']);
            $closingCurlyBraceIndex = $tokens->findBlockEnd(\PhpCsFixer\Tokenizer\Tokens::BLOCK_TYPE_CURLY_BRACE, $openingCurlyBraceIndex);
        } while ($closingCurlyBraceIndex < $returnIndex);
        $possibleVoidIndex = $tokens->getPrevMeaningfulToken($openingCurlyBraceIndex);
        $isStrictReturnType = $tokens[$possibleVoidIndex]->isGivenKind(\T_STRING) && 'void' !== $tokens[$possibleVoidIndex]->getContent();
        $nullableTypeIndex = $tokens->getNextTokenOfKind($functionIndex, [[\PhpCsFixer\Tokenizer\CT::T_NULLABLE_TYPE]]);
        $isNullableReturnType = null !== $nullableTypeIndex && $nullableTypeIndex < $openingCurlyBraceIndex;
        return $isStrictReturnType || $isNullableReturnType;
    }
    /**
     * Should we clear the specific token?
     *
     * If the token is a comment, or is whitespace that is immediately before a
     * comment, then we'll leave it alone.
     */
    private function shouldClearToken(\PhpCsFixer\Tokenizer\Tokens $tokens, int $index) : bool
    {
        $token = $tokens[$index];
        return !$token->isComment() && !($token->isWhitespace() && $tokens[$index + 1]->isComment());
    }
}
