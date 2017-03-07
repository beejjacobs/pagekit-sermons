<?php
namespace beejjacobs\Sermons\Event;


use beejjacobs\Sermons\Model\BibleBook;
use beejjacobs\Sermons\Model\Preacher;
use beejjacobs\Sermons\Model\Series;
use beejjacobs\Sermons\Model\Sermon;
use beejjacobs\Sermons\Model\SermonTopics;
use beejjacobs\Sermons\Model\Topic;
use Pagekit\Database\Events;
use Pagekit\Event\EventSubscriberInterface;

class SermonTopicsListener implements EventSubscriberInterface {

  public function onSermonTopicChange($event, SermonTopics $topic) {
    Topic::updateSermonInfo($topic->sermon_id);
  }

  public function subscribe() {
    return [
        'model.sermontopics.created' => 'onSermonTopicChange',
        'model.sermontopics.updated' => 'onSermonTopicChange',
        'model.sermontopics.saved' => 'onSermonTopicChange',
        'model.sermontopics.deleted' => 'onSermonTopicChange'
    ];
  }

}
