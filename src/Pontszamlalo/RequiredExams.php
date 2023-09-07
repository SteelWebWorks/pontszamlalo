<?php

namespace Pontszamlalo;

class RequiredExams
{
    const UNIVERSITIES = [
        'ELTE' => [
            'IK' => [
                'Programtervező informatikus' => [
                    'kotelezo' => [
                        'nev' => 'matematika',
                        'szint' => 'kozep',
                    ],
                    'valaszthato' => [
                        'biológia',
                        'fizika',
                        'informatika',
                        'kémia',
                    ],
                ],
            ],
        ],
        'PPKE' => [
            'BTK' => [
                'Anglisztika' => [
                    'kotelezo' => [
                        'nev' => 'angol',
                        'szint' => 'emelet',
                    ],
                    'valaszthato' => [
                        'francia',
                        'német',
                        'olasz',
                        'orosz',
                        'spanyol',
                        'történelem',
                    ],
                ],
            ],
        ],
    ];
    const CLASSES = [
        'magyar nyelv és irodalom',
        'történelem',
        'matematika',
    ];
}
