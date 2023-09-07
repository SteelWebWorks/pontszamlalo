<?php

use PHPUnit\Framework\TestCase;
use Pontszamlalo\Pontszamlalo;

require_once 'src/bootstrap.php';

class PontszamlaloTest extends TestCase
{

    private $examleDatas;

    public function setUp(): void
    {

// output: 470 (370 alappont + 100 többletpont)
        $this->examleDatas = [
            // output: 470 (370 alappont + 100 többletpont)
            'exampleData' => [
                'valasztott-szak' => [
                    'egyetem' => 'ELTE',
                    'kar' => 'IK',
                    'szak' => 'Programtervező informatikus',
                ],
                'erettsegi-eredmenyek' => [
                    [
                        'nev' => 'magyar nyelv és irodalom',
                        'tipus' => 'közép',
                        'eredmeny' => '70%',
                    ],
                    [
                        'nev' => 'történelem',
                        'tipus' => 'közép',
                        'eredmeny' => '80%',
                    ],
                    [
                        'nev' => 'matematika',
                        'tipus' => 'emelt',
                        'eredmeny' => '90%',
                    ],
                    [
                        'nev' => 'angol nyelv',
                        'tipus' => 'közép',
                        'eredmeny' => '94%',
                    ],
                    [
                        'nev' => 'informatika',
                        'tipus' => 'közép',
                        'eredmeny' => '95%',
                    ],
                ],
                'tobbletpontok' => [
                    [
                        'kategoria' => 'Nyelvvizsga',
                        'tipus' => 'B2',
                        'nyelv' => 'angol',
                    ],
                    [
                        'kategoria' => 'Nyelvvizsga',
                        'tipus' => 'C1',
                        'nyelv' => 'német',
                    ],
                ],
            ],
            // output: 476 (376 alappont + 100 többletpont)
            'exampleData1' => [
                'valasztott-szak' => [
                    'egyetem' => 'ELTE',
                    'kar' => 'IK',
                    'szak' => 'Programtervező informatikus',
                ],
                'erettsegi-eredmenyek' => [
                    [
                        'nev' => 'magyar nyelv és irodalom',
                        'tipus' => 'közép',
                        'eredmeny' => '70%',
                    ],
                    [
                        'nev' => 'történelem',
                        'tipus' => 'közép',
                        'eredmeny' => '80%',
                    ],
                    [
                        'nev' => 'matematika',
                        'tipus' => 'emelt',
                        'eredmeny' => '90%',
                    ],
                    [
                        'nev' => 'angol nyelv',
                        'tipus' => 'közép',
                        'eredmeny' => '94%',
                    ],
                    [
                        'nev' => 'informatika',
                        'tipus' => 'közép',
                        'eredmeny' => '95%',
                    ],
                    [
                        'nev' => 'fizika',
                        'tipus' => 'közép',
                        'eredmeny' => '98%',
                    ],
                ],
                'tobbletpontok' => [
                    [
                        'kategoria' => 'Nyelvvizsga',
                        'tipus' => 'B2',
                        'nyelv' => 'angol',
                    ],
                    [
                        'kategoria' => 'Nyelvvizsga',
                        'tipus' => 'C1',
                        'nyelv' => 'német',
                    ],
                ],
            ],
            // output: hiba, nem lehetséges a pontszámítás a kötelező érettségi tárgyak hiánya miatt
            'exampleData2' => [
                'valasztott-szak' => [
                    'egyetem' => 'ELTE',
                    'kar' => 'IK',
                    'szak' => 'Programtervező informatikus',
                ],
                'erettsegi-eredmenyek' => [
                    [
                        'nev' => 'matematika',
                        'tipus' => 'emelt',
                        'eredmeny' => '90%',
                    ],
                    [
                        'nev' => 'angol nyelv',
                        'tipus' => 'közép',
                        'eredmeny' => '94%',
                    ],
                    [
                        'nev' => 'informatika',
                        'tipus' => 'közép',
                        'eredmeny' => '95%',
                    ],
                ],
                'tobbletpontok' => [
                    [
                        'kategoria' => 'Nyelvvizsga',
                        'tipus' => 'B2',
                        'nyelv' => 'angol',
                    ],
                    [
                        'kategoria' => 'Nyelvvizsga',
                        'tipus' => 'C1',
                        'nyelv' => 'német',
                    ],
                ],
            ],
            // output: hiba, nem lehetséges a pontszámítás a magyar nyelv és irodalom tárgyból elért 20% alatti eredmény miatt
            'exampleData3' => [
                'valasztott-szak' => [
                    'egyetem' => 'ELTE',
                    'kar' => 'IK',
                    'szak' => 'Programtervező informatikus',
                ],
                'erettsegi-eredmenyek' => [
                    [
                        'nev' => 'magyar nyelv és irodalom',
                        'tipus' => 'közép',
                        'eredmeny' => '15%',
                    ],
                    [
                        'nev' => 'történelem',
                        'tipus' => 'közép',
                        'eredmeny' => '80%',
                    ],
                    [
                        'nev' => 'matematika',
                        'tipus' => 'emelt',
                        'eredmeny' => '90%',
                    ],
                    [
                        'nev' => 'angol nyelv',
                        'tipus' => 'közép',
                        'eredmeny' => '94%',
                    ],
                    [
                        'nev' => 'informatika',
                        'tipus' => 'közép',
                        'eredmeny' => '95%',
                    ],
                ],
                'tobbletpontok' => [
                    [
                        'kategoria' => 'Nyelvvizsga',
                        'tipus' => 'B2',
                        'nyelv' => 'angol',
                    ],
                    [
                        'kategoria' => 'Nyelvvizsga',
                        'tipus' => 'C1',
                        'nyelv' => 'német',
                    ],
                ],
            ],
            //output: hiba, nem lehetséges a pontszámítás a kötelező emelt szintű angol nyelv tárgy hiánya miatt
            'exampleData4' => [
                'valasztott-szak' => [
                    'egyetem' => 'PPKE',
                    'kar' => 'BTK',
                    'szak' => 'Anglisztika',
                ],
                'erettsegi-eredmenyek' => [
                    [
                        'nev' => 'magyar nyelv és irodalom',
                        'tipus' => 'közép',
                        'eredmeny' => '25%',
                    ],
                    [
                        'nev' => 'történelem',
                        'tipus' => 'közép',
                        'eredmeny' => '80%',
                    ],
                    [
                        'nev' => 'matematika',
                        'tipus' => 'közép',
                        'eredmeny' => '90%',
                    ],
                    [
                        'nev' => 'angol nyelv',
                        'tipus' => 'közép',
                        'eredmeny' => '94%',
                    ],
                    [
                        'nev' => 'francia',
                        'tipus' => 'közép',
                        'eredmeny' => '95%',
                    ],
                ],
                'tobbletpontok' => [
                    [
                        'kategoria' => 'Nyelvvizsga',
                        'tipus' => 'B2',
                        'nyelv' => 'angol',
                    ],
                    [
                        'kategoria' => 'Nyelvvizsga',
                        'tipus' => 'C1',
                        'nyelv' => 'német',
                    ],
                ],
            ],
            //output: hiba, nem lehetséges a pontszámítás a kötelezően választható tárgyak hiánya miatt
            'exampleData5' => [
                'valasztott-szak' => [
                    'egyetem' => 'ELTE',
                    'kar' => 'IK',
                    'szak' => 'Programtervező informatikus',
                ],
                'erettsegi-eredmenyek' => [
                    [
                        'nev' => 'magyar nyelv és irodalom',
                        'tipus' => 'közép',
                        'eredmeny' => '70%',
                    ],
                    [
                        'nev' => 'történelem',
                        'tipus' => 'közép',
                        'eredmeny' => '80%',
                    ],
                    [
                        'nev' => 'matematika',
                        'tipus' => 'emelt',
                        'eredmeny' => '90%',
                    ],
                ],
                'tobbletpontok' => [
                    [
                        'kategoria' => 'Nyelvvizsga',
                        'tipus' => 'B2',
                        'nyelv' => 'angol',
                    ],
                    [
                        'kategoria' => 'Nyelvvizsga',
                        'tipus' => 'C1',
                        'nyelv' => 'német',
                    ],
                ],
            ],
        ];
    }
    public function testValidateRequiredExams()
    {

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Hiányos kötelező érettségi tárgy(ak)!');
        $pontszamlalo = new Pontszamlalo($this->examleDatas['exampleData2']);
        $pontszamlalo->calculatePoints();

    }

    public function testValidateExamResults()
    {

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Nem teljesített érettségi tárgy(ak)!');
        $pontszamlalo = new Pontszamlalo($this->examleDatas['exampleData3']);
        $pontszamlalo->calculatePoints();
    }

    public function testValidateRequiredAdmissionExamResults()
    {

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Nem teljesített kötelező felvételi tárgy(ak)!');
        $pontszamlalo = new Pontszamlalo($this->examleDatas['exampleData4']);
        $pontszamlalo->calculatePoints();
    }

    public function testValidateRequiredOptionalExamResults()
    {

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Nem teljesített kötelezően választható tárgy(ak)!');
        $pontszamlalo = new Pontszamlalo($this->examleDatas['exampleData5']);
        $pontszamlalo->calculatePoints();
    }

    public function testCalculateBasePoints()
    {
        $pontszamlalo = new Pontszamlalo($this->examleDatas['exampleData']);
        $this->assertEquals(370, $pontszamlalo->calculatePoints());
    }
}
