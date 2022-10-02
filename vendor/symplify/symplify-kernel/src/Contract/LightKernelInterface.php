<?php

declare (strict_types=1);
namespace ECSPrefix202210\Symplify\SymplifyKernel\Contract;

use ECSPrefix202210\Psr\Container\ContainerInterface;
/**
 * @api
 */
interface LightKernelInterface
{
    /**
     * @param string[] $configFiles
     */
    public function createFromConfigs(array $configFiles) : ContainerInterface;
    public function getContainer() : ContainerInterface;
}
