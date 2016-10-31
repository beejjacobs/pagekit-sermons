<?php $view->script('sermons', 'sermons:app/bundle/series.js', 'vue') ?>

<div id="series" class="uk-form" v-cloak>

  <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
    <div class="uk-flex uk-flex-middle uk-flex-wrap" data-uk-margin>

      <h2 class="uk-margin-remove" v-if="!selected.length">{{ count + ' Series' | trans }}</h2>

      <template v-else>
        <h2 class="uk-margin-remove">{{ selected.length + ' Series selected' | trans }}</h2>

        <div class="uk-margin-left">
          <ul class="uk-subnav pk-subnav-icon">
            <li>
              <a class="pk-icon-delete pk-icon-hover" title="Delete" data-uk-tooltip="{delay: 500}" @click="remove"
                   v-confirm="'Delete Series?'"></a>
            </li>
          </ul>
        </div>
      </template>

      <div class="pk-search">
        <div class="uk-search">
          <input class="uk-search-field" type="text" v-model="config.filter.search" debounce="300">
        </div>
      </div>

    </div>
    <div data-uk-margin>

      <a class="uk-button uk-button-primary" :href="$url.route('admin/sermons/series/edit')">
        {{ 'Add Series' | trans }}
      </a>

    </div>
  </div>

  <div class="uk-overflow-container">
    <table class="uk-table uk-table-hover uk-table-middle">
      <thead>
      <tr>
        <th class="pk-table-width-minimum">
          <input type="checkbox" v-check-all:selected.literal="input[name=id]" number>
        </th>
        <th class="pk-table-min-width-200" v-order:title="config.filter.order">
          {{ 'Title' | trans }}
        </th>
        <th class="pk-table-width-100 uk-text-center" v-order:sermon_count="config.filter.order">
          {{ 'Sermons' | trans }}
        </th>
      </tr>
      </thead>
      <tbody>
      <tr class="check-item" v-for="series in all_series" :class="{'uk-active': active(series)}">
        <td>
          <input type="checkbox" name="id" :value="series.id">
        </td>
        <td>
          <a :href="$url.route('admin/sermons/series/edit', { id: series.id })">{{ series.name }}</a>
        </td>
        <td class="uk-text-center">
          {{ series.sermon_count }}
        </td>
      </tr>
      </tbody>
    </table>
  </div>

  <h3 class="uk-h1 uk-text-muted uk-text-center" v-show="all_series && !all_series.length">
    {{ 'No series found.' | trans }}
  </h3>

  <v-pagination :page.sync="config.page" :pages="pages" v-show="pages > 1 || page > 0"></v-pagination>

</div>
