module.exports = {

  name: 'series',

  el: '#series',

  data: function () {
    return _.merge({
      all_series: false,
      editing: false,
      new_series: {id: null, name: ''},
      form: false,
      config: {
        filter: this.$session.get('series.filter', {order: 'name asc', limit: 25})
      },
      pages: 0,
      count: '',
      selected: []
    }, window.$data);
  },

  ready: function () {
    this.resource = this.$resource('api/sermons/series{/id}');
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

        this.$session.set('series.filter', filter);
      },
      deep: true
    }

  },

  methods: {

    active: function (series) {
      return this.selected.indexOf(series.id) != -1;
    },

    create: function () {
      this.resource.save({series: this.new_series}).then(function () {
        this.load();
        this.$notify('Series created.');
        this.$set('new_series', {id: null, name: ''});
      });
    },

    edit: function (series) {
      this.$set('editing', series);
    },

    cancelEdit: function () {
      this.$set('editing', false);
    },

    save: function (series) {
      this.resource.save({id: series.id}, {series: series}).then(function () {
        this.load();
        this.$notify('Series saved.');
        this.$set('editing', false);
      });
    },

    remove: function () {

      this.resource.delete({id: 'bulk'}, {ids: this.selected}).then(function () {
        this.load();
        this.$notify('Series deleted.');
      });
    },

    load: function () {
      this.resource.query({filter: this.config.filter, page: this.config.page}).then(function (res) {

        var data = res.data;

        this.$set('all_series', data.series);
        this.$set('pages', data.pages);
        this.$set('count', data.count);
        this.$set('selected', []);
      });
    },

    getSelected: function () {
      return this.series.filter(function (series) {
        return this.selected.indexOf(series.id) !== -1;
      }, this);
    }

  }

};

Vue.ready(module.exports);
