window.Sermon = {

  el: '#sermon',

  data: function () {
    return {
      data: window.$data,
      sermon: window.$data.sermon,
      form: false,
      selected: {
        topic: {},
        bible_book: {}
      }
    }
  },

  created: function () {
    this.resource = this.$resource('api/sermons/sermon{/id}');

    var data = this.data;

    //todo: this doesn't seem to fully work
    this.sermon.topics.forEach(function (topic) {
      var index = data.topics.findIndex(function (element) {
        return element.id == topic.id;
      });
      if (index) {
        data.topics.splice(index, 1);
      }
    });

    this.sermon.bible_books.forEach(function (bible_book) {
      var index = data.bible_books.findIndex(function (element) {
        return element.id == bible_book.id;
      });
      if (index) {
        data.bible_books.splice(index, 1);
      }
    });


  },

  watch: {
    'selected.topic': function () {
      var id = this.selected.topic.id;
      var exists = this.sermon.topics.find(function (topic) {
        return topic.id == id;
      });
      if (!exists) {
        this.sermon.topics.push(this.selected.topic);
      }

      var index = this.data.topics.findIndex(function (topic) {
        return topic.id == id;
      });
      if (index) {
        this.data.topics.splice(index, 1);
      }
    },
    'selected.bible_book': function () {
      var id = this.selected.bible_book.id;
      var exists = this.sermon.bible_books.find(function (bible_book) {
        return bible_book.id == id;
      });
      if (!exists) {
        this.sermon.bible_books.push(this.selected.bible_book);
      }

      var index = this.data.bible_books.findIndex(function (bible_book) {
        return bible_book.id == id;
      });
      if (index) {
        this.data.bible_books.splice(index, 1);
      }
    }
  },

  methods: {

    save: function () {
      var data = {sermon: this.sermon, id: this.sermon.id};

      this.$broadcast('save', data);

      this.resource.save({id: this.sermon.id}, data).then(function (res) {

        var data = res.data;

        if (!this.sermon.id) {
          window.history.replaceState({}, '', this.$url.route('admin/sermons/sermons/edit', {id: data.sermon.id}))
        }

        this.$set('sermon', data.sermon);

        this.$notify('Sermon saved.');

      }, function (res) {
        this.$notify(res.data, 'danger');
      });
    }

  }

};

Vue.ready(window.Sermon);
