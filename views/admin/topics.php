<?php $view->script('sermons', 'sermons:app/bundle/topics.js', 'vue') ?>

<div id="topics" class="uk-form" v-cloak>

  <div class="uk-margin uk-flex uk-flex-space-between uk-flex-wrap" data-uk-margin>
    <div class="uk-flex uk-flex-middle uk-flex-wrap" data-uk-margin>

      <h2 class="uk-margin-remove" v-if="!selected.length">
        {{ '{0} %count% Topics|{1} %count% Topic|]1,Inf[ %count% Topics' | transChoice count {count:count} }}
      </h2>

      <template v-else>
        <h2 class="uk-margin-remove">
          {{ '{1} %count% Topic selected|]1,Inf[ %count% Topics selected' | transChoice selected.length {count:selected.length} }}
        </h2>

        <div class="uk-margin-left">
          <ul class="uk-subnav pk-subnav-icon">
            <li>
              <a class="pk-icon-delete pk-icon-hover" title="Delete" data-uk-tooltip="{delay: 500}" @click="remove"
                   v-confirm="'Delete Topics?'"></a>
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

      <a class="uk-button uk-button-primary" :href="$url.route('admin/sermons/topics/edit')">
        {{ 'Add Topic' | trans }}
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
      <tr class="check-item" v-for="topic in topics" :class="{'uk-active': active(topic)}">
        <td>
          <input type="checkbox" name="id" :value="topic.id">
        </td>
        <td>
          <a :href="$url.route('admin/sermons/topics/edit', { id: topic.id })">{{ topic.name }}</a>
        </td>
        <td class="uk-text-center">
          {{ topic.sermon_count }}
        </td>
      </tr>
      </tbody>
    </table>
  </div>

  <h3 class="uk-h1 uk-text-muted uk-text-center" v-show="topics && !topics.length">
    {{ 'No topics found.' | trans }}
  </h3>

  <v-pagination :page.sync="config.page" :pages="pages" v-show="pages > 1 || page > 0"></v-pagination>

</div>
