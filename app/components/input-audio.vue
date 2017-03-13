<template>

  <a class="uk-placeholder uk-text-center uk-display-block uk-margin-remove" v-if="!source" @click.prevent="pick">
    <p class="uk-text-muted uk-margin-small-top">{{ 'Select Audio' | trans }}</p>
  </a>

  <div v-else>
    <audio controls class="uk-width-5-6" style="height:40px" :src="audio">
      Your browser does not support the <code>audio</code> element.
    </audio>

    <span class="pk-panel-badge uk-width-1-6" v-if="audio">
      <a class="pk-icon-delete" :title="'Delete' | trans" data-uk-tooltip="{delay: 500}" @click.prevent="remove"></a>
    </span>
  </div>

  <v-modal v-ref:modal large>

    <panel-finder :root="storage" :modal="true" v-ref:finder></panel-finder>

    <div class="uk-modal-footer uk-text-right">
      <button class="uk-button uk-button-link uk-modal-close" type="button">{{ 'Cancel' | trans }}</button>
      <button class="uk-button uk-button-primary" type="button" :disabled="!selectButton" @click.prevent="select">{{'Select' | trans }}</button>
    </div>

  </v-modal>

</template>

<script>

    module.exports = {

        props: ['source'],

        data: function () {
            return _.merge({audio: undefined}, $pagekit);
        },

        computed: {

            selectButton: function () {
                var selected = this.$refs.finder.getSelected();
                return selected.length === 1 && selected[0].match(/\.(mp3)$/i);
            }

        },

        watch: {
            source: {
                handler: 'update',
                immediate: true
            }
        },

        methods: {

            pick: function () {
                this.$refs.modal.open();
            },

            select: function () {
                this.source = this.$refs.finder.getSelected()[0];
                this.$refs.modal.close();
            },

            remove: function () {
                this.source = ''
            },

            update: function (src) {

                var matches;

                this.$set('audio', undefined);

                this.audio = this.$url(src);

            }

        }

    };

    Vue.component('input-audio', function (resolve, reject) {
        Vue.asset({
            js: [
                'app/assets/uikit/js/components/upload.min.js',
                'app/system/modules/finder/app/bundle/panel-finder.js'
            ]
        }).then(function () {
            resolve(module.exports);
        })
    });


</script>
