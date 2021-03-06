<?php


namespace beejjacobs\Sermons\Model;
use Pagekit\Database\ORM\ModelTrait;

/**
 * @Entity(tableClass="@sermons_bible_books")
 */
class BibleBook implements \JsonSerializable {

  use BibleBookModelTrait;

  const SERMONS = 'sermons';

  /**
   * @Column(type="integer")
   * @Id
   */
  public $id;

  /**
   * @Column(type="string")
   */
  public $name;

  /**
   * @ManyToMany(targetEntity="beejjacobs\Sermons\Model\Sermon", tableThrough="@sermons_sermon_bible_books", keyThroughFrom="bible_book_id", keyThroughTo="sermon_id")
   */
  public $sermons;

  /**
   * @Column(type="integer")
   */
  public $sermon_count = 0;

  public function jsonSerialize() {
    $data = [];
    if ($this->sermons) {
      $data['sermons'] = $this->sermons;
    }
    return $this->toArray($data);
  }
}
