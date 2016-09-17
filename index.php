<?php

use Pagekit\Application;

return [

    'name' => 'sermons',

    'type' => 'extension',

    'main' => 'beejjacobs\\Sermons\\SermonsModule',

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
            'active' => '@sermons(/edit)?',
            'access' => 'sermons: manage sermons'
        ],
        'sermons: series' => [
            'label' => 'Series',
            'parent' => 'sermons',
            'url' => '@sermons/series',
            'active' => '@sermons/series',
            'access' => 'sermons: manage series'
        ],
        'sermons: preachers' => [
            'label' => 'Preachers',
            'parent' => 'sermons',
            'url' => '@sermons/preachers',
            'active' => '@sermons/preachers',
            'access' => 'sermons: manage preachers'
        ]
    ],

    'resources' => [
        'beejjacobs/sermons' => ''
    ],

    'permissions' => [
        'sermons: manage sermons' => [
            'title' => 'Manage sermons'
        ],
        'sermons: manage series' => [
            'title' => 'Manage series'
        ],
        'sermons: manage preachers' => [
            'title' => 'Manage preachers'
        ],
        'sermons: manage topics' => [
            'title' => 'Manage topics'
        ]
    ]
];
