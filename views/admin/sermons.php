<?php $view->script('sermons', 'sermons:app/bundle/sermons.js', 'vue') ?>

<div id="sermons" class="uk-form" v-cloak>

  <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
    <div class="uk-flex uk-flex-middle uk-flex-wrap" data-uk-margin>

      <h2 class="uk-margin-remove" v-if="!selected.length">{{ '{0} %count% Sermons|{1} %count% Sermon|]1,Inf[ %count%
        Sermons' | transChoice count {count:count} }}</h2>

      <template v-else>
        <h2 class="uk-margin-remove">{{ '{1} %count% Sermon selected|]1,Inf[ %count% Sermons selected' | transChoice
          selected.length {count:selected.length} }}</h2>

        <div class="uk-margin-left">
          <ul class="uk-subnav pk-subnav-icon">
            <li><a class="pk-icon-copy pk-icon-hover" title="Copy" data-uk-tooltip="{delay: 500}" @click="copy"></a>
            </li>
            <li><a class="pk-icon-delete pk-icon-hover" title="Delete" data-uk-tooltip="{delay: 500}" @click="remove"
                   v-confirm="'Delete Sermons?'"></a></li>
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

      <a class="uk-button uk-button-primary" :href="$url.route('admin/sermons/sermon/edit')">{{ 'Add Sermon' | trans
        }}</a>

    </div>
  </div>

  <div class="uk-overflow-container">
    <table class="uk-table uk-table-hover uk-table-middle">
      <thead>
      <tr>
        <th class="pk-table-width-minimum"><input type="checkbox" v-check-all:selected.literal="input[name=id]" number>
        </th>
        <th class="pk-table-min-width-200" v-order:title="config.filter.order">{{ 'Title' | trans }}</th>
        <th class="pk-table-width-100 uk-text-center">
          <input-filter :title="$trans('Status')" :value.sync="config.filter.status"
                        :options="statusOptions"></input-filter>
        </th>
        <th class="pk-table-width-100">
          <input-filter :title="$trans('Preacher')" :value.sync="config.filter.preacher"
                        :options="preachers"></input-filter>
        </th>
        <th class="pk-table-width-100" v-order:date="config.filter.order">{{ 'Date' | trans }}</th>
        <th class="pk-table-width-200 pk-table-min-width-200">{{ 'URL' | trans }}</th>
      </tr>
      </thead>
      <tbody>
      <tr class="check-item" v-for="sermon in sermons" :class="{'uk-active': active(sermon)}">
        <td><input type="checkbox" name="id" :value="sermon.id"></td>
        <td>
          <a :href="$url.route('admin/sermons/sermon/edit', { id: sermon.id })">{{ sermon.title }}</a>
        </td>
        <td class="uk-text-center">
          <a :title="getStatusText(sermon)" :class="{
                                'pk-icon-circle': sermon.status == 0,
                                'pk-icon-circle-warning': sermon.status == 1,
                                'pk-icon-circle-success': sermon.status == 2 && sermon.published,
                                'pk-icon-circle-danger': sermon.status == 3,
                                'pk-icon-schedule': sermon.status == 2 && !sermon.published
                            }" @click="toggleStatus(sermon)"></a>
        </td>
        <td>
          {{ sermon.preacher.name }}
        </td>
        <td>
          {{ sermon.date | date }}
        </td>
        <td class="pk-table-text-break">
          <a target="_blank" v-if="sermon.accessible && sermon.url" :href="this.$url.route(sermon.url.substr(1))">{{
            decodeURI(sermon.url) }}</a>
          <span v-if="!sermon.accessible && sermon.url">{{ decodeURI(sermon.url) }}</span>
          <span v-if="!sermon.url">{{ 'Disabled' | trans }}</span>
        </td>
      </tr>
      </tbody>
    </table>
  </div>

  <h3 class="uk-h1 uk-text-muted uk-text-center" v-show="sermons && !sermons.length">{{ 'No sermons found.' | trans
    }}</h3>

  <v-pagination :page.sync="config.page" :pages="pages" v-show="pages > 1 || page > 0"></v-pagination>

</div>
