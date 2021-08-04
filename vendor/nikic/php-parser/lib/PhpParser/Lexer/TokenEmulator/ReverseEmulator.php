<?php

declare (strict_types=1);
namespace ECSPrefix20210804\PhpParser\Lexer\TokenEmulator;

/**
 * Reverses emulation direction of the inner emulator.
 */
final class ReverseEmulator extends \ECSPrefix20210804\PhpParser\Lexer\TokenEmulator\TokenEmulator
{
    /** @var TokenEmulator Inner emulator */
    private $emulator;
    public function __construct(\ECSPrefix20210804\PhpParser\Lexer\TokenEmulator\TokenEmulator $emulator)
    {
        $this->emulator = $emulator;
    }
    public function getPhpVersion() : string
    {
        return $this->emulator->getPhpVersion();
    }
    public function isEmulationNeeded(string $code) : bool
    {
        return $this->emulator->isEmulationNeeded($code);
    }
    public function emulate(string $code, array $tokens) : array
    {
        return $this->emulator->reverseEmulate($code, $tokens);
    }
    public function reverseEmulate(string $code, array $tokens) : array
    {
        return $this->emulator->emulate($code, $tokens);
    }
    public function preprocessCode(string $code, array &$patches) : string
    {
        return $code;
    }
}