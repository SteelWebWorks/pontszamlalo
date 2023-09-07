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

    private $calculatedBasePoints = 0;

    private $calculatedExtraPoints = 0;

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
        $this->calculateBasePoints();
        $this->calculateExtraPointsByLanguae();

        if ($this->calculatedExtraPoints > 100) {
            $this->calculatedExtraPoints = 100;
        }

        $finalPoints = $this->calculatedBasePoints + $this->calculatedExtraPoints;

        return "A felvételiző pontszáma: {$finalPoints} pont ({$this->calculatedBasePoints} + {$this->calculatedExtraPoints})";
    }

    private function calculateBasePoints()
    {

        // Base Result
        foreach ($this->resultsToCalculate as $resultToCalculate) {
            $this->calculatedBasePoints += ExamValidation::convertResultToInt($resultToCalculate['eredmeny']);
            if ($resultToCalculate['tipus'] == 'emelt') {
                $this->calculatedExtraPoints += 50;
            }
        }
        $this->calculatedBasePoints *= 2;

    }

    private function calculateExtraPointsByLanguae()
    {

        $languageExams = [];
        foreach ($this->extraPoints as $extraPoint) {
            if ($extraPoint['kategoria'] == 'Nyelvvizsga') {
                if (empty($languageExams[$extraPoint['nyelv']]) || ($languageExams[$extraPoint['nyelv']]['tipus'] == 'B2' && $extraPoint['tipus'] == 'C1')) {
                    $languageExams[$extraPoint['nyelv']] = $extraPoint['tipus'];
                }
            }
        }

        foreach ($languageExams as $languageExam) {
            if ($languageExam == 'B2') {
                $this->calculatedExtraPoints += 28;
            } else {
                $this->calculatedExtraPoints += 40;
            }
        }

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
