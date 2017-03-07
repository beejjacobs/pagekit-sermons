<?php
namespace beejjacobs\Sermons\Event;


use beejjacobs\Sermons\Model\BibleBook;
use beejjacobs\Sermons\Model\Preacher;
use beejjacobs\Sermons\Model\Series;
use beejjacobs\Sermons\Model\Sermon;
use beejjacobs\Sermons\Model\Topic;
use Pagekit\Event\EventSubscriberInterface;

class SermonListener implements EventSubscriberInterface {

  public function onSermonChange($event, Sermon $sermon) {
    Series::updateSermonInfo($sermon->sermon_series_id);
    Preacher::updateSermonInfo($sermon->preacher_id);
    Topic::updateSermonInfo($sermon->id);
    BibleBook::updateSermonInfo($sermon->id);
  }

  public function subscribe() {
    return [
        'model.sermon.created' => 'onSermonChange',
        'model.sermon.saved' => 'onSermonChange',
        'model.sermon.deleted' => 'onSermonChange'
    ];
  }

}
