<?php
namespace beejjacobs\Sermons\Controller;


use beejjacobs\Sermons\Model\Sermon;
use beejjacobs\Sermons\Model\SermonBibleBooks;
use beejjacobs\Sermons\Model\SermonTopics;
use Pagekit\Application;

/**
 * Class SermonApiController
 * @package beejjacobs\Sermons\Controller
 * @Access("sermons: manage sermons")
 * @Route("sermon", name="sermon")
 */
class SermonApiController {

  /**
   * @Route("/", methods="GET")
   * @Request({"filter": "array", "page":"int"})
   * @param array $filter
   * @param int $page
   * @return mixed
   */
  public function indexAction($filter = [], $page = 0) {
    /**
     * @var string $status
     * @var string $search
     * @var string $order
     * @var string $limit
     */
    $query = Sermon::query();
    $filter = array_merge(array_fill_keys(['status', 'search', 'preacher', 'order', 'limit'], ''), $filter);

    extract($filter, EXTR_SKIP);

    if (is_numeric($status)) {
      $query->where(['status' => (int)$status]);
    }

    if ($search) {
      $query->where(function ($query) use ($search) {
        $query->orWhere(['title LIKE :search', 'slug LIKE :search'], ['search' => "%{$search}%"]);
      });
    }

    if (!preg_match('/^(date|title)\s(asc|desc)$/i', $order, $order)) {
      $order = [1 => 'date', 2 => 'desc'];
    }

    $limit = (int)$limit ?: Application::module('sermons')->config('sermons.sermons_per_page');
    $count = $query->count();
    $pages = ceil($count / $limit);
    $page = max(0, min($pages - 1, $page));

    $sermons = array_values($query->offset($page * $limit)->related(Sermon::RELATED)->limit($limit)->orderBy($order[1], $order[2])->get());

    return compact('sermons', 'pages', 'count');
  }

  /**
   * @Route("/{id}", methods="GET", requirements={"id"="\d+"})
   * @param $id
   * @return mixed
   */
  public function getAction($id) {
    return Sermon::where(compact('id'))->related(Sermon::RELATED)->first();
  }

  /**
   * @Route("/", methods="POST")
   * @Route("/{id}", methods="POST", requirements={"id"="\d+"})
   * @Request({"sermon": "array", "id": "int"}, csrf=true)
   * @param Sermon $data
   * @param int $id
   * @return array
   */
  public function saveAction($data, $id = 0) {
    if (!$id || !$sermon = Sermon::find($id)) {
      if ($id) {
        Application::abort(404, __('Post not found.'));
      }

      $sermon = Sermon::create();
    }

    if (!Application::user()->hasAccess('sermons: manage sermons')) {
      Application::abort(400, __('Access denied.'));
    }

    $sermon->save($data);

    //Create any relationships to topics
    if (is_array($data['topics'])) {
      foreach ($data['topics'] as $topic) {
        if (!SermonTopics::checkLinkExists($sermon->id, $topic['id'])) {
          SermonTopics::create(['sermon_id' => $sermon->id, 'topic_id' => $topic['id']])->save();
        }
      }
    }

    $getIds = function ($obj) {
      return $obj['id'];
    };

    //Remove any unneeded relationships
    foreach (SermonTopics::forSermon($sermon->id) as $topic) {
      if (!in_array($topic->topic_id, array_map($getIds, $data['topics']))) {
        $topic->delete();
      }
    }

    //Create any relationships to Bible books
    if (is_array($data['bible_books'])) {
      foreach ($data['bible_books'] as $bible_book) {
        error_log('Bible book:' . $bible_book['id'] . ' sermon:' . $sermon->id . PHP_EOL, 3, './error.log');
        if (!SermonBibleBooks::checkLinkExists($sermon->id, $bible_book['id'])) {
          error_log('no link' . PHP_EOL, 3, './error.log');
          SermonBibleBooks::create(['sermon_id' => $sermon->id, 'bible_book_id' => $bible_book['id']])->save();
        }
      }
    }

    //Remove any unneeded relationships
    foreach (SermonBibleBooks::forSermon($sermon->id) as $bible_book) {
      if (!in_array($bible_book->bible_book_id,  array_map($getIds, $data['bible_books']))) {
        $bible_book->delete();
      }
    }

    return ['message' => 'success', 'sermon' => $sermon];
  }

  /**
   * @Route("/{id}", methods="DELETE", requirements={"id"="\d+"})
   * @Request({"id": "int"}, csrf=true)
   * @param $id
   * @return array
   */
  public function deleteAction($id) {
    if ($sermon = Sermon::find($id)) {

      if (!Application::user()->hasAccess('sermons: manage sermons')) {
        Application::abort(400, __('Access denied.'));
      }

      $sermon->delete();
    }

    return ['message' => 'success'];
  }

  /**
   * @Route(methods="POST")
   * @Request({"ids": "int[]"}, csrf=true)
   * @param array $ids
   * @return array
   */
  public function copyAction($ids = []) {
    foreach ($ids as $id) {
      if ($sermon = Sermon::find((int)$id)) {
        if (!Application::user()->hasAccess('sermons: manage sermons')) {
          continue;
        }

        $sermon = clone $sermon;
        $sermon->id = null;
        $sermon->status = Sermon::STATUS_UNPUBLISHED;
        $sermon->title = $sermon->title . ' - ' . __('Copy');
        $sermon->date = new \DateTime();
        $sermon->save();
      }
    }

    return ['message' => 'success'];
  }

  /**
   * @Route("/bulk", methods="POST")
   * @Request({"sermons": "array"}, csrf=true)
   * @param array $sermons
   * @return array
   */
  public function bulkSaveAction($sermons = []) {
    foreach ($sermons as $data) {
      $this->saveAction($data, isset($data['id']) ? $data['id'] : 0);
    }

    return ['message' => 'success'];
  }

  /**
   * @Route("/bulk", methods="DELETE")
   * @Request({"ids": "array"}, csrf=true)
   * @param array $ids
   * @return array
   */
  public function bulkDeleteAction($ids = []) {
    foreach (array_filter($ids) as $id) {
      $this->deleteAction($id);
    }

    return ['message' => 'success'];
  }

}
