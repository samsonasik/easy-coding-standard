<?php

declare (strict_types=1);
namespace ECSPrefix20220316\Symplify\SymplifyKernel\Tests\ContainerBuilderFactory;

use ECSPrefix20220316\PHPUnit\Framework\TestCase;
use ECSPrefix20220316\Symplify\SmartFileSystem\SmartFileSystem;
use ECSPrefix20220316\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory;
use ECSPrefix20220316\Symplify\SymplifyKernel\ContainerBuilderFactory;
final class ContainerBuilderFactoryTest extends \ECSPrefix20220316\PHPUnit\Framework\TestCase
{
    public function test() : void
    {
        $containerBuilderFactory = new \ECSPrefix20220316\Symplify\SymplifyKernel\ContainerBuilderFactory(new \ECSPrefix20220316\Symplify\SymplifyKernel\Config\Loader\ParameterMergingLoaderFactory());
        $container = $containerBuilderFactory->create([__DIR__ . '/config/some_services.php'], [], []);
        $hasSmartFileSystemService = $container->has(\ECSPrefix20220316\Symplify\SmartFileSystem\SmartFileSystem::class);
        $this->assertTrue($hasSmartFileSystemService);
    }
}