module.exports = [

  {
    entry: {
      "settings": "./app/views/admin/settings",
      "sermons": "./app/views/admin/sermons",
      "series": "./app/views/admin/series",
      "preachers": "./app/views/admin/preachers",
      "topics": "./app/views/admin/topics"
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
