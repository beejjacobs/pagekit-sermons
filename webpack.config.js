module.exports = [

  {
    entry: {
      "settings": "./app/views/admin/settings",
      "sermon-index": "./app/views/admin/sermon-index",
      "sermon-edit": "./app/views/admin/sermon-edit",
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
