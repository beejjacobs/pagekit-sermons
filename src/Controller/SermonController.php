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
   * @Route("/add", name="add")
   */
  public function addAction() {
    return [
        '$view' => [
            'title' => __('Add Sermon'),
            'name' => 'sermons/admin/edit.php'
        ],
        'new' => true
    ];
  }

  /**
   * @Route("/edit", name="edit")
   * @Request({"id": "int"})
   * @param int $id
   * @return array
   */
  public function editAction($id = 0) {
    $toReturn = [
        '$view' => [
            'title' => __('Edit Sermon'),
            'name' => 'sermons/admin/sermon-edit.php'
        ]
    ];
    if ($id == 0) {
      $toReturn['error'] = __('Sermon id not set');
      return $toReturn;
    }

    $sermon = Sermon::query()->related(Sermon::SERMON_SERIES)->where('id = ?', [$id])->first();

    if($sermon == null) {
      $toReturn['error'] = __('Sermon not found');
      return $toReturn;
    }

    $toReturn['sermon'] = $sermon;

    return $toReturn;
  }
}
