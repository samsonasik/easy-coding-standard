<?php

declare (strict_types=1);
namespace Symplify\EasyCodingStandard\SnippetFormatter\Command;

use ECSPrefix20210520\Symfony\Component\Console\Input\InputInterface;
use ECSPrefix20210520\Symfony\Component\Console\Output\OutputInterface;
use Symplify\EasyCodingStandard\Console\Command\AbstractCheckCommand;
use Symplify\EasyCodingStandard\SnippetFormatter\Application\SnippetFormatterApplication;
use Symplify\EasyCodingStandard\SnippetFormatter\ValueObject\SnippetPattern;
use ECSPrefix20210520\Symplify\PackageBuilder\Console\ShellCode;
final class CheckHeredocNowdocCommand extends \Symplify\EasyCodingStandard\Console\Command\AbstractCheckCommand
{
    /**
     * @var SnippetFormatterApplication
     */
    private $snippetFormatterApplication;
    public function __construct(\Symplify\EasyCodingStandard\SnippetFormatter\Application\SnippetFormatterApplication $snippetFormatterApplication)
    {
        $this->snippetFormatterApplication = $snippetFormatterApplication;
        parent::__construct();
    }
    /**
     * @return void
     */
    protected function configure()
    {
        $this->setDescription('Format Heredoc/Nowdoc PHP snippets in PHP files');
        parent::configure();
    }
    protected function execute(\ECSPrefix20210520\Symfony\Component\Console\Input\InputInterface $input, \ECSPrefix20210520\Symfony\Component\Console\Output\OutputInterface $output) : int
    {
        if (!$this->loadedCheckersGuard->areSomeCheckerRegistered()) {
            $this->loadedCheckersGuard->report();
            return \ECSPrefix20210520\Symplify\PackageBuilder\Console\ShellCode::ERROR;
        }
        $this->configuration->resolveFromInput($input);
        $sources = $this->configuration->getSources();
        $phpFileInfos = $this->smartFinder->find($sources, '*.php', ['Fixture']);
        return $this->snippetFormatterApplication->processFileInfosWithSnippetPattern($this->configuration, $phpFileInfos, \Symplify\EasyCodingStandard\SnippetFormatter\ValueObject\SnippetPattern::HERENOWDOC_SNIPPET_REGEX, 'heredocnowdox');
    }
}
