<?php

namespace beejjacobs\Sermons\Controller;

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
      return [
          '$view' => [
              'title' => 'Edit Sermon',
              'name' => 'beejjacobs/sermons/views/admin/edit.php'
          ],
          'id' => $id
      ];
  }
}