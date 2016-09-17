<?php

namespace beejjacobs\Sermons\Controller;
use beejjacobs\Sermons\Model\Topic;

/**
 * @Access(admin=true)
 * @Route("/topics", name="topics", methods="GET")
 */
class TopicsController {
  public function indexAction() {
    return [
        '$view' => [
            'title' => __('Topics'),
            'name' => 'sermons/admin/topics.php'
        ],
        'topics' => Topic::query()->related(Topic::SERMONS)->get()
    ];
  }
}
