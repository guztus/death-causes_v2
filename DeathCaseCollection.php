<?php

class DeathCaseCollection
{
    private ?array $deathCases;
    private ?array $statistic = [];

    public function __construct(?array ...$deathCases)
    {
        $this->deathCases = $deathCases;
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
        $deathCauseList = [];
        foreach ($this->deathCases as $deathCase) {

            if ($deathCase->getDeathCause() != null) {
                $deathCauseList = array_merge(
                    $deathCauseList, $this->filterCases($deathCase->getDate())
                );
            }

            if ($deathCase->getDeathCause() != null) {
                $deathCauseList = array_merge(
                    $deathCauseList, $this->filterCases($deathCase->getDeathCause())
                );
            }

            if ($deathCase->getNonViolentCause() != null) {
                $deathCauseList = array_merge(
                    $deathCauseList, $this->filterCases($deathCase->getNonViolentCause())
                );
            }

            if ($deathCase->getViolentCause() != null) {
                $deathCauseList = array_merge(
                    $deathCauseList, $this->filterCases($deathCase->getViolentCause())
                );
            }

            if ($deathCase->getViolentCircumstances() != null) {
                $deathCauseList = array_merge(
                    $deathCauseList, $this->filterCases($deathCase->getViolentCircumstances())
                );
            }
        }
        return $deathCauseList;
    }

    public function createStatistic(): void
    {
        foreach($this->listAllCauses() as $deathCause) {
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

    public function getStatistic(): ?array
    {
        $this->createStatistic();
        return $this->statistic;
    }
}