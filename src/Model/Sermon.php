<?php

namespace beejjacobs\Sermons\Model;

use Pagekit\Database\ORM\ModelTrait;

/**
 * @Entity(tableClass="@sermons_sermons")
 */
class Sermon {

  use ModelTrait;

  const SERMON_SERIES = 'sermon_series';
  const PREACHER = 'preacher';
  const TOPICS = 'topics';
  const BIBLE_BOOKS = 'bible_books';

  /**
   * @Column(type="integer")
   * @Id
   */
  public $id;

  /**
   * @Column(type="string")
   */
  public $title;

  /**
   * @Column(type="string")
   */
  public $slug;

  /**
   * @Column(type="date")
   */
  public $date;

  /**
   * @Column(type="string")
   */
  public $mp3_source;

  /**
   * @Column(type="integer")
   */
  public $preacher_id;

  /**
   * @BelongsTo(targetEntity="beejjacobs\Sermons\Model\Preacher", keyFrom="preacher_id")
   */
  public $preacher;

  /**
   * @Column(type="string")
   */
  public $bible_passage;

  /**
   * @ManyToMany(targetEntity="beejjacobs\Sermons\Model\BibleBook", tableThrough="@sermons_sermon_bible_books", keyThroughFrom="sermon_id", keyThroughTo="bible_book_id")
   */
  public $bible_books;

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
   * @ManyToMany(targetEntity="beejjacobs\Sermons\Model\Topic", tableThrough="@sermons_sermon_topics", keyThroughFrom="sermon_id", keyThroughTo="topic_id")
   */
  public $topics;

  /**
   * @Column(type="string")
   */
  public $feature_image;

  /**
   * @return array
   */
  public static function getWithRelations() {
    return self::query()->related([self::SERMON_SERIES, self::PREACHER, self::TOPICS, self::BIBLE_BOOKS])->get();
  }

}
