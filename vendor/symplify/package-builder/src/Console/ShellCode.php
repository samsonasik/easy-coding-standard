<?php

declare (strict_types=1);
namespace ECSPrefix20210922\Symplify\PackageBuilder\Console;

use ECSPrefix20210922\Symfony\Component\Console\Command\Command;
/**
 * @deprecated Use symfony constants in directly
 * @see Command::FAILURE
 * @see Command::SUCCESS
 */
final class ShellCode
{
    /**
     * @var int
     *
     * @deprecated Use symfony constants in directly
     * @see Command::SUCCESS
     */
    public const SUCCESS = 0;
    /**
     * @var int
     *
     * @deprecated Use symfony constants in directly
     * @see Command::FAILURE
     */
    public const ERROR = 1;
}
