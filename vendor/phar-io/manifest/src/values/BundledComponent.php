<?php

declare (strict_types=1);
/*
 * This file is part of PharIo\Manifest.
 *
 * (c) Arne Blankerts <arne@blankerts.de>, Sebastian Heuer <sebastian@phpeople.de>, Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210804\PharIo\Manifest;

use ECSPrefix20210804\PharIo\Version\Version;
class BundledComponent
{
    /** @var string */
    private $name;
    /** @var Version */
    private $version;
    public function __construct(string $name, \ECSPrefix20210804\PharIo\Version\Version $version)
    {
        $this->name = $name;
        $this->version = $version;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function getVersion() : \ECSPrefix20210804\PharIo\Version\Version
    {
        return $this->version;
    }
}