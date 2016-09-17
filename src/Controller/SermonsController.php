<?php

namespace beejjacobs\Sermons\Controller;

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
            'title' => 'Sermons',
            'name' => 'beejjacobs/sermons/views/admin/sermons.php'
        ],
        'sermons' => Sermon::getWithRelations()
    ];
  }

  /**
   * @Access("system: access settings")
   */
  public function settingsAction() {
    return [
        '$view' => [
            'title' => __('Sermon Settings'),
            'name'  => 'beejjacobs/sermons/views/admin/settings.php'
        ],
        'config' => Application::module('sermons')->config()
    ];
  }
}
