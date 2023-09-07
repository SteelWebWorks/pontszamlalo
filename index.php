<?php

require_once 'src/bootstrap.php';
require_once __DIR__ . '/tests/TestInput.php';

use Pontszamlalo\Pontszamlalo;

try {
    $pontszamlalo = new Pontszamlalo($exampleData);
    var_dump($pontszamlalo->calculatePoints());
} catch (Exception $e) {
    echo $e->getMessage();
}
