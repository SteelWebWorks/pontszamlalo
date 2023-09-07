<?php

namespace Pontszamlalo;

use InvalidArgumentException;
use Pontszamlalo\ExamValidation;

class Pontszamlalo
{

    private $targetCourse;

    private $examResults;

    private $extraPoints;

    private $resultsToCalculate;

    public function __construct(array $data)
    {
        $this->targetCourse = $data['valasztott-szak'];
        $this->examResults = $data['erettsegi-eredmenyek'];
        $this->extraPoints = $data['tobbletpontok'];

        $this->validate();
        $this->calculatePoints();
    }

    public function calculatePoints()
    {
        $points = $this->calculateBasePoints();

        return $points;
    }

    private function calculateBasePoints()
    {
        $result = 0;
        // Base Result
        foreach ($this->resultsToCalculate as $resultToCalculate) {
            $result += ExamValidation::convertResultToInt($resultToCalculate['eredmeny']);
        }
        $result *= 2;
        return $result;
    }

    private function filterExtraPointsByLanguae()
    {

        $languageExams = [];
        foreach ($this->extraPoints as $extraPoint) {
            if ($languageExams[$extraPoint['kategoria']] == 'Nyelvvizsga') {
                if (empty($languageExams[$extraPoint['nyelv']])) {
                    $languageExams[$extraPoint['nyelv']] = [];
                } else {
                    array_push($languageExams[$extraPoint['nyelv']], $extraPoint);
                }
            }
        }
        return $languageExams;
    }

    private function validate()
    {
        if (!ExamValidation::validateRequired($this->examResults)) {
            throw new InvalidArgumentException('Hiányos kötelező érettségi tárgy(ak)!');
        };

        if (!ExamValidation::validateExamResults($this->examResults)) {
            throw new InvalidArgumentException('Nem teljesített érettségi tárgy(ak)!');
        }

        if (false === ($this->resultsToCalculate[] = ExamValidation::validateRequiredExamByUniversities($this->examResults, $this->targetCourse))) {
            throw new InvalidArgumentException('Nem teljesített kötelező felvételi tárgy(ak)!');
        }

        if (false === ($this->resultsToCalculate[] = ExamValidation::validateOptionalExams($this->examResults, $this->targetCourse))) {
            throw new InvalidArgumentException('Nem teljesített kötelezően választható tárgy(ak)!');
        }

    }
}
