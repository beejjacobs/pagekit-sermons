<?php

namespace beejjacobs\Sermons\Model;

use Pagekit\Database\ORM\ModelTrait;

/**
 * Class Series
 * @package beejjacobs\Sermons\Model
 * @Entity(tableClass="@sermons_sermon_topics")
 */
class SermonTopics implements \JsonSerializable {

  use ModelTrait;

  /**
   * @Column(type="integer")
   * @Id
   */
  public $id;

  /**
   * @Column(type="integer")
   */
  public $sermon_id;

  /**
   * @Column(type="integer")
   */
  public $topic_id;

  public function jsonSerialize() {
    return $this->toArray();
  }

  /**
   * @param $sermon_id
   * @param $topic_id
   * @return bool
   */
  public static function checkLinkExists($sermon_id, $topic_id) {
    $count = SermonTopics::where(['sermon_id = ? AND topic_id = ?'], [$sermon_id, $topic_id])->count();

    return $count > 0;
  }

  /**
   * @param $sermon_id
   * @return SermonTopics[]
   */
  public static function forSermon($sermon_id) {
    return SermonTopics::where(['sermon_id = ?'], [$sermon_id])->get();
  }

}
