<?php

return [
    'install' => function ($app) {
      $util = $app['db']->getUtility();

      if ($util->tableExists('@sermons_sermons') === false) {
        $util->createTable('@sermons_sermons', function ($table) {

          $table->addColumn('id', 'integer', ['unsigned' => true, 'length' => 10, 'autoincrement' => true]);
          $table->addColumn('name', 'string', ['length' => 255]);
          $table->addColumn('date', 'date');
          $table->addColumn('mp3_name', 'string', ['length' => 512]);
          $table->addColumn('preacher', 'string', ['length' => 255]);
          $table->addColumn('bible_passage', 'string', ['length' => 100]);
          $table->addColumn('description', 'text');
          $table->addColumn('sermon_series', 'string', ['length' => 255]);
          $table->addColumn('sermon_notes', 'text');
          $table->addColumn('sermon_topics', 'string', ['length' => 255]);
          $table->addColumn('feature_image', 'string', ['length' => 255]);

          $table->setPrimaryKey(['id']);
        });
      }
    },
    'enable' => function ($app) {

    },
    'uninstall' => function ($app) {
      $util = $app['db']->getUtility();
      if ($util->tableExists('@sermons_sermons')) {
        $util->dropTable('@sermons_sermons');
      }
    },
    'updates' => [

    ]
];