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

    if (this.sermon.topics) {
      this.sermon.topics.forEach(function (topic) {
        var index = data.topics.findIndex(function (element) {
          return element.id == topic.id;
        });
        if (index != -1) {
          data.topics.splice(index, 1);
        }
      });
    } else {
      //make sure Vue picks up the change
      Vue.set(this.sermon, 'topics', []);
    }

    if (this.sermon.bible_books) {
      this.sermon.bible_books.forEach(function (bible_book) {
        var index = data.bible_books.findIndex(function (element) {
          return element.id == bible_book.id;
        });
        if (index != -1) {
          data.bible_books.splice(index, 1);
        }
      });
    } else {
      //make sure Vue picks up the change
      Vue.set(this.sermon, 'bible_books', []);
    }


  },

  watch: {
    'selected.topic': function () {
      if(!this.selected.topic.id) {
        return;
      }
      var id = this.selected.topic.id;
      var exists = false;
      if (this.sermon.topics) {
        exists = this.sermon.topics.find(function (topic) {
          return topic.id == id;
        });
      }
      if (!exists) {
        if (!this.sermon.topics) {
          Vue.set(this.sermon, 'topics', []);
        }
        this.sermon.topics.push(this.selected.topic);
      }

      var index = this.data.topics.findIndex(function (topic) {
        return topic.id == id;
      });
      if (index != -1) {
        this.data.topics.splice(index, 1);
      }
      this.selected.topic = {};
    },
    'selected.bible_book': function () {
      if(!this.selected.bible_book.id) {
        return;
      }
      var id = this.selected.bible_book.id;
      var exists = false;
      if (this.sermon.bible_books) {
        exists = this.sermon.bible_books.find(function (bible_book) {
          return bible_book.id == id;
        });
      }
      if (!exists) {
        if (!this.sermon.bible_books) {
          Vue.set(this.sermon, 'bible_books', []);
        }
        this.sermon.bible_books.push(this.selected.bible_book);
      }

      var index = this.data.bible_books.findIndex(function (bible_book) {
        return bible_book.id == id;
      });
      if (index != -1) {
        this.data.bible_books.splice(index, 1);
      }
      this.selected.bible_book = {};
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
    },

    removeTopic: function (topic) {
      if (this.sermon.topics) {
        var index = this.sermon.topics.findIndex(function (_topic) {
          return _topic.id == topic.id;
        });

        if (index !== -1) {
          this.sermon.topics.splice(index, 1);

          var exists = this.data.topics.find(function (_topic) {
            return _topic.id == topic.id;
          });
          if (!exists) {
            this.data.topics.push(topic);
            this.selected.topic = {};
          }
        }
      }
    },

    removeBibleBook: function (bible_book) {
      if (this.sermon.bible_books) {
        var index = this.sermon.bible_books.findIndex(function (_bible_book) {
          return _bible_book.id == bible_book.id;
        });

        if (index !== -1) {
          this.sermon.bible_books.splice(index, 1);

          var exists = this.data.bible_books.find(function (_bible_book) {
            return _bible_book.id == bible_book.id;
          });
          if (!exists) {
            this.data.bible_books.push(bible_book);
            this.selected.bible_book = {};
          }
        }
      }
    }

  }

};

Vue.ready(window.Sermon);
