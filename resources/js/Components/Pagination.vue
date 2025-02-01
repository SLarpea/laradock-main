<script setup>
import { ref, toRefs, watch } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
  data: Object,
});

const { data } = toRefs(props);

const paginationArray = (
  current_page,
  last_page,
  show_pagination_button = 3
) => {
  let lists = Array.from({ length: last_page }, (_, i) => i + 1);

  if (lists.length <= show_pagination_button) return lists;

  let current_page_index = lists.indexOf(current_page);
  let start_index = Math.max(
    0,
    Math.min(current_page_index - 1, lists.length - show_pagination_button)
  );

  return lists.slice(start_index, start_index + show_pagination_button);
};

const findPageLink = (links, item) => {
  return links.find((link) => link.label == item).url;
};
</script>
<template>
  <div class="row pagination-row">
    <div class="col-8 d-flex align-items-center">
      <small class="float-left"
        >Showing {{ data.from ?? 0 }} to {{ data.per_page }} of
        {{ data.total }} entries</small
      >
    </div>
    <div class="col-4">
      <ul class="pagination pagination-sm m-0 float-right">
        <li class="page-item" :class="{ disabled: data.prev_page_url == null }">
          <Link :href="data.prev_page_url ?? '#'" class="page-link"
            >&laquo;</Link
          >
        </li>
        <template
          v-for="(item, i) in paginationArray(
            data.current_page,
            data.last_page
          )"
          :key="i"
        >
          <li class="page-item" :class="{ active: item == data.current_page }">
            <Link
              :href="findPageLink(data.links, item)"
              class="page-link"
              >{{ item }}</Link
            >
          </li>
        </template>
        <li class="page-item" :class="{ disabled: data.next_page_url == null }">
          <Link :href="data.next_page_url ?? '#'" class="page-link"
            >&raquo;</Link
          >
        </li>
      </ul>
    </div>
  </div>
</template>