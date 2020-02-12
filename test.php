<?php

$start = microtime(true);

require_once 'src/app/BinarySearch.php';
use app\BinarySearch;

for ($i=-20; $i<10020; $i++) {
    $file = new BinarySearch('input.txt', "ключ$i");
    if ($file->search() != "значение$i") {
        print "$i\n";
    }
}

$finish = microtime(true);
$delta = $finish - $start;
print $delta;

