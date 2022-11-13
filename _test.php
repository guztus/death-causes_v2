<?php

$deathCauseList = [
    'time' => [],
    'second' => [],
    'thrd' => [],
    'frth' => [],
    'fth' => [],
];
$newList = ['asasdasdasdd'];
$deathCauseList['time'] []= 'a';
$deathCauseList['second'] []= 'b';
$deathCauseList['thrd'] = array_merge($deathCauseList['thrd'], $newList);


$randomList = [
    2,
    3,
    4,
    10,
    1000,
    -1111,
    -1111,

];

//var_dump(sort($randomList));

//var_dump($deathCauseList);

var_dump(array_count_values($randomList));