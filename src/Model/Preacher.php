<?php


namespace beejjacobs\Sermons\Model;

use Pagekit\Database\ORM\ModelTrait;

/**
 * @Entity(tableClass="@sermons_preachers")
 */
class Preacher {

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
   * @HasMany(targetEntity="beejjacobs\Sermons\Model\Sermon", keyFrom="id", keyTo="preacher_id")
   */
  public $sermons;

}