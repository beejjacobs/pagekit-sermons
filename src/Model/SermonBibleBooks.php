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

}
