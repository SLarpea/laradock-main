<script setup>
import VOnClickOutside from "../Directives/clickOutside";
import { pages } from "@/defaults";
import { inject, reactive, ref, watch } from "vue";

const global = inject("globalVar");
const emit = defineEmits(['updateQueryParams']);

let initialState = {
  per_page: route().params.per_page ?? 10
}
const search = ref("");
const isOpen = ref(false);
const queryParams = reactive({ ...initialState });

const closeOption = () => {
  isOpen.value = false;
};

const chosePage = (val) => {
  queryParams.per_page = val
};

const findSearch = () => {
  if (search.value) {
    var initialQueryState = { ...queryParams, ["search"]: search.value };
    Object.assign(queryParams, initialQueryState);
    emit("updateQueryParams", queryParams);
  } else {
    delete queryParams['search'];
    emit("updateQueryParams", queryParams);
  }
};

watch(() => queryParams.per_page, (pageCount) => {
  emit("updateQueryParams", queryParams);
});
</script>
<template>
  <div class="row no-gutters">
    <div class="col-12 col-sm-8 col-md-6 col-lg-4 search-input-wrapper">
      <div class="search-input">
        <input v-model="search" class="search" type="text" @keyup.enter="findSearch" />
      </div>
      <div class="search-btn" :class="{ 'disabled': global.isSearchLoading == true }" @click.prevent="findSearch">
        <template v-if="global.isSearchLoading">
          <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
          <span class="sr-only">Loading...</span>
        </template>
        <i v-else class="bi bi-search"></i>
      </div>
    </div>
    <div class="col-12 col-sm-4 col-md-6 col-lg-8 sort-wrapper">
      <div class="per-page-wrapper">
        <span>per page</span>
        <div
          class="per-page"
          v-on-click-outside:div="closeOption"
          @click.prevent="isOpen = !isOpen"
        >
          <span>{{ queryParams.per_page }}</span>
          <i class="fas fa-angle-down right"></i>
          <div class="options" :class="{ 'is-open': isOpen }">
            <span
              v-for="(item, idx) in pages"
              :key="idx"
              @click.prevent="chosePage(item)"
              :class="{ active: queryParams.per_page === item }"
            >
              {{ item }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>