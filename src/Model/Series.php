<?php

namespace beejjacobs\Sermons\Model;

use Pagekit\Database\ORM\ModelTrait;

/**
 * Class Series
 * @package beejjacobs\Sermons\Model
 * @Entity(tableClass="@sermons_series")
 */
class Series {

  use ModelTrait;


  /**
   * @Column(type="integer")
   */
  public $id;

  /**
   * @Column(type="string")
   */
  public $name;

}