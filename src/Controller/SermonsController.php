<?php

namespace beejjacobs\Sermons\Controller;

use beejjacobs\Sermons\Model\Preacher;
use beejjacobs\Sermons\Model\Sermon;
use Pagekit\Application;

/**
 * @Access(admin=true)
 */
class SermonsController {
  /**
   * @Route("/")
   * @return array
   */
  public function indexAction() {
    return [
        '$view' => [
            'title' => __('Sermons'),
            'name' => 'sermons/admin/sermons.php'
        ],
        '$data' => [
            'statuses' => Sermon::getStatuses(),
            'preachers' => Preacher::findAll()
        ]
    ];
  }

  /**
   * @Access("system: access settings")
   */
  public function settingsAction() {
    return [
        '$view' => [
            'title' => __('Sermon Settings'),
            'name'  => 'sermons/admin/settings.php'
        ],
        '$data' => [
            'config' => Application::module('sermons')->config()
        ]
    ];
  }
}
