<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210618\Symfony\Component\DependencyInjection\Attribute;

/**
 * An attribute to tell under which index and priority a service class should be found in tagged iterators/locators.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 * @Attribute
 */
class AsTaggedItem
{
    /**
     * @var string|null
     */
    public $index;
    /**
     * @var int|null
     */
    public $priority;
    /**
     * @param string|null $index
     * @param int|null $priority
     */
    public function __construct($index = null, $priority = null)
    {
        $this->index = $index;
        $this->priority = $priority;
    }
}
