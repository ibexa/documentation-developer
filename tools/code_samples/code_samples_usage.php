<?php

if ($argc) {
    $codeSampleFileList = array_slice($argv, 1);
    foreach ($codeSampleFileList as $codeSampleFile) {
        echo "\n## $codeSampleFile\n\n";
        $includingFileList = getIncludingFileList($codeSampleFile);
        foreach($includingFileList as $includingFile) {
            $blocks = getInclusionBlocks($includingFile, $codeSampleFile);
            displayBlocks($blocks, $includingFile);
        }
    }
} else {
    $includingFileList = getIncludingFileList();
    foreach($includingFileList as $includingFile) {
        $blocks = getInclusionBlocks($includingFile, $codeSampleFile);
        displayBlocks($blocks, $includingFile);
    }
}

function displayBlocks(array $docFileBlocks, string $docFilePath=null, $lineOffset=0): void
{
    if (!$docFilePath) {
        $docFilePath = '';
    }
    foreach ($docFileBlocks as $block) {
        $prefixedBlockLines = [];
        foreach ($block as $blockLineIndex => $blockLine) {
            $lineNumber=$blockLineIndex+$lineOffset;
            $prefixedBlockLines[$blockLineIndex] = "$docFilePath@$lineNumber:$blockLine";
        }
        echo implode(PHP_EOL, $prefixedBlockLines).PHP_EOL.PHP_EOL;

        $prefixedBlockContentLines = [];
        $blockContents = getBlockContents($block);
        foreach ($blockContents['contents'] as $contentLineNumber => $contentLine) {
            $prefixedBlockContentLines[] = (in_array($contentLineNumber, $blockContents['highlights']) ? '>' : '|') . $contentLine;
        }
        echo implode(PHP_EOL, $prefixedBlockContentLines).PHP_EOL.PHP_EOL;
    }
}


// FRAMEWORK

/**
 * @param string $targetBranch Branch to compare to.
 * @param string $sourceBranch Branch to compare from. By default, the current branch HEAD
 * @return array<int, string> List of file paths from code_samples/ directory.
 */
function getModifiedCodeSampleFileList(string $targetBranch='origin/master', string $sourceBranch='HEAD'): array
{
    $command = "git diff --name-only $sourceBranch..$targetBranch -- code_samples";
    exec($command, $rawModifiedCodeSampleList, $commandResultCode);
    if (0 === $commandResultCode) {
        return $rawModifiedCodeSampleList;
    }
    throw new \RuntimeException("The following Git command failed: $command");
}

/**
 * @param string $codeSampleFilePath The path from project root to an included file.
 *                                  If given, files including this one are returned.
 *                                  If null, all files including a file are returned.
 * @return array<int, string> List of file paths from docs/ directory.
 */
function getIncludingFileList(string $codeSampleFilePath=null): array
{
    $pattern = null === $codeSampleFilePath ? '= include_file' : $codeSampleFilePath;
    $command = "grep '$pattern' -Rl docs | sort";
    $rawIncludingFileList = shell_exec($command);
    if (is_string($rawIncludingFileList)) {
        return explode(PHP_EOL, trim($rawIncludingFileList));
    }
    throw new \RuntimeException("The following grep command failed: $command");
}

/**
 * @param string $docFilePath The path to the Markdown file to extract inclusion block from.
 * @param string|null $codeSampleFilePath If given, only return the blocks including this file. If null, return all inclusion blocks.
 * @return array<int, array<int, string>> List of blocks. A block is an array of consecutive lines where the key is the one-based line number.
 * @todo Create a Block class
 */
function getInclusionBlocks(string $docFilePath, string $codeSampleFilePath=null): array
{
    $pattern = null === $codeSampleFilePath ? '= include_file' : $codeSampleFilePath;

    $docFileLines = file($docFilePath, FILE_IGNORE_NEW_LINES);
    if (!$docFileLines) {
        throw new \RuntimeException("The following file can't be opened: $docFilePath");
    }
    $lineCount = count($docFileLines);

    $blocks = [];
    $blockEndingLineIndex = -1;
    foreach ($docFileLines as $includingFileLineIndex => $includingFileLine) {
        if ($includingFileLineIndex <= $blockEndingLineIndex+1) {
            continue;
        }
        if (str_contains($includingFileLine, $pattern)) {
            for ($blockStartingLineIndex=$includingFileLineIndex-1; 0<=$blockStartingLineIndex; $blockStartingLineIndex--) {
                $previousLine=$docFileLines[$blockStartingLineIndex];
                if (str_contains($previousLine, '```')) {
                    break;
                }
            }
            for ($blockEndingLineIndex=$includingFileLineIndex+1; $lineCount>$blockEndingLineIndex; $blockEndingLineIndex++) {
                $nextLine=$docFileLines[$blockEndingLineIndex];
                if (str_contains($nextLine, '```')) {
                    break;
                }
            }
            $zeroBasedBlockLines = array_slice($docFileLines, $blockStartingLineIndex, $blockEndingLineIndex - $blockStartingLineIndex + 1, true);
            $oneBasedBlockLines = [];
            foreach ($zeroBasedBlockLines as $zeroBasedIndex => $zeroBasedBlockLine) {
                $oneBasedBlockLines[$zeroBasedIndex+1] = $zeroBasedBlockLine;
            }
            $blocks[] = $oneBasedBlockLines;
        }
    }

    return $blocks;
}

/**
 * @param array<int, string> $block See {@see getInclusionBlocks()} for block definition
 * @return array<string, mixed> list of highlighted line numbers,
 *                              and list of one-based lines of code represented by the block.
 *                              ['highlights' => array<int, int>, 'contents' => <int, string>]
 */
function getBlockContents(array $block): array {
    $blockHighlightedLines = [];
    $zeroBasedBlockCodeLines = [];
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
                    $blockHighlightedLines[] = (int) $rawHighlightedLine;
                }
            }
        } elseif (str_contains($blockSourceLine, '[[= include_file')) {
            preg_match_all("@\[\[= include_file\('(?<file>[^']+)'(, (?<start>[0-9]+)(, (?<end>([0-9]+|None))(, '(?<glue>[^']+)')?)?)?\) =\]\]@", $blockSourceLine, $matches);
            $solvedLine = $blockSourceLine;
            if (empty($matches['file'])) {
                throw new \RuntimeException("The following line doesn't include file correctly: $blockSourceLine");
            }
            foreach ($matches[0] as $matchIndex => $matchString) {
                $includedFilePath = $matches['file'][$matchIndex];
                if (!array_key_exists($includedFilePath, $includedFilesLines)) {
                    $includedFilesLines[$includedFilePath] = file($includedFilePath, FILE_IGNORE_NEW_LINES);
                    if (!is_array($includedFilesLines[$includedFilePath])) {
                        throw new \RuntimeException("The following included file can't be opened: $includedFilePath");
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
                $solvedLine = str_replace($matchString, implode( PHP_EOL.$matches['glue'][$matchIndex], $sample), $solvedLine);
            }
            $zeroBasedBlockCodeLines = array_merge($zeroBasedBlockCodeLines, explode(PHP_EOL, $solvedLine));
        } elseif (!str_contains($blockSourceLine, '```')) {
            $zeroBasedBlockCodeLines[] = $blockSourceLine;
        }
    }
    foreach ($zeroBasedBlockCodeLines as $zeroBasedBlockLineIndex => $zeroBasedBlockLine) {
        $oneBasedBlockCodeLines[$zeroBasedBlockLineIndex+1] = $zeroBasedBlockLine;
    }

    return [
        'highlights' => $blockHighlightedLines,
        'contents' => $oneBasedBlockCodeLines,
    ];
}
