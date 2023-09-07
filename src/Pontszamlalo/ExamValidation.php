<?php

namespace Pontszamlalo;

use Pontszamlalo\RequiredExams;

class ExamValidation
{

    public static function validateRequired($results)
    {
        $classes = array_column($results, 'nev');
        $required = array_intersect(RequiredExams::CLASSES, $classes);

        return count($required) == 3;

    }

    public static function validateExamResults($results)
    {
        foreach ($results as $result) {
            if (self::convertResultToInt($result['eredmeny']) < 20) {
                return false;
            }
        }
        return true;
    }

    public static function validateRequiredExamByUniversities($results, $targetCourse)
    {
        foreach ($results as $result) {
            $required = RequiredExams::UNIVERSITIES[$targetCourse['egyetem']][$targetCourse['kar']][$targetCourse['szak']];
            if ($result['nev'] == $required['kotelezo']['nev']) {
                if ($required['kotelezo']['szint'] == 'emelt') {
                    if ($result['tipus'] == $required['kotelezo']['szint']) {
                        return $result;
                    } else {
                        return false;
                    }
                }
                return $result;
            }
        }
        return false;
    }

    public static function validateOptionalExams($results, $targetCourse)
    {
        $return = false;
        foreach ($results as $result) {
            if (in_array($result['nev'], RequiredExams::UNIVERSITIES[$targetCourse['egyetem']][$targetCourse['kar']][$targetCourse['szak']]['valaszthato'])) {
                if (!$return) {
                    $return = $result;
                } else {
                    $return = (self::convertResultToInt($result['eredmeny']) > self::convertResultToInt($return['eredmeny'])) ? $result : $return;
                }
            }
        }
        return $return;
    }

    public static function convertResultToInt($result)
    {
        return (int) str_replace('%', '', $result);
    }
}
