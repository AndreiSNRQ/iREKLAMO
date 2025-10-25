<?php
$sentence = "Your long sentence or paragraph here.";
$command = 'python summarize.py ' . escapeshellarg($sentence);
$summary = shell_exec($command);
echo $summary;
?>