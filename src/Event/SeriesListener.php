<?php
namespace beejjacobs\Sermons\Event;


use beejjacobs\Sermons\Model\Series;
use beejjacobs\Sermons\Model\Sermon;
use Pagekit\Event\EventSubscriberInterface;

class SeriesListener implements EventSubscriberInterface {

  public function onSermonChange($event, Sermon $sermon) {
    Series::updateSermonInfo($sermon->sermon_series_id);
  }

  public function subscribe() {
    return [
        'model.sermon.saved' => 'onSermonChange',
        'model.sermon.deleted' => 'onSermonChange'
    ];
  }

}
