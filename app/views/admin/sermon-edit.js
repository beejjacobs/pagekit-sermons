window.Sermon = {

  el: '#sermon',

  data: function () {
    return {
      data: window.$data,
      sermon: window.$data.sermon,
      form: false
    }
  },

  created: function () {
    this.resource = this.$resource('api/sermons/sermon{/id}');
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
