<?php


namespace beejjacobs\Sermons\Model;

use Pagekit\Database\ORM\ModelTrait;

/**
 * @Entity(tableClass="@sermons_topics")
 */
class Topic implements \JsonSerializable {

  use ModelTrait;

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
   * @ManyToMany(targetEntity="beejjacobs\Sermons\Model\Sermon", tableThrough="@sermons_sermon_topics", keyThroughFrom="topic_id", keyThroughTo="sermon_id")
   */
  public $sermons;

  public function jsonSerialize() {
    $data = [];
    if ($this->sermons) {
      $data['sermons'] = $this->sermons;
    }
    return $this->toArray($data);
  }

}
