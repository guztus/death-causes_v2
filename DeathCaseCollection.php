<?php

class DeathCaseCollection
{
    private ?array $deathCases;
    private ?array $statistic = [];
    private ?DeathCase $header;

    public function __construct(?array ...$deathCases)
    {
        $this->deathCases = $deathCases;
    }

    public function addHeader(DeathCase $headerRow)
    {
        $this->header = $headerRow;
    }

    public function getHeader(): DeathCase
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
        $headerId = $this->getHeader()->getId();
        $headerDate = $this->getHeader()->getDate();
        $headerDeathCause = $this->getHeader()->getDeathCause();
        $headerNonViolentCause = $this->getHeader()->getNonViolentCause();
        $headerViolentCause = $this->getHeader()->getViolentCause();
        $headerViolentCircumstances = $this->getHeader()->getViolentCircumstances();

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

    public function getStatisticByColumns()
    {
        foreach($this->listAllCauses() as $deathCauseCol) {
            foreach($deathCauseCol as $deathCause) {
                if (!isset($this->statistic[$deathCauseCol][$deathCause])) {
                    $newValue = array(
                        $deathCause => 1,
                    );
                    $this->statistic[$deathCauseCol] = array_merge($this->statistic[$deathCauseCol], $newValue);
                } else {
                    $this->statistic[$deathCauseCol][$deathCause]++;
                }
            }
        }
        return $this->statistic;
    }
}