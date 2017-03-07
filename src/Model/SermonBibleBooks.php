<?php

namespace beejjacobs\Sermons\Model;

use Pagekit\Database\ORM\ModelTrait;

/**
 * Class Series
 * @package beejjacobs\Sermons\Model
 * @Entity(tableClass="@sermons_sermon_bible_books")
 */
class SermonBibleBooks implements \JsonSerializable {

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
  public $bible_book_id;

  public function jsonSerialize() {
    $data = [];
    if ($this->sermons) {
      $data['sermons'] = $this->sermons;
    }
    return $this->toArray($data);
  }

  /**
   * @param $sermon_id
   * @param $bible_book_id
   * @return bool
   */
  public static function checkLinkExists($sermon_id, $bible_book_id) {
    $count = SermonBibleBooks::where(['sermon_id = ? AND bible_book_id = ?'], [$sermon_id, $bible_book_id])->query()->count();

    return $count > 0;
  }

  /**
   * @param $sermon_id
   * @return SermonBibleBooks[]
   */
  public static function forSermon($sermon_id) {
    return SermonBibleBooks::where(['sermon_id = ?'], [$sermon_id])->get();
  }
}
