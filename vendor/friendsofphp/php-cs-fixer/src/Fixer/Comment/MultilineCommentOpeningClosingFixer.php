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
namespace PhpCsFixer\Fixer\Comment;

use PhpCsFixer\AbstractFixer;
use PhpCsFixer\FixerDefinition\CodeSample;
use PhpCsFixer\FixerDefinition\FixerDefinition;
use PhpCsFixer\FixerDefinition\FixerDefinitionInterface;
use PhpCsFixer\Preg;
use PhpCsFixer\Tokenizer\Token;
use PhpCsFixer\Tokenizer\Tokens;
/**
 * @author Filippo Tessarotto <zoeslam@gmail.com>
 */
final class MultilineCommentOpeningClosingFixer extends \PhpCsFixer\AbstractFixer
{
    /**
     * {@inheritdoc}
     * @return \PhpCsFixer\FixerDefinition\FixerDefinitionInterface
     */
    public function getDefinition()
    {
        return new \PhpCsFixer\FixerDefinition\FixerDefinition('DocBlocks must start with two asterisks, multiline comments must start with a single asterisk, after the opening slash. Both must end with a single asterisk before the closing slash.', [new \PhpCsFixer\FixerDefinition\CodeSample(<<<'EOT'
<?php

namespace ECSPrefix20210507;

/******
 * Multiline comment with arbitrary asterisks count
 ******/
/**\
 * Multiline comment that seems a DocBlock
 */
/**
 * DocBlock with arbitrary asterisk count at the end
 **/

EOT
)]);
    }
    /**
     * {@inheritdoc}
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     * @return bool
     */
    public function isCandidate($tokens)
    {
        return $tokens->isAnyTokenKindsFound([\T_COMMENT, \T_DOC_COMMENT]);
    }
    /**
     * {@inheritdoc}
     * @return void
     * @param \SplFileInfo $file
     * @param \PhpCsFixer\Tokenizer\Tokens $tokens
     */
    protected function applyFix($file, $tokens)
    {
        foreach ($tokens as $index => $token) {
            $originalContent = $token->getContent();
            if (!$token->isGivenKind(\T_DOC_COMMENT) && !($token->isGivenKind(\T_COMMENT) && 0 === \strpos($originalContent, '/*'))) {
                continue;
            }
            $newContent = $originalContent;
            // Fix opening
            if ($token->isGivenKind(\T_COMMENT)) {
                $newContent = \PhpCsFixer\Preg::replace('/^\\/\\*{2,}(?!\\/)/', '/*', $newContent);
            }
            // Fix closing
            $newContent = \PhpCsFixer\Preg::replace('/(?<!\\/)\\*{2,}\\/$/', '*/', $newContent);
            if ($newContent !== $originalContent) {
                $tokens[$index] = new \PhpCsFixer\Tokenizer\Token([$token->getId(), $newContent]);
            }
        }
    }
}