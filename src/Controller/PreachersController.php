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
            'title' => 'Preachers',
            'name' => 'beejjacobs/sermons/views/admin/preachers.php'
        ],
        'preachers' => Preacher::query()->related(Preacher::SERMONS)->get()
    ];
  }
}