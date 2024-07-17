<?php

/**
 * Transform a unified diff between two code_sample_usage.php outputs into a side-by-side HTML table.
 *
 * source_length=`wc -l < $HOME/code_samples_usage_source.txt`
 * target_length=`wc -l < $HOME/code_samples_usage_target.txt`
 * diff -U $(( source_length > target_length ? source_length : target_length )) $HOME/code_samples_usage_target.txt $HOME/code_samples_usage_source.txt > $HOME/code_samples_usage.diff
 * php tools/code_samples/code_sample_usage_diff2html.php $HOME/code_samples_usage.diff > code_samples_usage.diff.html
 */

$diffFile = $argv[1];
echo "?? $diffFile !!";

$diffFileContents = file($diffFile, FILE_IGNORE_NEW_LINES);

//echo '<meta charset="UTF-8">';
echo '<table>';
echo '<thead>';
echo '<tr>';
echo '<th scope="col">Before on target branch</th>';
echo '<th scope="col">After in current PR</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';
echo '<tr>';

$previousStatusChar = '';
$leftTargetBlock = '';
$rightSourceBlock = '';
foreach ($diffFileContents as $diffLineIndex => $diffLine) {
    if (3 > $diffLineIndex) {
        // Skip metadata
        continue;
    }
    $diffLine = str_replace('`', '\`', $diffLine);
    $statusChar = strlen($diffLine) ? $diffLine[0] : '';
    $realLine = $str = substr($diffLine, 1);
    if ($previousStatusChar !== $statusChar) {
        switch ("$previousStatusChar$statusChar") {
            case ' +':
            case ' -':
            case '+':
            case '-':
            case '+ ':
            case '- ':
                echo "<td><pre>$leftTargetBlock</pre></td><td><pre>$rightSourceBlock</pre></td>";
                $leftTargetBlock = '';
                $rightSourceBlock = '';
                echo '</tr><tr>';
                break;
            case ' ':
            case '-+':
            case '+-':
                break;
            default:
                throw new \RuntimeException("Unknown leading status characters transition: '$previousStatusChar$statusChar'");
        }
    }
    switch ($statusChar) {
        case ' ':
            $leftTargetBlock .= "$realLine\n";
            $rightSourceBlock .= "$realLine\n";
            break;
        case '-':
            $leftTargetBlock .= "$realLine\n";
            break;
        case '+':
            $rightSourceBlock .= "$realLine\n";
            break;
        case '':
            $leftTargetBlock .= "\n";
            $rightSourceBlock .= "\n";
            break;
        default:
            throw new \RuntimeException("Unknown leading status character: '$statusChar'");
    }
    $previousStatusChar = $statusChar;
}

echo '</tr>';
echo '</tbody>';
echo '</table>';
echo PHP_EOL;
