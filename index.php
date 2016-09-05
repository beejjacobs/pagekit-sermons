<?php

use Pagekit\Application;

return [

    'name' => 'sermons',

    'type' => 'extension',

  // called when Pagekit initializes the module
    'main' => function (Application $app) {
      //todo: initialisation
    },

    'autoload' => [
        'beejjacobs\\Sermons\\' => 'src'
    ],

    'routes' => [
        '@sermons' => [
            'path' => '/sermons',
            'controller' => 'beejjacobs\\Sermons\\Controller\\SermonController'
        ]
    ],

    'menu' => [
        'sermons' => [
            'label' => 'Sermons',
            'icon' => 'packages/beejjacobs/sermons/assets/menu-icon.svg',
            'url' => '@sermons'
        ]
    ]
];