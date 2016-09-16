<?php

namespace beejjacobs\Sermons\Controller;
use beejjacobs\Sermons\Model\Sermon;

/**
 * Class SermonController
 * @package beejjacobs\Sermons\Controller
 * @Access(admin=true)
 * @Route("/sermon", name="sermon")
 */
class SermonController {
  /**
   * @Route("/edit", name="edit")
   * @Request({"id": "int"})
   * @return array
   */
  public function editAction($id = 0) {
    if ($id == 0) {
      return [
          '$view' => [
              'title' => 'Edit Sermon',
              'name' => 'beejjacobs/sermons/views/admin/edit.php'
          ],
          'error' => 'Sermon id not set'
      ];
    }

    $sermon = Sermon::query()->related(Sermon::SERMON_SERIES)->where('id = ?', [$id])->first();

    if($sermon == null) {
      return [
          '$view' => [
              'title' => 'Edit Sermon',
              'name' => 'beejjacobs/sermons/views/admin/edit.php'
          ],
          'error' => 'Sermon not found'
      ];
    }

    return [
        '$view' => [
            'title' => 'Edit Sermon',
            'name' => 'beejjacobs/sermons/views/admin/edit.php'
        ],
        'sermon' => $sermon
    ];
  }
}