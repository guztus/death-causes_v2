<?php declare(strict_types=1);

require_once "Row.php";

class Statistic
{
    private Row $header;
    private array $data = [];

    public function addData(Row ...$rows)
    {
        $this->data = array_merge($this->data, $rows);
    }

    public function addHeader(Row $headerRow)
    {
        $this->header = $headerRow;
    }

    public function getHeader(): Row
    {
        return $this->header;
    }

    public function getAllData(): array
    {
        return $this->data;
    }

    public function getTotalReportCount(): int
    {
        return count($this->data);
    }

    public function getFoundReportCount($deathCause): int
    {
        return count($this->getByDeathCause($deathCause));
    }

    private function formatText($text): string
    {
        return strtolower($text);
    }

    public function getByDeathCause(string $deathCause): array
    {
        $deathCause = trim($deathCause);
        $deathCause = " " . $deathCause;
        return array_filter($this->data, function (Row $row) use ($deathCause) {
            $deathCauseList = '  ';
            $deathCauseList .= $row->getDeathCause();
            $deathCauseList .= $row->getNonViolentCause();
            $deathCauseList .= $row->getViolentCause();
            $deathCauseList .= $row->getViolentCircumstances();
            $deathCauseList = str_replace(';', ' ', $deathCauseList);

            return strpos($this->formatText($deathCauseList), $this->formatText($deathCause));
        });
    }
}