<?php

$statistics = [
];

$deathCauseList = [
    'tata',
    'tata',
    'ta'
];
//array_push($statistics, ['t'] => 't');
//$deathCause = 'tasd';

foreach($deathCauseList as $deathCause ) {
    if (!isset($statistics[$deathCause])) {
        $newValue = array(
            $deathCause => 1,
        );
        $statistics = array_merge($statistics, $newValue);
    } else {
        $statistics[$deathCause]++;
    }
}
//var_dump($newValue);
var_dump($statistics);