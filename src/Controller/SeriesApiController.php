<?php
namespace beejjacobs\Sermons\Controller;


use beejjacobs\Sermons\Model\Series;
use Pagekit\Application;

/**
 * Class SeriesApiController
 * @package beejjacobs\Sermons\Controller
 * @Access("sermons: manage series")
 * @Route("series", name="series")
 */
class SeriesApiController {

  /**
   * @Route("/", methods="GET")
   * @Request({"filter": "array", "page":"int"})
   * @param array $filter
   * @param int $page
   * @return mixed
   */
  public function indexAction($filter = [], $page = 0) {
    /**
     * @var string $search
     * @var string $order
     * @var string $limit
     */
    $query = Series::query();
    $filter = array_merge(array_fill_keys(['search', 'order', 'limit'], ''), $filter);

    extract($filter, EXTR_SKIP);

    if ($search) {
      $query->where(function ($query) use ($search) {
        $query->orWhere(['name LIKE :search'], ['search' => "%{$search}%"]);
      });
    }

    if (!preg_match('/^(name|sermon_count)\s(asc|desc)$/i', $order, $order)) {
      $order = [1 => 'name', 2 => 'asc'];
    }

    $limit = (int) $limit ?: Application::module('sermons')->config('sermons.series_per_page');
    $count = $query->count();
    $pages = ceil($count / $limit);
    $page  = max(0, min($pages - 1, $page));

    $series = array_values($query->offset($page * $limit)->limit($limit)->orderBy($order[1], $order[2])->get());

    return compact('series', 'pages', 'count');
  }

  /**
   * @Route("/{id}", methods="GET", requirements={"id"="\d+"})
   * @param $id
   * @return mixed
   */
  public function getAction($id) {
    return Series::where(compact('id'))->first();
  }

  /**
   * @Route("/", methods="POST")
   * @Route("/{id}", methods="POST", requirements={"id"="\d+"})
   * @Request({"series": "array", "id": "int"}, csrf=true)
   * @param $data
   * @param int $id
   * @return array
   */
  public function saveAction($data, $id = 0) {
    if (!$id || !$series = Series::find($id)) {
      if ($id) {
        Application::abort(404, __('Series not found.'));
      }

      $series = Series::create();
    }

    if (!Application::user()->hasAccess('sermons: manage series')) {
      Application::abort(400, __('Access denied.'));
    }

    $series->save($data);

    return ['message' => 'success', 'series' => $series];
  }

  /**
   * @Route("/{id}", methods="DELETE", requirements={"id"="\d+"})
   * @Request({"id": "int"}, csrf=true)
   * @param $id
   * @return array
   */
  public function deleteAction($id) {
    if ($series = Series::find($id)) {

      if (!Application::user()->hasAccess('sermons: manage series')) {
        Application::abort(400, __('Access denied.'));
      }

      $series->delete();
    }

    return ['message' => 'success'];
  }

  /**
   * @Route("/bulk", methods="POST")
   * @Request({"series": "array"}, csrf=true)
   * @param array $series
   * @return array
   */
  public function bulkSaveAction($series = []) {
    foreach ($series as $data) {
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
