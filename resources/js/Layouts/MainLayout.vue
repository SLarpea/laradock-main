<script setup>
import { ref } from "vue";
import { inject } from "@vue/runtime-core";
import { Head, router } from "@inertiajs/vue3";
import PageLoader from "@/Components/PageLoader.vue";
import NavBar from "@/Components/Navbar.vue";
import SideBar from "@/Components/Sidebar.vue";
import Header from "@/Components/Header.vue";
import Footer from "@/Components/Footer.vue";

defineProps({
  module: String,
  headerModule: String,
  includeAddBtn: {
    type: Boolean,
    default: false,
  },
  includeDeleteBtn: {
    type: Boolean,
    default: false,
  }
});

const global = inject("globalVar");
</script>

<template>
  <div class="wrapper">
    <PageLoader :loading="global.isLoading" />

    <Head :title="module" />
    <NavBar />
    <SideBar :module="module" />
    <div class="content-wrapper">
      <section class="content">
        <div>
          <Header
            :header-module="headerModule"
            :module="module" 
            :include-add-btn="includeAddBtn" 
            :include-delete-btn="includeDeleteBtn" 
          />
          <main>
            <slot />
          </main>
        </div>
      </section>
      <Footer />
    </div>
  </div>
</template>