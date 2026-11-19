<?php

/*
| Catalogue manuel partagé par l’accueil et la page Nos montures.
| Pour chaque photo, complète les audiences, types et styles selon le vrai modèle.
| Valeurs admises : audiences = homme, femme, enfant, unisexe ;
| types = vue, solaire ; styles = tendance, classique, sport, moderne, vintage.
| Les champs sont des tableaux pour qu’une monture puisse avoir plusieurs tags.
*/

return [
    'filters' => [
        ['key' => 'all', 'label' => 'Toutes'],
        ['key' => 'homme', 'label' => 'Homme'],
        ['key' => 'femme', 'label' => 'Femme'],
        ['key' => 'enfant', 'label' => 'Enfant'],
        ['key' => 'unisexe', 'label' => 'Unisexe'],
        ['key' => 'vue', 'label' => 'Vue'],
        ['key' => 'solaire', 'label' => 'Solaire'],
        ['key' => 'tendance', 'label' => 'Tendance'],
        ['key' => 'classique', 'label' => 'Classique'],
        ['key' => 'sport', 'label' => 'Sport'],
        ['key' => 'moderne', 'label' => 'Moderne'],
        ['key' => 'vintage', 'label' => 'Vintage'],
    ],

    'items' => [
        [
            'name' => 'Monture de vue',
            'image' => 'monture-vue-01.jpg',
            'audiences' => [],
            'types' => ['vue'],
            'styles' => [],
            'note' => 'Confort au quotidien.',
        ],
        [
            'name' => 'Monture solaire',
            'image' => 'monture-solaire-01.jpg',
            'audiences' => [],
            'types' => ['solaire'],
            'styles' => [],
            'note' => 'Pour les journées ensoleillées.',
        ],
        [
            'name' => 'Monture enfant',
            'image' => 'monture-enfant-01.jpg',
            'audiences' => ['enfant'],
            'types' => [],
            'styles' => [],
            'note' => 'Pensée pour les plus jeunes.',
        ],
        [
            'name' => 'Monture de vue',
            'image' => 'monture-vue-02.jpg',
            'audiences' => [],
            'types' => ['vue'],
            'styles' => [],
            'note' => 'Une autre forme, un autre style.',
        ],
        [
            'name' => 'Monture 05',
            'image' => 'monture-05.jpg',
            'audiences' => [],
            'types' => [],
            'styles' => [],
            'note' => 'Essayage et disponibilité à confirmer en boutique.',
        ],
        [
            'name' => 'Monture 06',
            'image' => 'monture-06.jpg',
            'audiences' => [],
            'types' => [],
            'styles' => [],
            'note' => 'Essayage et disponibilité à confirmer en boutique.',
        ],
        [
            'name' => 'Monture 07',
            'image' => 'monture-07.jpg',
            'audiences' => [],
            'types' => [],
            'styles' => [],
            'note' => 'Essayage et disponibilité à confirmer en boutique.',
        ],
        [
            'name' => 'Monture 08',
            'image' => 'monture-08.jpg',
            'audiences' => [],
            'types' => [],
            'styles' => [],
            'note' => 'Essayage et disponibilité à confirmer en boutique.',
        ],
    ],
];
