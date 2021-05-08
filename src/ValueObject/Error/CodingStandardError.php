<?php

namespace Symplify\EasyCodingStandard\ValueObject\Error;

use Symplify\SmartFileSystem\SmartFileInfo;
final class CodingStandardError
{
    /**
     * @var int
     */
    private $line;
    /**
     * @var string
     */
    private $message;
    /**
     * @var string
     */
    private $checkerClass;
    /**
     * @var SmartFileInfo
     */
    private $fileInfo;
    /**
     * @param int $line
     * @param string $message
     * @param string $checkerClass
     */
    public function __construct($line, $message, $checkerClass, \Symplify\SmartFileSystem\SmartFileInfo $fileInfo)
    {
        if (\is_object($checkerClass)) {
            $checkerClass = (string) $checkerClass;
        }
        if (\is_object($message)) {
            $message = (string) $message;
        }
        $this->line = $line;
        $this->message = $message;
        $this->checkerClass = $checkerClass;
        $this->fileInfo = $fileInfo;
    }
    /**
     * @return int
     */
    public function getLine()
    {
        return $this->line;
    }
    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
    /**
     * @return string
     */
    public function getCheckerClass()
    {
        return $this->checkerClass;
    }
    /**
     * @return string
     */
    public function getFileWithLine()
    {
        return $this->getRelativeFilePathFromCwd() . ':' . $this->line;
    }
    /**
     * @return string
     */
    public function getRelativeFilePathFromCwd()
    {
        return $this->fileInfo->getRelativeFilePathFromCwd();
    }
}
