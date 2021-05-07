<?php

/*
 * This file is part of PHP CS Fixer.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *     Dariusz Rumiński <dariusz.ruminski@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace PhpCsFixer\Fixer\Operator;

use PhpCsFixer\Fixer\AbstractIncrementOperatorFixer;
use PhpCsFixer\Fixer\ConfigurableFixerInterface;
use PhpCsFixer\FixerConfiguration\FixerConfigurationResolver;
use PhpCsFixer\FixerConfiguration\FixerConfigurationResolverInterface;
use PhpCsFixer\FixerConfiguration\FixerOptionBuilder;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Tokenizer\CT;
use PhpCsFixer\Tokenizer\Tokens;
use PhpCsFixer\Tokenizer\TokensAnalyzer;
/**
 * @author Gregor Harlan <gharlan@web.de>
 * @author Kuba Werłos <werlos@gmail.com>
 */
final class IncrementStyleFixer extends \PhpCsFixer\Fixer\AbstractIncrementOperatorFixer implements \PhpCsFixer\Fixer\ConfigurableFixerInterface
{
    /**
     * @internal
     */
    const STYLE_PRE = 'pre';
    /**
     * @internal
     */
    const STYLE_POST = 'post';
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        return new \PhpCsFixer\FixerDefinition\FixerDefinition('Pre- or post-increment and decrement operators should be used if possible.', [new \PhpCsFixer\FixerDefinition\CodeSample("<?php\n\$a++;\n\$b--;\n"), new \PhpCsFixer\FixerDefinition\CodeSample("<?php\n++\$a;\n--\$b;\n", ['style' => self::STYLE_POST])]);
    }
    /**
     * {@inheritdoc}
     *
     * Must run after StandardizeIncrementFixer.
     * @return int
     */
    public function getPriority()
    {
        return 0;
    }
    /**
     * {@inheritdoc}
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @return bool
     */
    public function isCandidate($tokens)
    {
        return $tokens->isAnyTokenKindsFound([\T_INC, \T_DEC]);
    }
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerConfiguration\FixerConfigurationResolverInterface
     */
    protected function createConfigurationDefinition()
    {
        return new \PhpCsFixer\FixerConfiguration\FixerConfigurationResolver([(new \PhpCsFixer\FixerConfiguration\FixerOptionBuilder('style', 'Whether to use pre- or post-increment and decrement operators.'))->setAllowedValues([self::STYLE_PRE, self::STYLE_POST])->setDefault(self::STYLE_PRE)->getOption()]);
    }
    /**
     * {@inheritdoc}
     * @return void
     * @param \SplFileInfo $file
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     */
    protected function applyFix($file, $tokens)
    {
        $tokensAnalyzer = new \PhpCsFixer\Tokenizer\TokensAnalyzer($tokens);
        for ($index = $tokens->count() - 1; 0 <= $index; --$index) {
            $token = $tokens[$index];
            if (!$token->isGivenKind([\T_INC, \T_DEC])) {
                continue;
            }
            if (self::STYLE_PRE === $this->configuration['style'] && $tokensAnalyzer->isUnarySuccessorOperator($index)) {
                $nextToken = $tokens[$tokens->getNextMeaningfulToken($index)];
                if (!$nextToken->equalsAny([';', ')'])) {
                    continue;
                }
                $startIndex = $this->findStart($tokens, $index);
                $prevToken = $tokens[$tokens->getPrevMeaningfulToken($startIndex)];
                if ($prevToken->equalsAny([';', '{', '}', [\T_OPEN_TAG], ')'])) {
                    $tokens->clearAt($index);
                    $tokens->insertAt($startIndex, clone $token);
                }
            } elseif (self::STYLE_POST === $this->configuration['style'] && $tokensAnalyzer->isUnaryPredecessorOperator($index)) {
                $prevToken = $tokens[$tokens->getPrevMeaningfulToken($index)];
                if (!$prevToken->equalsAny([';', '{', '}', [\T_OPEN_TAG], ')'])) {
                    continue;
                }
                $endIndex = $this->findEnd($tokens, $index);
                $nextToken = $tokens[$tokens->getNextMeaningfulToken($endIndex)];
                if ($nextToken->equalsAny([';', ')'])) {
                    $tokens->clearAt($index);
                    $tokens->insertAt($tokens->getNextNonWhitespace($endIndex), clone $token);
                }
            }
        }
    }
    /**
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @param int $index
     * @return int
     */
    private function findEnd($tokens, $index)
    {
        $nextIndex = $tokens->getNextMeaningfulToken($index);
        $nextToken = $tokens[$nextIndex];
        while ($nextToken->equalsAny(['$', '(', '[', [\PhpCsFixer\Tokenizer\CT::T_DYNAMIC_PROP_BRACE_OPEN], [\PhpCsFixer\Tokenizer\CT::T_DYNAMIC_VAR_BRACE_OPEN], [\PhpCsFixer\Tokenizer\CT::T_ARRAY_INDEX_CURLY_BRACE_OPEN], [\T_NS_SEPARATOR], [\T_STATIC], [\T_STRING], [\T_VARIABLE]])) {
            $blockType = \PhpCsFixer\Tokenizer\Tokens::detectBlockType($nextToken);
            if (null !== $blockType) {
                $nextIndex = $tokens->findBlockEnd($blockType['type'], $nextIndex);
            }
            $index = $nextIndex;
            $nextIndex = $tokens->getNextMeaningfulToken($nextIndex);
            $nextToken = $tokens[$nextIndex];
        }
        if ($nextToken->isObjectOperator()) {
            return $this->findEnd($tokens, $nextIndex);
        }
        if ($nextToken->isGivenKind(\T_PAAMAYIM_NEKUDOTAYIM)) {
            return $this->findEnd($tokens, $tokens->getNextMeaningfulToken($nextIndex));
        }
        return $index;
    }
}