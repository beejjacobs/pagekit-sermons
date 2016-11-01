module.exports = {

  name: 'topics',

  el: '#topics',

  data: function () {
    return _.merge({
      topics: false,
      topic_editing: false,
      new_topic: {id: null, name: ''},
      form: false,
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

    newTopic: function () {
      this.save(this.new_topic);
    },

    edit: function (topic) {
      this.$set('topic_editing', topic);
    },

    cancelEdit: function () {
      this.$set('topic_editing', false);
    },

    save: function (topic) {
      this.resource.save({id: topic.id}, {topic: topic}).then(function () {
        this.load();
        this.$notify('Topic saved.');
        this.resetData();
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
    },

    resetData: function () {
      this.$set('topic_editing', false);
      this.$set('new_topic', {id: null, name: ''});
    }

  }

};

Vue.ready(module.exports);
