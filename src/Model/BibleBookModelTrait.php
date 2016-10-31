<?php
namespace beejjacobs\Sermons\Model;


use Pagekit\Application;
use Pagekit\Database\ORM\ModelTrait;

trait BibleBookModelTrait {
  use ModelTrait;

  /**
   * Updates the sermon count for a book of the Bible
   * @param int $sermon_id
   */
  public static function updateSermonInfo($sermon_id) {
    $db = Application::db();
    $sermon_bible_books = $db->createQueryBuilder()
        ->select(['bible_book_id'])
        ->from('@sermons_sermon_bible_books')
        ->where('sermon_id = ?', [$sermon_id])
        ->execute();

    foreach ($sermon_bible_books as $sermon_bible_book) {
      $bible_book_id = $sermon_bible_book['bible_book_id'];
      $query = $db->createQueryBuilder()->select()->from('@sermons_sermon_bible_books')->where('bible_book_id = ?', [$bible_book_id]);

      self::where(['id' => $bible_book_id])->update(['sermon_count' => $query->count()]);
    }
  }
}
