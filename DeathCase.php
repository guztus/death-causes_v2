<?php declare(strict_types=1);

class DeathCase
{
    private string $date;
    private string $deathCause;
    private string $nonViolentCause;
    private string $violentCircumstances;
    private string $violentCause;

    public function __construct(string $date, string $deathCause, string $nonViolentCause, string $violentCircumstances, string $violentCause)
    {
        $this->date = $date;
        $this->deathCause = $deathCause;
        $this->nonViolentCause = $nonViolentCause;
        $this->violentCircumstances = $violentCircumstances;
        $this->violentCause = $violentCause;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getDeathCause(): string
    {
        return $this->deathCause;
    }

    public function getNonViolentCause(): ?string
    {
        if (strlen($this->nonViolentCause) == 0) {
            return null;
        }
        return $this->nonViolentCause;
    }

    public function getViolentCause(): ?string
    {
        if (strlen($this->violentCause) == 0) {
            return null;
        }
        return $this->violentCause;
    }

    public function getViolentCircumstances(): ?string
    {
        if (strlen($this->violentCircumstances) == 0) {
            return null;
        }
        return $this->violentCircumstances;
    }
}