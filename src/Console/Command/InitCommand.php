<?php

declare (strict_types=1);
namespace Symplify\EasyCodingStandard\Console\Command;

use ECSPrefix20210607\Symfony\Component\Console\Input\InputInterface;
use ECSPrefix20210607\Symfony\Component\Console\Output\OutputInterface;
use ECSPrefix20210607\Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand;
use ECSPrefix20210607\Symplify\PackageBuilder\Console\ShellCode;
final class InitCommand extends \ECSPrefix20210607\Symplify\PackageBuilder\Console\Command\AbstractSymplifyCommand
{
    /**
     * @return void
     */
    protected function configure()
    {
        $this->setDescription('Generate ecs.php configuration file');
    }
    protected function execute(\ECSPrefix20210607\Symfony\Component\Console\Input\InputInterface $input, \ECSPrefix20210607\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        $rectorConfigFiles = $this->smartFileSystem->exists(\getcwd() . '/ecs.php');
        if (!$rectorConfigFiles) {
            $this->smartFileSystem->copy(__DIR__ . '/../../../ecs.php.dist', \getcwd() . '/ecs.php');
            $this->symfonyStyle->success('ecs.php config file has been generated successfully');
        } else {
            $this->symfonyStyle->warning('The "ecs.php" configuration file already exists');
        }
        return \ECSPrefix20210607\Symplify\PackageBuilder\Console\ShellCode::SUCCESS;
    }
}
