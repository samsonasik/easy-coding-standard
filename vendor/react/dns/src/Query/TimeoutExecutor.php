<?php

namespace ECSPrefix20210929\React\Dns\Query;

use ECSPrefix20210929\React\EventLoop\Loop;
use ECSPrefix20210929\React\EventLoop\LoopInterface;
use ECSPrefix20210929\React\Promise\Timer;
final class TimeoutExecutor implements \ECSPrefix20210929\React\Dns\Query\ExecutorInterface
{
    private $executor;
    private $loop;
    private $timeout;
    public function __construct(\ECSPrefix20210929\React\Dns\Query\ExecutorInterface $executor, $timeout, \ECSPrefix20210929\React\EventLoop\LoopInterface $loop = null)
    {
        $this->executor = $executor;
        $this->loop = $loop ?: \ECSPrefix20210929\React\EventLoop\Loop::get();
        $this->timeout = $timeout;
    }
    /**
     * @param \React\Dns\Query\Query $query
     */
    public function query($query)
    {
        return \ECSPrefix20210929\React\Promise\Timer\timeout($this->executor->query($query), $this->timeout, $this->loop)->then(null, function ($e) use($query) {
            if ($e instanceof \ECSPrefix20210929\React\Promise\Timer\TimeoutException) {
                $e = new \ECSPrefix20210929\React\Dns\Query\TimeoutException(\sprintf("DNS query for %s timed out", $query->describe()), 0, $e);
            }
            throw $e;
        });
    }
}