<?php declare(strict_types=1);

require_once "DeathCase.php";
require_once "DeathCaseCollection.php";

$statistic = new DeathCaseCollection();

$row = -1;
if (($handle = fopen("vtmec-causes-of-death.csv", "r")) !== false) {
    while (($data = fgetcsv($handle, 1000)) !== false) {
        $row++;
        if ($row == 0) {
//            $statistic->addHeader(new Row($data[0], $data[1], $data[2], $data[3], $data[4], $data[5]));
            continue;
        }

        $newRow = new DeathCase($data[1], $data[2], $data[3], $data[4], $data[5]);
        $statistic->addCases($newRow);

        if ($row == 1000) {
            break;
        }
    }
    fclose($handle);
}

//$statistic->createStatistic();
//var_dump($statistic->getStatistic());
//
//$statistic->listAllCauses();

var_dump($statistic->getStatistic());

//var_dump($statistic->filterCases($newRow->getViolentCircumstances()));