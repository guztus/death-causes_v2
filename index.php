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

////        row limiter
//        if ($row == 100) {
//            break;
//        }
    }
    fclose($handle);
}

function displaySearchOptions() {
    echo "--- --- ---" . PHP_EOL;
    echo "0 - exit" . PHP_EOL;
    echo "1 - List all causes" . PHP_EOL;
    echo "2 - List all causes by columns" . PHP_EOL;
    echo "3 - Search a specific cause" . PHP_EOL;
    echo "--- --- ---" . PHP_EOL;
}

$statistic->createTotalStatistic();
$statistic->createStatisticByColumns(0);
$statistic->createListOfAllCases();

displaySearchOptions();

while(true) {
    $userChoice = readline();

    switch($userChoice) {
        case 0:
            exit;
        case 1:
            foreach ($statistic->getTotalStatistic() as $key => $item) {
                echo $item . " " . ucfirst($key) . PHP_EOL;
            }
            break;

        case 2:
            $i = 0;
            foreach ($statistic->getStatisticByColumns() as $column) {
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
            break;

        case 3:
            $userSearch = readline('Enter desired search: ');
            $casesFound = $statistic->searchCause($userSearch);

            echo PHP_EOL;
            echo "'{$userSearch}' was found in " . $casesFound . " cases. (from " . $statistic->getTotalCaseCount() . " total cases)" . PHP_EOL;
            echo "Approx. " . round(($casesFound / $statistic->getTotalCaseCount()) * 100) . "% of all cases" . PHP_EOL;
            echo PHP_EOL;
            break;
    }
    displaySearchOptions();
}