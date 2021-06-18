<?php

declare (strict_types=1);
namespace ECSPrefix20210618\Symplify\PackageBuilder\Contract\HttpKernel;

use ECSPrefix20210618\Symfony\Component\HttpKernel\KernelInterface;
use ECSPrefix20210618\Symplify\SmartFileSystem\SmartFileInfo;
interface ExtraConfigAwareKernelInterface extends \ECSPrefix20210618\Symfony\Component\HttpKernel\KernelInterface
{
    /**
     * @param string[]|SmartFileInfo[] $configs
     * @return void
     */
    public function setConfigs(array $configs);
}
