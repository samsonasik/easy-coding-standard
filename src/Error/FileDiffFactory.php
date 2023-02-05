<?php

declare (strict_types=1);
namespace Symplify\EasyCodingStandard\Error;

use PHP_CodeSniffer\Sniffs\Sniff;
use PhpCsFixer\Fixer\FixerInterface;
use Symplify\EasyCodingStandard\FileSystem\StaticRelativeFilePathHelper;
use Symplify\EasyCodingStandard\ValueObject\Error\FileDiff;
use ECSPrefix202302\Symplify\PackageBuilder\Console\Formatter\ColorConsoleDiffFormatter;
final class FileDiffFactory
{
    /**
     * @readonly
     * @var \Symplify\PackageBuilder\Console\Formatter\ColorConsoleDiffFormatter
     */
    private $colorConsoleDiffFormatter;
    public function __construct(ColorConsoleDiffFormatter $colorConsoleDiffFormatter)
    {
        $this->colorConsoleDiffFormatter = $colorConsoleDiffFormatter;
    }
    /**
     * @param array<class-string<FixerInterface|Sniff>|string> $appliedCheckers
     */
    public function createFromDiffAndAppliedCheckers(string $filePath, string $diff, array $appliedCheckers) : FileDiff
    {
        $consoleFormattedDiff = $this->colorConsoleDiffFormatter->format($diff);
        $relativeFilePath = StaticRelativeFilePathHelper::resolveFromCwd($filePath);
        return new FileDiff($relativeFilePath, $diff, $consoleFormattedDiff, $appliedCheckers);
    }
}
