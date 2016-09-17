<?php


namespace beejjacobs\Sermons\Model;
use Pagekit\Database\ORM\ModelTrait;

/**
 * @Entity(tableClass="@sermons_bible_books")
 */
class BibleBook {

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
   * @ManyToMany(targetEntity="beejjacobs\Sermons\Model\Sermon", tableThrough="@sermons_sermon_bible_books", keyThroughFrom="bible_book_id", keyThroughTo="sermon_id")
   */
  public $sermons;
}