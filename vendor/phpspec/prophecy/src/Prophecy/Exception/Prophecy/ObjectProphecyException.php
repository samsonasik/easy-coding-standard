<?php

/*
 * This file is part of the Prophecy.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *     Marcello Duarte <marcello.duarte@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210804\Prophecy\Exception\Prophecy;

use ECSPrefix20210804\Prophecy\Prophecy\ObjectProphecy;
class ObjectProphecyException extends \RuntimeException implements \ECSPrefix20210804\Prophecy\Exception\Prophecy\ProphecyException
{
    private $objectProphecy;
    public function __construct($message, \ECSPrefix20210804\Prophecy\Prophecy\ObjectProphecy $objectProphecy)
    {
        parent::__construct($message);
        $this->objectProphecy = $objectProphecy;
    }
    /**
     * @return ObjectProphecy
     */
    public function getObjectProphecy()
    {
        return $this->objectProphecy;
    }
}