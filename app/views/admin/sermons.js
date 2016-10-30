module.exports = {

  name: 'sermons',

  el: '#sermons',

  data: function () {
    return _.merge({
      sermons: false,
      config: {
        filter: this.$session.get('sermons.filter', {order: 'date desc', limit: 25})
      },
      pages: 0,
      count: '',
      selected: []
    }, window.$data);
  },

  ready: function () {
    this.resource = this.$resource('api/sermons/sermon{/id}');
    this.$watch('config.page', this.load, {immediate: true});
  },

  watch: {

    'config.filter': {
      handler: function (filter) {
        if (this.config.page) {
          this.config.page = 0;
        } else {
          this.load();
        }

        this.$session.set('sermons.filter', filter);
      },
      deep: true
    }

  },

  methods: {

    active: function (sermon) {
      return this.selected.indexOf(sermon.id) != -1;
    },

    save: function (sermon) {
      this.resource.save({id: sermon.id}, {sermon: sermon}).then(function () {
        this.load();
        this.$notify('Sermon saved.');
      });
    },

    status: function (status) {

      var sermons = this.getSelected();

      sermons.forEach(function (sermon) {
        sermon.status = status;
      });

      this.resource.save({id: 'bulk'}, {sermons: sermons}).then(function () {
        this.load();
        this.$notify('Sermons saved.');
      });
    },

    remove: function () {

      this.resource.delete({id: 'bulk'}, {ids: this.selected}).then(function () {
        this.load();
        this.$notify('Sermons deleted.');
      });
    },

    toggleStatus: function (sermon) {
      sermon.status = sermon.status === 2 ? 3 : 2;
      this.save(sermon);
    },

    copy: function () {
      if (!this.selected.length) {
        return;
      }

      this.resource.save({id: 'copy'}, {ids: this.selected}).then(function () {
        this.load();
        this.$notify('Sermons copied.');
      });
    },

    load: function () {
      this.resource.query({filter: this.config.filter, page: this.config.page}).then(function (res) {

        var data = res.data;

        data.sermons.forEach(function (sermon) {
          sermon.date = new Date(sermon.date.date);
        });

        this.$set('sermons', data.sermons);
        this.$set('pages', data.pages);
        this.$set('count', data.count);
        this.$set('selected', []);
      });
    },

    getSelected: function () {
      return this.sermons.filter(function (sermon) {
        return this.selected.indexOf(sermon.id) !== -1;
      }, this);
    },

    getStatusText: function (sermon) {
      return this.statuses[sermon.status];
    }

  }

};

Vue.ready(module.exports);
