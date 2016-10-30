<?php
namespace beejjacobs\Sermons\Controller;


use beejjacobs\Sermons\Model\BibleBook;
use Pagekit\Application;

/**
 * Class BibleBookApiController
 * @package beejjacobs\Sermons\Controller
 * @Route("bible-book", name="bible-book")
 */
class BibleBookApiController {

  /**
   * @Route("/", methods="GET")
   * @Request({"filter": "array", "page":"int"})
   * @param array $filter
   * @param int $page
   * @return mixed
   */
  public function indexAction($filter = [], $page = 0) {
    $query = BibleBook::query();
    $filter = array_merge(array_fill_keys(['search', 'order', 'limit'], ''), $filter);

    extract($filter, EXTR_SKIP);

    if (!preg_match('/^(name)\s(asc|desc)$/i', $order, $order)) {
      $order = [1 => 'name', 2 => 'asc'];
    }

    $limit = (int) $limit ?: Application::module('sermons')->config('sermons.sermons_per_page');
    $count = $query->count();
    $pages = ceil($count / $limit);
    $page  = max(0, min($pages - 1, $page));

    $bible_books = array_values($query->offset($page * $limit)->limit($limit)->orderBy($order[1], $order[2])->get());

    return compact('bible_books', 'pages', 'count');
  }

  /**
   * @Route("/{id}", methods="GET", requirements={"id"="\d+"})
   * @param $id
   * @return mixed
   */
  public function getAction($id) {
    return BibleBook::where(compact('id'))->first();
  }
}
