module.exports = {

  name: 'topics',

  el: '#topics',

  data: function () {
    return _.merge({
      topics: false,
      config: {
        filter: this.$session.get('topics.filter', {order: 'name asc', limit: 25})
      },
      pages: 0,
      count: '',
      selected: []
    }, window.$data);
  },

  ready: function () {
    this.resource = this.$resource('api/sermons/topic{/id}');
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

        this.$session.set('topics.filter', filter);
      },
      deep: true
    }

  },

  methods: {

    active: function (topic) {
      return this.selected.indexOf(topic.id) != -1;
    },

    save: function (topic) {
      this.resource.save({id: topic.id}, {preacher: topic}).then(function () {
        this.load();
        this.$notify('Preacher saved.');
      });
    },

    remove: function () {

      this.resource.delete({id: 'bulk'}, {ids: this.selected}).then(function () {
        this.load();
        this.$notify('Topics deleted.');
      });
    },

    load: function () {
      this.resource.query({filter: this.config.filter, page: this.config.page}).then(function (res) {

        var data = res.data;

        this.$set('topics', data.topics);
        this.$set('pages', data.pages);
        this.$set('count', data.count);
        this.$set('selected', []);
      });
    },

    getSelected: function () {
      return this.topics.filter(function (topic) {
        return this.selected.indexOf(topic.id) !== -1;
      }, this);
    }

  }

};

Vue.ready(module.exports);
