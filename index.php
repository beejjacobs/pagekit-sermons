<?php

use Pagekit\Application;

return [

    'name' => 'sermons',

    'type' => 'extension',

    'main' => function (Application $app) {
      //todo: initialisation
    },

    'autoload' => [
        'beejjacobs\\Sermons\\' => 'src'
    ],

    'routes' => [
        '/sermons' => [
            'name' => '@sermons',
            'controller' => [
                'beejjacobs\\Sermons\\Controller\\SermonsController',
                'beejjacobs\\Sermons\\Controller\\SermonController',
                'beejjacobs\\Sermons\\Controller\\SeriesController',
                'beejjacobs\\Sermons\\Controller\\PreachersController'
            ]
        ]
    ],

    'menu' => [
        'sermons' => [
            'label' => 'Sermons',
            'icon' => 'packages/beejjacobs/sermons/assets/menu-icon.svg',
            'url' => '@sermons',
            'active' => '@sermons(/*)'
        ],
        'sermons: sermons' => [
            'label' => 'Sermons',
            'parent' => 'sermons',
            'url' => '@sermons',
            'active' => '@sermons(/edit)?'
        ],
        'sermons: series' => [
            'label' => 'Series',
            'parent' => 'sermons',
            'url' => '@sermons/series',
            'active' => '@sermons/series'
        ],
        'sermons: preachers' => [
            'label' => 'Preachers',
            'parent' => 'sermons',
            'url' => '@sermons/preachers',
            'active' => '@sermons/preachers'
        ]
    ],

    'resources' => [
        'beejjacobs/sermons' => ''
    ]
];