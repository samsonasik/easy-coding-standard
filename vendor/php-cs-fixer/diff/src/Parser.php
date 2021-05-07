<?php

/*
 * This file is part of sebastian/diff.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace PhpCsFixer\Diff;

/**
 * Unified diff parser.
 */
final class Parser
{
    /**
     * @param string $string
     *
     * @return Diff[]
     */
    public function parse($string)
    {
        $lines = \preg_split('(\\r\\n|\\r|\\n)', $string);
        if (!empty($lines) && $lines[\count($lines) - 1] === '') {
            \array_pop($lines);
        }
        $lineCount = \count($lines);
        $diffs = [];
        $diff = null;
        $collected = [];
        for ($i = 0; $i < $lineCount; ++$i) {
            if (\preg_match('(^---\\s+(?P<file>\\S+))', $lines[$i], $fromMatch) && \preg_match('(^\\+\\+\\+\\s+(?P<file>\\S+))', $lines[$i + 1], $toMatch)) {
                if ($diff !== null) {
                    $this->parseFileDiff($diff, $collected);
                    $diffs[] = $diff;
                    $collected = [];
                }
                $diff = new \PhpCsFixer\Diff\Diff($fromMatch['file'], $toMatch['file']);
                ++$i;
            } else {
                if (\preg_match('/^(?:diff --git |index [\\da-f\\.]+|[+-]{3} [ab])/', $lines[$i])) {
                    continue;
                }
                $collected[] = $lines[$i];
            }
        }
        if ($diff !== null && \count($collected)) {
            $this->parseFileDiff($diff, $collected);
            $diffs[] = $diff;
        }
        return $diffs;
    }
    /**
     * @param \PhpCsFixer\Diff\Diff $diff
     */
    private function parseFileDiff($diff, array $lines)
    {
        $chunks = [];
        $chunk = null;
        foreach ($lines as $line) {
            if (\preg_match('/^@@\\s+-(?P<start>\\d+)(?:,\\s*(?P<startrange>\\d+))?\\s+\\+(?P<end>\\d+)(?:,\\s*(?P<endrange>\\d+))?\\s+@@/', $line, $match)) {
                $chunk = new \PhpCsFixer\Diff\Chunk((int) $match['start'], isset($match['startrange']) ? \max(1, (int) $match['startrange']) : 1, (int) $match['end'], isset($match['endrange']) ? \max(1, (int) $match['endrange']) : 1);
                $chunks[] = $chunk;
                $diffLines = [];
                continue;
            }
            if (\preg_match('/^(?P<type>[+ -])?(?P<line>.*)/', $line, $match)) {
                $type = \PhpCsFixer\Diff\Line::UNCHANGED;
                if ($match['type'] === '+') {
                    $type = \PhpCsFixer\Diff\Line::ADDED;
                } elseif ($match['type'] === '-') {
                    $type = \PhpCsFixer\Diff\Line::REMOVED;
                }
                $diffLines[] = new \PhpCsFixer\Diff\Line($type, $match['line']);
                if (null !== $chunk) {
                    $chunk->setLines($diffLines);
                }
            }
        }
        $diff->setChunks($chunks);
    }
}