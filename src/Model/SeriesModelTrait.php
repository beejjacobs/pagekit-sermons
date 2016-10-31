<?php
namespace beejjacobs\Sermons\Model;


use Pagekit\Database\ORM\ModelTrait;

trait SeriesModelTrait {
  use ModelTrait;

  /**
   * Updates the sermon count for a series
   * @param int $id
   */
  public static function updateSermonInfo($id) {
    $query = Sermon::where(['sermon_series_id' => $id]);

    self::where(compact('id'))->update(['sermon_count' => $query->count()]);
  }
}
