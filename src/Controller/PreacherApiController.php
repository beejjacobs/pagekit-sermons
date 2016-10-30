<?php
namespace beejjacobs\Sermons\Controller;


use beejjacobs\Sermons\Model\Preacher;
use Pagekit\Application;

/**
 * Class PreacherApiController
 * @package beejjacobs\Sermons\Controller
 * @Route("preacher", name="preacher")
 */
class PreacherApiController {

  /**
   * @Route("/", methods="GET")
   * @Request({"filter": "array", "page":"int"})
   * @param array $filter
   * @param int $page
   * @return mixed
   */
  public function indexAction($filter = [], $page = 0) {
    $query = Preacher::query();
    $filter = array_merge(array_fill_keys(['search', 'order', 'limit'], ''), $filter);

    extract($filter, EXTR_SKIP);

    if ($search) {
      $query->where(function ($query) use ($search) {
        $query->orWhere(['name LIKE :search'], ['search' => "%{$search}%"]);
      });
    }

    if (!preg_match('/^(name)\s(asc|desc)$/i', $order, $order)) {
      $order = [1 => 'name', 2 => 'asc'];
    }

    $limit = (int) $limit ?: Application::module('sermons')->config('sermons.preachers_per_page');
    $count = $query->count();
    $pages = ceil($count / $limit);
    $page  = max(0, min($pages - 1, $page));

    $preachers = array_values($query->offset($page * $limit)->limit($limit)->orderBy($order[1], $order[2])->get());

    return compact('preachers', 'pages', 'count');
  }

  /**
   * @Route("/{id}", methods="GET", requirements={"id"="\d+"})
   * @param $id
   * @return mixed
   */
  public function getAction($id) {
    return Preacher::where(compact('id'))->first();
  }

  /**
   * @Route("/", methods="POST")
   * @Route("/{id}", methods="POST", requirements={"id"="\d+"})
   * @Request({"post": "array", "id": "int"}, csrf=true)
   * @param $data
   * @param int $id
   * @return array
   */
  public function saveAction($data, $id = 0) {
    if (!$id || !$preacher = Preacher::find($id)) {
      if ($id) {
        Application::abort(404, __('Preacher not found.'));
      }

      $preacher = Preacher::create();
    }

    if (!Application::user()->hasAccess('sermons: manage preachers')) {
      Application::abort(400, __('Access denied.'));
    }

    $preacher->save($data);

    return ['message' => 'success', 'preacher' => $preacher];
  }

  /**
   * @Route("/{id}", methods="DELETE", requirements={"id"="\d+"})
   * @Request({"id": "int"}, csrf=true)
   * @param $id
   * @return array
   */
  public function deleteAction($id) {
    if ($preacher = Preacher::find($id)) {

      if (!Application::user()->hasAccess('sermons: manage preachers')) {
        Application::abort(400, __('Access denied.'));
      }

      $preacher->delete();
    }

    return ['message' => 'success'];
  }

  /**
   * @Route("/bulk", methods="POST")
   * @Request({"posts": "array"}, csrf=true)
   * @param array $preachers
   * @return array
   */
  public function bulkSaveAction($preachers = []) {
    foreach ($preachers as $data) {
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
