<?php

declare (strict_types=1);
/*
 * This file is part of PHPUnit.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210804\PHPUnit\TextUI\XmlConfiguration\CodeCoverage\Report;

use ECSPrefix20210804\PHPUnit\TextUI\XmlConfiguration\File;
/**
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 * @psalm-immutable
 */
final class Text
{
    /**
     * @var File
     */
    private $target;
    /**
     * @var bool
     */
    private $showUncoveredFiles;
    /**
     * @var bool
     */
    private $showOnlySummary;
    public function __construct(\ECSPrefix20210804\PHPUnit\TextUI\XmlConfiguration\File $target, bool $showUncoveredFiles, bool $showOnlySummary)
    {
        $this->target = $target;
        $this->showUncoveredFiles = $showUncoveredFiles;
        $this->showOnlySummary = $showOnlySummary;
    }
    public function target() : \ECSPrefix20210804\PHPUnit\TextUI\XmlConfiguration\File
    {
        return $this->target;
    }
    public function showUncoveredFiles() : bool
    {
        return $this->showUncoveredFiles;
    }
    public function showOnlySummary() : bool
    {
        return $this->showOnlySummary;
    }
}