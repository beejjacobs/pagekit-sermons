<?php

namespace beejjacobs\Sermons\Controller;

/**
 * Class SermonController
 * @package beejjacobs\Sermons\Controller
 * @Access(admin=true)
 */
class SermonController {
  public function indexAction() {
      return [
          '$view' => [
              'title' => 'Edit Sermon',
              'name' => 'beejjacobs/sermons/views/admin/edit.php'
          ],
          'message' => 'Hello how\'s it going?'
      ];
  }
}