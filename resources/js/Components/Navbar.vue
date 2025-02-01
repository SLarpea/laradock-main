<script setup>
import { router, usePage } from "@inertiajs/vue3";
import { computed, inject, ref } from "vue";

const swal = inject("$swal");
const global = inject("globalVar");
const page = usePage();

const locale = computed(() => page.props.locale);

const logout = () => {
  swal({
    text: "You want to logout?",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#90646E",
    cancelButtonText: "Cancel",
    confirmButtonText: "Confirm",
  }).then((result) => {
    if (result.isConfirmed) {
      router.post(
        route("logout"),
        {},
        {
          onStart: () => (global.isLoading = true),
          onFinish: () => (global.isLoading = false),
        }
      );
    }
  });
};

const setLocale = (locale) => {
  if (page.props.locale == locale) return false;
  router.post(
    route('set.locale'),
    { locale: locale },
    {
      onStart: (visit) => {
        global.isLoading = true;
      },
      onSuccess: (page) => {
        global.isLoading = false;
      },
      onFinish: (visit) => {
        location.reload();
      },
      onError: (errors) => {
        console.log(error);
      },
    }
  )
}

</script>
<template>
  <nav class="main-header navbar navbar-expand">
    <!-- Left navbar links -->
    <ul class="navbar-nav d-flex align-items-center">
      <li class="nav-item">
        <a class="nav-link nav-bars" data-widget="pushmenu" href="#" role="button"
          ><i class="fas fa-bars ml-2"></i
        ></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <span class="nav-link">Welcome to ProjectCMS</span>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a
          class="language nav-link text-sm d-flex align-items-center"
          data-toggle="dropdown"
          href="#"
        >
          <i class="bi bi-translate mr-2"></i>
          <span class="d-none d-md-block dropdown-toggle">{{ $page.props.locale == 'en' ? "en-US" : "zh-CN" }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-md dropdown-menu-arrow dropdown-menu-right locale">
          <li>
            <button
              class="dropdown-item d-flex align-items-center"
              :class="{ 'active': locale == 'zh_CN' }"
              @click="setLocale('zh_CN')"
            >
              <i class="flag-icon flag-icon-cn mr-2"></i>
              zh-CN
            </button>
          </li>
          <li>
            <button
              class="dropdown-item d-flex align-items-center"
              :class="{ 'active': locale == 'en' }"
              @click="setLocale('en')"
            >
              <i class="flag-icon flag-icon-us mr-2"></i>
              en-US
            </button>
          </li>
        </ul>
      </li>
      <li class="nav-item dropdown">
        <a
          class="nav-link text-sm d-flex align-items-center"
          data-toggle="dropdown"
          href="#"
        >
          <img :src="$page.props.auth.user.profile_photo_url" alt="Profile" />
            <span class="d-none d-md-block dropdown-toggle ml-2">{{
              $page.props.auth.user.name
            }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-arrow dropdown-menu-right profile text-sm">
          <li class="dropdown-header">
            <h6>{{ $page.props.auth.user.name }}</h6>
            <!-- <span>{{ $page.props.auth.user.roles[0].name }}</span> -->
          </li>
          <li>
            <hr class="dropdown-divider" />
          </li>

          <li>
            <a
              class="dropdown-item d-flex align-items-center"
              href="/user/profile"
            >
              <i class="bi bi-person mr-2"></i>
              <span>My Profile</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider" />
          </li>

          <li>
            <a
              class="dropdown-item d-flex align-items-center"
              href="/user/activity"
            >
              <i class="bi bi-activity mr-2"></i>
              <span>My Activity</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider" />
          </li>

          <li>
            <button
              class="dropdown-item d-flex align-items-center"
              @click.prevent="logout"
            >
              <i class="bi bi-box-arrow-right mr-2"></i>
              <span>Sign Out</span>
            </button>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
</template>