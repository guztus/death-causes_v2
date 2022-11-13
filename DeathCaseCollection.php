<?php declare(strict_types=1);

class DeathCaseCollection
{
    private ?array $deathCases;
    private ?array $statistic = [];
    private ?array $header;
    private array $statisticsByColumns = [];
    private array $deathCauseList = [];

    public function __construct(?array ...$deathCases)
    {
        $this->deathCases = $deathCases;
    }

    public function addHeader(array $headerRow)
    {
        $this->header = $headerRow;
    }

    public function getHeader(): array
    {
        return $this->header;
    }

    public function addCases(DeathCase ...$deathCase)
    {
        $this->deathCases = array_merge($this->deathCases, $deathCase);
    }

    public function filterCases($case): array
    {
        $case = (explode(';', $case));
        return array_unique($case);
    }

    public function listAllCauses(): array
    {
        $headerId = $this->getHeader()[0];
        $headerDate = $this->getHeader()[1];
        $headerDeathCause = $this->getHeader()[2];
        $headerNonViolentCause = $this->getHeader()[3];
        $headerViolentCause = $this->getHeader()[4];
        $headerViolentCircumstances = $this->getHeader()[5];

        $deathCauseList = [];

        $deathCauseList[$headerId] = [];
        $deathCauseList[$headerDate] = [];
        $deathCauseList[$headerDeathCause] = [];
        $deathCauseList[$headerNonViolentCause] = [];
        $deathCauseList[$headerViolentCircumstances] = [];
        $deathCauseList[$headerViolentCause] = [];

        foreach ($this->deathCases as $deathCase) {

            if ($deathCase->getDeathCause() != null) {
                $deathCauseList[$headerDate] = array_merge(
                    $deathCauseList[$headerDate], $this->filterCases($deathCase->getDate())
                );
            }

            if ($deathCase->getDeathCause() != null) {
                $deathCauseList[$headerDeathCause] = array_merge(
                    $deathCauseList[$headerDeathCause], $this->filterCases($deathCase->getDeathCause())
                );
            }

            if ($deathCase->getNonViolentCause() != null) {
                $deathCauseList[$headerNonViolentCause] = array_merge(
                    $deathCauseList[$headerNonViolentCause], $this->filterCases($deathCase->getNonViolentCause())
                );
            }

            if ($deathCase->getViolentCircumstances() != null) {
                $deathCauseList[$headerViolentCircumstances] = array_merge(
                    $deathCauseList[$headerViolentCircumstances], $this->filterCases($deathCase->getViolentCircumstances())
                );
            }

            if ($deathCase->getViolentCause() != null) {
                $deathCauseList[$headerViolentCause] = array_merge(
                    $deathCauseList[$headerViolentCause], $this->filterCases($deathCase->getViolentCause())
                );
            }
        }
        $this->deathCauseList = $deathCauseList;
        return $deathCauseList;
    }

    public function createTotalStatistic(): void
    {
        foreach($this->listAllCauses() as $deathCauseCol) {
            foreach($deathCauseCol as $deathCause) {
                if (!isset($this->statistic[$deathCause])) {
                    $newValue = array(
                        $deathCause => 1,
                    );
                    $this->statistic = array_merge($this->statistic, $newValue);
                } else {
                    $this->statistic[$deathCause]++;
                }
            }
        }
    }

    public function getTotalStatistic(): ?array
    {

        $this->createTotalStatistic();
        arsort($this->statistic);
        return $this->statistic;
    }

    public function getStatisticByColumns($sortType): array
    {
        if ($sortType == 0) {
            foreach($this->listAllCauses() as $deathCauseCol) {
                $deathCauseCol = array_count_values($deathCauseCol);
                arsort($deathCauseCol);
                $this->statisticsByColumns []= $deathCauseCol;
            }
        } else {
        foreach($this->listAllCauses() as $deathCauseCol) {
            $deathCauseCol = array_count_values($deathCauseCol);
            asort($deathCauseCol);
            $this->statisticsByColumns []= $deathCauseCol;
            }
        }
        return $this->statisticsByColumns;
    }
}