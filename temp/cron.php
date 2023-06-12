<?php
$file = __DIR__ . DIRECTORY_SEPARATOR . 'log.txt';
//echo $file;
$f = date('md-hi-s').'.txt';
file_put_contents($f, 'cron job run at ' . date('Y-m-d H:i:s A') . PHP_EOL);
?>