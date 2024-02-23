<?php

declare (strict_types=1);
namespace Symplify\CodingStandard\DocBlock;

use ECSPrefix202402\Nette\Utils\Strings;
use PhpCsFixer\Tokenizer\Token;
final class UselessDocBlockCleaner
{
    /**
     * @var string[]
     */
    private const CLEANING_REGEXES = [self::TODO_COMMENT_BY_PHPSTORM_REGEX, self::TODO_IMPLEMENT_METHOD_COMMENT_BY_PHPSTORM_REGEX, self::STANDALONE_COMMENT_CLASS_REGEX, self::INLINE_COMMENT_CLASS_REGEX, self::COMMENT_CONSTRUCTOR_CLASS_REGEX];
    /**
     * @see https://regex101.com/r/5fQJkz/2
     * @var string
     */
    private const TODO_IMPLEMENT_METHOD_COMMENT_BY_PHPSTORM_REGEX = '#\\/\\/ TODO: Implement .*\\(\\) method.$#';
    /**
     * @see https://regex101.com/r/zayQpv/1
     * @var string
     */
    private const TODO_COMMENT_BY_PHPSTORM_REGEX = '#\\/\\/ TODO: Change the autogenerated stub$#';
    /**
     * @see https://regex101.com/r/RzTdFH/4
     * @var string
     */
    private const STANDALONE_COMMENT_CLASS_REGEX = '#(\\/\\*{2}\\s+?)?(\\*|\\/\\/)\\s+[cC]lass\\s+[^\\s]*(\\s+\\*\\/)?$#';
    /**
     * @see https://regex101.com/r/RzTdFH/4
     * @var string
     */
    private const INLINE_COMMENT_CLASS_REGEX = '#( \\*|\\/\\/)\\s+[cC]lass\\s+(\\w+)\\n#';
    /**
     * @see https://regex101.com/r/bzbxXz/2
     * @var string
     */
    private const COMMENT_CONSTRUCTOR_CLASS_REGEX = '#^\\s{0,}(\\/\\*{2}\\s+?)?(\\*|\\/\\/)\\s+[^\\s]*\\s+[Cc]onstructor\\.?(\\s+\\*\\/)?$#';
    public function clearDocTokenContent(Token $currentToken) : string
    {
        $docContent = $currentToken->getContent();
        foreach (self::CLEANING_REGEXES as $cleaningRegex) {
            $docContent = Strings::replace($docContent, $cleaningRegex);
        }
        return $docContent;
    }
}
