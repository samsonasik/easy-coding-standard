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
namespace ECSPrefix20210804\PHPUnit\Framework\MockObject\Rule;

use function count;
use ECSPrefix20210804\PHPUnit\Framework\MockObject\Invocation as BaseInvocation;
use ECSPrefix20210804\PHPUnit\Framework\MockObject\Verifiable;
use ECSPrefix20210804\PHPUnit\Framework\SelfDescribing;
/**
 * @internal This class is not covered by the backward compatibility promise for PHPUnit
 */
abstract class InvocationOrder implements \ECSPrefix20210804\PHPUnit\Framework\SelfDescribing, \ECSPrefix20210804\PHPUnit\Framework\MockObject\Verifiable
{
    /**
     * @var BaseInvocation[]
     */
    private $invocations = [];
    public function getInvocationCount() : int
    {
        return \count($this->invocations);
    }
    public function hasBeenInvoked() : bool
    {
        return \count($this->invocations) > 0;
    }
    public final function invoked(\ECSPrefix20210804\PHPUnit\Framework\MockObject\Invocation $invocation)
    {
        $this->invocations[] = $invocation;
        return $this->invokedDo($invocation);
    }
    public abstract function matches(\ECSPrefix20210804\PHPUnit\Framework\MockObject\Invocation $invocation) : bool;
    protected abstract function invokedDo(\ECSPrefix20210804\PHPUnit\Framework\MockObject\Invocation $invocation);
}