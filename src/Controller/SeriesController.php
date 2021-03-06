<?php


namespace beejjacobs\Sermons\Controller;

use beejjacobs\Sermons\Model\Series;

/**
 * Class SeriesController
 * @package beejjacobs\Sermons\Controller
 * @Access(admin=true)
 * @Route("/series", name="series", methods="GET")
 */
class SeriesController {
  /**
   * @return array
   */
  public function indexAction() {
    return [
        '$view' => [
            'title' => __('Sermon Series'),
            'name' => 'sermons/admin/series.php'
        ]
    ];
  }
}
