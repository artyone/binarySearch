<?php

$start = microtime(true);

$file = new SplFileObject('input.txt', 'w');
for ($i=0; $i<10000; $i++) {
    $string = "ключ$i\tзначение$i\n";
    $file->fwrite($string);
}

$finish = microtime(true);
$delta = $finish - $start;
print $delta;