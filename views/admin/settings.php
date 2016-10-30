<?php $view->script('sermons-settings', 'sermons:app/bundle/settings.js', 'vue') ?>


<div id="settings" class="uk-form uk-form-horizontal" v-cloak>

  <div class="uk-grid pk-grid-large" data-uk-grid-margin>
    <div class="pk-width-content">

      <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
        <div data-uk-margin>

          <h2 class="uk-margin-remove">{{ 'Settings' | trans }}</h2>

        </div>
        <div data-uk-margin>

          <button class="uk-button uk-button-primary" @click.prevent="save">{{ 'Save' | trans }}</button>

        </div>
      </div>

      <div class="uk-form-row">
        <span class="uk-form-label">{{ 'Permalink' | trans }}</span>
        <div class="uk-form-controls uk-form-controls-text">
          <p class="uk-form-controls-condensed">
            <label>
              <input type="radio" v-model="config.permalink.type" value="">
              {{ 'Numeric' | trans }} <code>{{ '/123' | trans }}</code>
            </label>
          </p>
          <p class="uk-form-controls-condensed">
            <label>
              <input type="radio" v-model="config.permalink.type" value="{slug}">
              {{ 'Name' | trans }} <code>{{ '/sample-post' | trans }}</code>
            </label>
          </p>
          <p class="uk-form-controls-condensed">
            <label>
              <input type="radio" v-model="config.permalink.type" value="{year}/{month}/{day}/{slug}">
              {{ 'Day and name' | trans }} <code>{{ '/2014/06/12/sample-post' | trans }}</code>
            </label>
          </p>
          <p class="uk-form-controls-condensed">
            <label>
              <input type="radio" v-model="config.permalink.type" value="{year}/{month}/{slug}">
              {{ 'Month and name' | trans }} <code>{{ '/2014/06/sample-post' | trans }}</code>
            </label>
          </p>
          <p class="uk-form-controls-condensed">
            <label>
              <input type="radio" v-model="config.permalink.type" value="custom">
              {{ 'Custom' | trans }}
            </label>
            <input class="uk-form-small" type="text" v-model="config.permalink.custom">
          </p>
        </div>
      </div>

      <div class="uk-form-row">
        <label class="uk-form-label">{{ 'Sermons per page' | trans }}</label>
        <div class="uk-form-controls uk-form-controls-text">
          <p class="uk-form-controls-condensed">
            <input type="number" v-model="config.sermons.sermons_per_page" class="uk-form-width-small">
          </p>
        </div>
      </div>

      <div class="uk-form-row">
        <label class="uk-form-label">{{ 'Series per page' | trans }}</label>
        <div class="uk-form-controls uk-form-controls-text">
          <p class="uk-form-controls-condensed">
            <input type="number" v-model="config.sermons.series_per_page" class="uk-form-width-small">
          </p>
        </div>
      </div>

      <div class="uk-form-row">
        <label class="uk-form-label">{{ 'Preachers per page' | trans }}</label>
        <div class="uk-form-controls uk-form-controls-text">
          <p class="uk-form-controls-condensed">
            <input type="number" v-model="config.sermons.preachers_per_page" class="uk-form-width-small">
          </p>
        </div>
      </div>

      <div class="uk-form-row">
        <label class="uk-form-label">{{ 'Topics per page' | trans }}</label>
        <div class="uk-form-controls uk-form-controls-text">
          <p class="uk-form-controls-condensed">
            <input type="number" v-model="config.sermons.topics_per_page" class="uk-form-width-small">
          </p>
        </div>
      </div>

    </div>
  </div>

</div>
