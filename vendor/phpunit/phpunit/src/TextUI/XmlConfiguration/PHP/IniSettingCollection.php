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
namespace ECSPrefix20210804\PHPUnit\TextUI\XmlConfiguration;

use function count;
use Countable;
use IteratorAggregate;
/**
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 * @psalm-immutable
 */
final class IniSettingCollection implements \Countable, \IteratorAggregate
{
    /**
     * @var IniSetting[]
     */
    private $iniSettings;
    /**
     * @param IniSetting[] $iniSettings
     */
    public static function fromArray(array $iniSettings) : self
    {
        return new self(...$iniSettings);
    }
    private function __construct(\ECSPrefix20210804\PHPUnit\TextUI\XmlConfiguration\IniSetting ...$iniSettings)
    {
        $this->iniSettings = $iniSettings;
    }
    /**
     * @return IniSetting[]
     */
    public function asArray() : array
    {
        return $this->iniSettings;
    }
    public function count() : int
    {
        return \count($this->iniSettings);
    }
    public function getIterator() : \ECSPrefix20210804\PHPUnit\TextUI\XmlConfiguration\IniSettingCollectionIterator
    {
        return new \ECSPrefix20210804\PHPUnit\TextUI\XmlConfiguration\IniSettingCollectionIterator($this);
    }
}