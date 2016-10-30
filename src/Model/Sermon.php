<?php

namespace beejjacobs\Sermons\Model;

use Pagekit\Database\ORM\ModelTrait;

/**
 * @Entity(tableClass="@sermons_sermons")
 */
class Sermon implements \JsonSerializable {

  use ModelTrait;

  const SERMON_SERIES = 'sermon_series';
  const PREACHER = 'preacher';
  const TOPICS = 'topics';
  const BIBLE_BOOKS = 'bible_books';

  const RELATED = [
      self::SERMON_SERIES,
      self::PREACHER,
      self::TOPICS,
      self::BIBLE_BOOKS
  ];

  const STATUS_UNPUBLISHED = 0;
  const STATUS_PUBLISHED = 1;

  /**
   * @Column(type="integer")
   * @Id
   */
  public $id;

  /**
   * @Column(type="smallint")
   */
  public $status;

  /**
   * @Column(type="string")
   */
  public $title;

  /**
   * @Column(type="string")
   */
  public $slug;

  /**
   * @Column(type="datetime")
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
   * Get all Sermons with all related models
   * @return array
   */
  public static function getWithRelations() {
    return self::query()->related(self::RELATED)->get();
  }

  /**
   * An array of statuses as display text
   * @return array
   */
  public static function getStatuses() {
    return [
        self::STATUS_UNPUBLISHED => __('Unpublished'),
        self::STATUS_PUBLISHED => __('Published')
    ];
  }

  /**
   * Get the current status as display text
   * @return mixed
   */
  public function getStatusText() {
    $statuses = self::getStatuses();

    return isset($statuses[$this->status]) ? $statuses[$this->status] : __('Unknown');
  }

  public function jsonSerialize() {
    $data = [];
    if ($this->preacher) {
      if(is_array($this->preacher)) {
        $data['preacher'] = $this->preacher;
      } else {
        $data['preacher'] = $this->preacher->toArray();
      }
    }
    if ($this->bible_books) {
      $data['bible_books'] = $this->bible_books;
    }
    if ($this->sermon_series) {
      if(is_array($this->sermon_series)) {
        $data['sermon_series'] = $this->sermon_series;
      } else {
        $data['sermon_series'] = $this->sermon_series->toArray();
      }
    }
    if ($this->topics) {
      $data['topics'] = $this->topics;
    }
    return $this->toArray($data);
  }

}
