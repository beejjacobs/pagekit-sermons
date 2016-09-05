<?php

use Pagekit\Application;

return [

    'name' => 'beejjacobs/sermons',

    'type' => 'extension',

    'main' => function (Application $app) {
      //todo: initialisation
    },

    'autoload' => [
        'beejjacobs\\Sermons\\' => 'src'
    ],

    'routes' => [
        '@sermons' => [
            'path' => '/sermons',
            'controller' => 'beejjacobs\\Sermons\\Controller\\SermonsController'
        ]
    ],

    'menu' => [
        'sermons' => [
            'label' => 'Sermons',
            'icon' => 'packages/beejjacobs/sermons/assets/menu-icon.svg',
            'url' => '@sermons'
        ]
    ],

    'resources' => [
        'beejjacobs/sermons' => ''
    ]
];