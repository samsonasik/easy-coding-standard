<?php

declare (strict_types=1);
namespace ECSPrefix20210627;

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\HttpKernel\EasyCodingStandardKernel;
use Symplify\EasyCodingStandard\ValueObject\Option;
return static function (\Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator $containerConfigurator) {
    $containerConfigurator->import(__DIR__ . '/services.php');
    $containerConfigurator->import(__DIR__ . '/packages.php');
    $parameters = $containerConfigurator->parameters();
    $parameters->set(\Symplify\EasyCodingStandard\ValueObject\Option::INDENTATION, \Symplify\EasyCodingStandard\ValueObject\Option::INDENTATION_SPACES);
    $parameters->set(\Symplify\EasyCodingStandard\ValueObject\Option::LINE_ENDING, \PHP_EOL);
    $parameters->set(\Symplify\EasyCodingStandard\ValueObject\Option::CACHE_DIRECTORY, \sys_get_temp_dir() . '/changed_files_detector%env(TEST_SUFFIX)%' . \Symplify\EasyCodingStandard\HttpKernel\EasyCodingStandardKernel::CONTAINER_VERSION);
    $cacheNamespace = \str_replace(\DIRECTORY_SEPARATOR, '_', \getcwd());
    $parameters->set(\Symplify\EasyCodingStandard\ValueObject\Option::CACHE_NAMESPACE, $cacheNamespace);
    // parallel
    $parameters->set(\Symplify\EasyCodingStandard\ValueObject\Option::PARALLEL, \false);
    // how many files are processed in single process
    $parameters->set(\Symplify\EasyCodingStandard\ValueObject\Option::PARALLEL_JOB_SIZE, 60);
    $parameters->set(\Symplify\EasyCodingStandard\ValueObject\Option::SYSTEM_ERROR_COUNT_LIMIT, 50);
    $parameters->set(\Symplify\EasyCodingStandard\ValueObject\Option::PATHS, []);
    $parameters->set(\Symplify\EasyCodingStandard\ValueObject\Option::FILE_EXTENSIONS, ['php']);
    $parameters->set('env(TEST_SUFFIX)', '');
};
