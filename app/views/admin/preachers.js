module.exports = {

  name: 'preachers',

  el: '#preachers',

  data: function () {
    return _.merge({
      preachers: false,
      editing: false,
      new_preacher: {id: null, name: ''},
      form: false,
      config: {
        filter: this.$session.get('preachers.filter', {order: 'name asc', limit: 25})
      },
      pages: 0,
      count: '',
      selected: []
    }, window.$data);
  },

  ready: function () {
    this.resource = this.$resource('api/sermons/preacher{/id}');
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

        this.$session.set('preachers.filter', filter);
      },
      deep: true
    }

  },

  methods: {

    active: function (preacher) {
      return this.selected.indexOf(preacher.id) != -1;
    },

    create: function () {
      this.resource.save({preacher: this.new_preacher}).then(function () {
        this.load();
        this.$notify('Preacher created.');
        this.$set('new_preacher', {id: null, name: ''});
      });
    },

    edit: function (preacher) {
      this.$set('editing', preacher);
    },

    cancelEdit: function () {
      this.$set('editing', false);
    },

    save: function (preacher) {
      this.resource.save({id: preacher.id}, {preacher: preacher}).then(function () {
        this.load();
        this.$notify('Preacher saved.');
        this.$set('editing', false);
      });
    },

    remove: function () {

      this.resource.delete({id: 'bulk'}, {ids: this.selected}).then(function () {
        this.load();
        this.$notify('Preachers deleted.');
      });
    },

    load: function () {
      this.resource.query({filter: this.config.filter, page: this.config.page}).then(function (res) {

        var data = res.data;

        this.$set('preachers', data.preachers);
        this.$set('pages', data.pages);
        this.$set('count', data.count);
        this.$set('selected', []);
      });
    },

    getSelected: function () {
      return this.preachers.filter(function (preacher) {
        return this.selected.indexOf(preacher.id) !== -1;
      }, this);
    }

  }

};

Vue.ready(module.exports);
