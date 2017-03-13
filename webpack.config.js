module.exports = [

  {
    entry: {
      "input-date-am-pm": "./app/components/input-date-am-pm.vue",
      "input-audio": "./app/components/input-audio.vue",
      "settings": "./app/views/admin/settings.js",
      "sermon-index": "./app/views/admin/sermon-index.js",
      "sermon-edit": "./app/views/admin/sermon-edit.js",
      "series": "./app/views/admin/series.js",
      "preachers": "./app/views/admin/preachers.js",
      "topics": "./app/views/admin/topics.js"
    },
    output: {
      filename: "./app/bundle/[name].js"
    },
    module: {
      loaders: [
        {test: /\.vue$/, loader: "vue"}
      ]
    }
  }

];
