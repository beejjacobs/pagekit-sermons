module.exports = [

    {
        entry: {
            "settings": "./app/views/admin/settings",
            "sermons": "./app/views/admin/sermons"
        },
        output: {
            filename: "./app/bundle/[name].js"
        },
        module: {
            loaders: [
                { test: /\.vue$/, loader: "vue" }
            ]
        }
    }

];
