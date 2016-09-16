<?php

namespace beejjacobs\Sermons\Model;

use Pagekit\Database\ORM\ModelTrait;

/**
 * @Entity(tableClass="@sermons_sermons")
 */
class Sermon {

  use ModelTrait;

  const SERMON_SERIES = 'sermon_series';

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
   * @Column(type="date")
   */
  public $date;

  /**
   * @Column(type="string")
   */
  public $mp3_name;

  /**
   * @Column(type="integer")
   */
  public $preacher_id;

  /**
   * @BelongsTo(targetEntity="beejjacobs\Sermons\Model\Preacher", keyFrom="$preacher_id")
   */
  public $preacher;

  /**
   * @Column(type="string")
   */
  public $bible_passage;

  /**
   * @Column(type="text")
   */
  public $description;

  /**
   * @Column(type="integer")
   */
  public $sermon_series_id;

  /**
   * @BelongsTo(targetEntity="beejjacobs\Sermons\Model\Series", keyFrom="sermon_series_id")
   */
  public $sermon_series;

  /**
   * @Column(type="text")
   */
  public $sermon_notes;

  /**
   * @Column(type="string")
   */
  public $sermon_topics;

  /**
   * @Column(type="string")
   */
  public $feature_image;

}