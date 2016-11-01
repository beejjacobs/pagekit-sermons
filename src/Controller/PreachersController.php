<?php


namespace beejjacobs\Sermons\Controller;

use beejjacobs\Sermons\Model\Preacher;

/**
  * @Access(admin=true)
  * @Route("/preachers", name="preachers", methods="GET")
*/
class PreachersController {
  /**
   * @return array
   */
  public function indexAction() {
    return [
        '$view' => [
            'title' => __('Preachers'),
            'name' => 'sermons/admin/preachers.php'
        ]
    ];
  }
}
