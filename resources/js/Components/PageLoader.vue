<script setup>
defineProps({
    loading: Boolean
});
</script>
<template>
  <div
    class="preloader flex-column justify-content-center align-items-center"
    v-if="loading"
  >
    <img src="../../../public/img/pacman.gif" alt="">
    <span class="mt-lg-4 text-lg font-weight-normal text-white">Loading....</span>
  </div>
</template>