<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix202301\Symfony\Component\Config\Definition;

use ECSPrefix202301\Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
/**
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 */
interface ConfigurableInterface
{
    /**
     * Generates the configuration tree builder.
     */
    public function configure(DefinitionConfigurator $definition) : void;
}
