<?php
namespace beejjacobs\Sermons\Event;


use beejjacobs\Sermons\Model\BibleBook;
use beejjacobs\Sermons\Model\Preacher;
use beejjacobs\Sermons\Model\Series;
use beejjacobs\Sermons\Model\Sermon;
use beejjacobs\Sermons\Model\SermonBibleBooks;
use beejjacobs\Sermons\Model\SermonTopics;
use beejjacobs\Sermons\Model\Topic;
use Pagekit\Database\Events;
use Pagekit\Event\EventSubscriberInterface;

class SermonBibleBooksListener implements EventSubscriberInterface {

  public function onSermonBibleBookChange($event, SermonBibleBooks $bibleBooks) {
    BibleBook::updateSermonInfo($bibleBooks->sermon_id);
  }

  public function subscribe() {
    return [
        'model.sermonbiblebooks.created' => 'onSermonBibleBookChange',
        'model.sermonbiblebooks.updated' => 'onSermonBibleBookChange',
        'model.sermonbiblebooks.saved' => 'onSermonBibleBookChange',
        'model.sermonbiblebooks.deleted' => 'onSermonBibleBookChange'
    ];
  }

}
