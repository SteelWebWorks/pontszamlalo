<?php

require_once 'src/bootstrap.php';
require_once __DIR__ . '/tests/TestInput.php';

use Pontszamlalo\Pontszamlalo;

try {
    $pontszamlalo = new Pontszamlalo($exampleData);
    $pontszamlalo->calculatePoints();
    $basePoints = $pontszamlalo->getCalculatedBasePoints();
    $extraPoints = $pontszamlalo->getCalculatedExtraPoints();
    $points = $basePoints + $extraPoints;
    echo "A felvételizőnek {$points} pontja van ({$basePoints} alap pontszáma, {$extraPoints} extra pontszáma)";
} catch (Exception $e) {
    echo $e->getMessage();
}
