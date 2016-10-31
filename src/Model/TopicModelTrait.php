<?php
namespace beejjacobs\Sermons\Model;


use Pagekit\Application;
use Pagekit\Database\ORM\ModelTrait;

trait TopicModelTrait {
  use ModelTrait;

  /**
   * Updates the sermon count for a topic
   * @param int $sermon_id
   */
  public static function updateSermonInfo($sermon_id) {
    $db = Application::db();
    $sermon_topics = $db->createQueryBuilder()
        ->select(['topic_id'])
        ->from('@sermons_sermon_topics')
        ->where('sermon_id = ?', [$sermon_id])
        ->get();

    foreach ($sermon_topics as $sermon_topic) {
      $topic_id = $sermon_topic['topic_id'];
      $query = $db->createQueryBuilder()->select()->from('@sermons_sermon_topics')->where('topic_id = ?', [$topic_id]);

      self::where(['id' => $topic_id])->update(['sermon_count' => $query->count()]);
    }
  }
}
