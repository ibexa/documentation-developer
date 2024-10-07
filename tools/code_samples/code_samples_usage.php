<?php

if (1 < $argc) {
    $codeSampleFileList = array_slice($argv, 1);
    foreach ($codeSampleFileList as $codeSampleFile) {
        echo "\n$codeSampleFile\n\n";
        $includingFileList = getIncludingFileList($codeSampleFile);
        foreach ($includingFileList as $includingFile) {
            $blocks = getInclusionBlocks($includingFile, $codeSampleFile);
            displayBlocks($blocks, $includingFile);
        }
    }
} else {
    $includingFileList = getIncludingFileList();
    foreach ($includingFileList as $includingFile) {
        $blocks = getInclusionBlocks($includingFile);
        displayBlocks($blocks, $includingFile);
    }
}

function displayBlocks(array $docFileBlocks, string $docFilePath = null, $lineOffset = 0): void
{
    if (!$docFilePath) {
        $docFilePath = '';
    }
    foreach ($docFileBlocks as $block) {
        $prefixedBlockLines = [];
        foreach ($block as $blockLineIndex => $blockLine) {
            $lineNumber = $blockLineIndex + $lineOffset;
            $prefixedBlockLines[$blockLineIndex] = "$docFilePath@$lineNumber:$blockLine";
        }
        echo implode(PHP_EOL, $prefixedBlockLines) . PHP_EOL . PHP_EOL;

        $prefixedBlockContentLines = [];
        try {
            $blockContents = getBlockContents($block);
            foreach ($blockContents['contents'] as $contentLineNumber => $contentLine) {
                $prefixedBlockContentLines[] = str_pad($contentLineNumber, 3, 0, STR_PAD_LEFT) . (in_array($contentLineNumber, $blockContents['highlights']) ? '⫸' : '⫶') . $contentLine;
            }
            echo implode(PHP_EOL, $prefixedBlockContentLines) . PHP_EOL . PHP_EOL;
        } catch (Exception $exception) {
            echo $exception->getMessage() . PHP_EOL . PHP_EOL;
        }
    }
}


// FRAMEWORK

/**
 * @param string $codeSampleFilePath The path from project root to an included file.
 *                                  If given, files including this one are returned.
 *                                  If null, all files including a file are returned.
 * @return array<int, string> List of file paths from docs/ directory.
 */
function getIncludingFileList(string $codeSampleFilePath = null): array
{
    $pattern = null === $codeSampleFilePath ? '= include_file' : $codeSampleFilePath;
    $pattern = escapeshellarg($pattern);
    $command = "grep $pattern -Rl docs | sort";
    exec($command, $rawIncludingFileList, $commandResultCode);
    if (0 === $commandResultCode) {
        return $rawIncludingFileList;
    }
    throw new RuntimeException("The following grep command failed: $command");
}

/**
 * @param string $docFilePath The path to the Markdown file to extract inclusion block from.
 * @param string|null $codeSampleFilePath If given, only return the blocks including this file. If null, return all inclusion blocks.
 * @return array<int, array<int, string>> List of blocks. A block is an array of consecutive lines where the key is the one-based line number.
 * @todo Create a Block class
 */
function getInclusionBlocks(string $docFilePath, string $codeSampleFilePath = null): array
{
    $pattern = null === $codeSampleFilePath ? '= include_file' : $codeSampleFilePath;

    $docFileLines = file($docFilePath, FILE_IGNORE_NEW_LINES);
    if (!$docFileLines) {
        throw new RuntimeException("The following file can't be opened: $docFilePath");
    }
    $lineCount = count($docFileLines);

    $blocks = [];
    $blockEndingLineIndex = -1;
    foreach ($docFileLines as $includingFileLineIndex => $includingFileLine) {
        if ($includingFileLineIndex <= $blockEndingLineIndex + 1) {
            continue;
        }
        if (str_contains($includingFileLine, $pattern)) {
            for ($blockStartingLineIndex = $includingFileLineIndex - 1; 0 <= $blockStartingLineIndex; $blockStartingLineIndex--) {
                $previousLine = $docFileLines[$blockStartingLineIndex];
                if (str_contains($previousLine, '```')) {
                    break;
                }
            }
            if (-1 === $blockStartingLineIndex) {
                $blockStartingLineIndex = $includingFileLineIndex;
                $blockEndingLineIndex = $includingFileLineIndex;
            } else {
                for ($blockEndingLineIndex = $includingFileLineIndex + 1; $lineCount > $blockEndingLineIndex; $blockEndingLineIndex++) {
                    $nextLine = $docFileLines[$blockEndingLineIndex];
                    if (str_contains($nextLine, '```')) {
                        break;
                    }
                }
                if ($lineCount === $blockEndingLineIndex || ('```' === $docFileLines[$blockStartingLineIndex] && false !== preg_match('@``` *(.+)@', $docFileLines[$blockEndingLineIndex]))) {
                    $blockStartingLineIndex = $includingFileLineIndex;
                    $blockEndingLineIndex = $includingFileLineIndex;
                }
            }
            $zeroBasedBlockLines = array_slice($docFileLines, $blockStartingLineIndex, $blockEndingLineIndex - $blockStartingLineIndex + 1, true);
            $oneBasedBlockLines = [];
            foreach ($zeroBasedBlockLines as $zeroBasedIndex => $zeroBasedBlockLine) {
                $oneBasedBlockLines[$zeroBasedIndex + 1] = $zeroBasedBlockLine;
            }
            $blocks[] = $oneBasedBlockLines;
        }
    }

    return $blocks;
}

/**
 * @param array<int, string> $block See {@see getInclusionBlocks()} for block definition
 * @return array<string, mixed> list of highlighted line numbers,
 *                              and trimmed list of one-based lines of code represented by the block.
 *                              ['highlights' => array<int, int>, 'contents' => <int, string>]
 */
function getBlockContents(array $block): array
{
    $blockHighlightedLines = [];
    $rawBlockCodeLines = [];
    $oneBasedBlockCodeLines = [];
    $includedFilesLines = [];
    foreach ($block as $blockSourceLine) {
        if (preg_match('@```.* hl_lines="([^"]+)"@', $blockSourceLine, $matches)) {
            $rawHighlightedLines = explode(' ', $matches[1]);
            foreach ($rawHighlightedLines as $rawHighlightedLine) {
                if (str_contains($rawHighlightedLine, '-')) {
                    $highlightedLineRange = explode('-', $rawHighlightedLine);
                    for ($l = (int)$highlightedLineRange[0]; $l <= (int)$highlightedLineRange[1]; $l++) {
                        $blockHighlightedLines[] = $l;
                    }
                } else {
                    $blockHighlightedLines[] = (int)$rawHighlightedLine;
                }
            }
        } elseif (str_contains($blockSourceLine, '[[= include_file')) {
            preg_match_all("@\[\[= include_file\('(?<file>[^']+)'(, (?<start>[0-9]+)(, (?<end>([0-9]+|None))(, '(?<glue>[^']+)')?)?)?\) =\]\]@", $blockSourceLine, $matches);
            $solvedLine = $blockSourceLine;
            if (empty($matches['file'])) {
                throw new RuntimeException("The following line doesn't include file correctly: $blockSourceLine");
            }
            foreach ($matches[0] as $matchIndex => $matchString) {
                $includedFilePath = $matches['file'][$matchIndex];
                if (!array_key_exists($includedFilePath, $includedFilesLines)) {
                    $includedFilesLines[$includedFilePath] = file($includedFilePath, FILE_IGNORE_NEW_LINES);
                    if (!is_array($includedFilesLines[$includedFilePath])) {
                        throw new RuntimeException("The following included file can't be opened: $includedFilePath");
                    }
                }
                if ('None' === $matches['end'][$matchIndex]) {
                    $matches['end'][$matchIndex] = count($includedFilesLines[$includedFilePath]);
                }
                if ('' === $matches['start'][$matchIndex]) {
                    $sample = $includedFilesLines[$includedFilePath];
                } else {
                    $sample = array_slice($includedFilesLines[$includedFilePath], (int)$matches['start'][$matchIndex], (int)$matches['end'][$matchIndex] - (int)$matches['start'][$matchIndex]);
                }
                $solvedLine = str_replace($matchString, implode(PHP_EOL . $matches['glue'][$matchIndex], $sample) . PHP_EOL, $solvedLine);
            }
            $rawBlockCodeLines = array_merge($rawBlockCodeLines, explode(PHP_EOL, $solvedLine));
        } elseif (!str_contains($blockSourceLine, '```')) {
            $rawBlockCodeLines[] = $blockSourceLine;
        }
    }
    $firstNotEmptyLineIndex = false;
    foreach ($rawBlockCodeLines as $rawBlockLineIndex => $rawBlockLine) {
        if (false === $firstNotEmptyLineIndex && !empty(trim($rawBlockLine))) {
            $firstNotEmptyLineIndex = $rawBlockLineIndex;
        }
        if (false !== $firstNotEmptyLineIndex) {
            $oneBasedBlockCodeLines[$rawBlockLineIndex - $firstNotEmptyLineIndex + 1] = $rawBlockLine;
        }
    }
    foreach (array_reverse(array_keys($oneBasedBlockCodeLines)) as $oneBasedBlockCodeLineIndex) {
        if (empty(trim($oneBasedBlockCodeLines[$oneBasedBlockCodeLineIndex]))) {
            unset($oneBasedBlockCodeLines[$oneBasedBlockCodeLineIndex]);
        } else {
            break;
        }
    }

    return [
        'highlights' => $blockHighlightedLines,
        'contents' => $oneBasedBlockCodeLines,
    ];
}
