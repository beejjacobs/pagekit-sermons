<?php
namespace beejjacobs\Sermons\Model;


use Pagekit\Database\ORM\ModelTrait;

trait PreacherModelTrait {
  use ModelTrait;

  /**
   * Updates the sermon count for a preacher
   * @param int $id
   */
  public static function updateSermonInfo($id) {
    $query = Sermon::where(['preacher_id' => $id]);

    self::where(compact('id'))->update(['sermon_count' => $query->count()]);
  }
}
