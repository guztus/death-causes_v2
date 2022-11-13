<?php declare(strict_types=1);

require_once "DeathCase.php";
require_once "DeathCaseCollection.php";

$statistic = new DeathCaseCollection();

$row = -1;
if (($handle = fopen("vtmec-causes-of-death.csv", "r")) !== false) {
    while (($data = fgetcsv($handle, 1000)) !== false) {
        $row++;
        if ($row == 0) {
            $statistic->addHeader(array($data[0], $data[1], $data[2], $data[3], $data[4], $data[5]));
            continue;
        }

        $newRow = new DeathCase($data[0], $data[1], $data[2], $data[3], $data[4], $data[5]);
        $statistic->addCases($newRow);

        if ($row == 100) {
            break;
        }
    }
    fclose($handle);
}

//$statistic->createStatistic();
//var_dump($statistic->getStatistic());
//
//$statistic->listAllCauses();

//var_dump($statistic->getStatisticByColumns(0));
function displaySearchOptions() {
    echo "0 - List all causes" . PHP_EOL;
    echo "1 - List all causes by columns" . PHP_EOL;
//    echo "2 - Search a specific cause" . PHP_EOL;
}

displaySearchOptions();
while(true) {
    $userChoice = readline();

    if ($userChoice == 0) {
        foreach ($statistic->getTotalStatistic() as $key => $item) {
            echo $item . " " . $key . PHP_EOL;
        }
    }

    if ($userChoice == 1) {
        $i = 0;
        foreach ($statistic->getStatisticByColumns(0) as $column) {
            if ($i == 0) {
                $i++;
                continue;
            }

            echo "--- --- --- --- ---" . PHP_EOL;
            echo $statistic->getHeader()[$i] . PHP_EOL;
            echo "--- --- --- --- ---" . PHP_EOL;

            if (count($column) == 0) {
                echo "** No cases **" . PHP_EOL;
            } else {
                echo "Total (" . count($column) . ")" . PHP_EOL . PHP_EOL;
                foreach ($column as $key => $deathCause) {
                    echo "* " . ucfirst($key) . " - " . $deathCause . PHP_EOL;
                }
                echo PHP_EOL;
                $i++;
            }
        }
    }
    exit;
}