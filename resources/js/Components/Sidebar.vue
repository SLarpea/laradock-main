<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3'

defineProps({
  module: String,
});

const page = usePage();

// const userPermissions = computed(() => page.props.auth.user.permissions);
// const userRole = computed(() => page.props.auth.user.roles[0].name);

</script>

<template>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar">
    <div class="brand-logo">
      <i class="bi bi-person-workspace"></i>
      <span>ProjectCMS</span>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-3">
        <ul
          class="nav nav-pills nav-sidebar flex-column"
          data-widget="treeview"
          role="menu"
          data-accordion="false"
        >
          <li class="nav-item" :class="{ active: module === 'Dashboard' }">
            <!-- <a href="/dashboard" class="nav-link text-sm">
              <i class="nav-icon fas fa-th"></i>
              <span>Dashboard</span>
            </a> -->
            <Link tag="a" href="/dashboard" class="nav-link text-sm"><i class="nav-icon fas fa-th"></i> Dashboard</Link>
          </li>
          <li class="nav-header">MODULES</li>
          <li class="nav-item" :class="{ active: module === 'Shops' }">
            <a href="/shops" class="nav-link text-sm">
              <i class="nav-icon bi bi-shop-window"></i>
              <span>Shops</span>
            </a>
          </li>
          <li class="nav-header">SETTINGS</li>
          <li class="nav-item" :class="{ active: module === 'Roles' }">
            <!-- <a href="/roles" class="nav-link text-sm">
              <i class="nav-icon bi bi-person-circle"></i>
              <span>Roles</span>
            </a> -->
            <Link tag="a" href="/roles" class="nav-link text-sm"><i class="nav-icon bi bi-person-circle"></i> Roles</Link>
          </li>
          <li class="nav-item">
            <a href="/user-roles" class="nav-link text-sm">
              <i class="nav-icon bi bi-person-bounding-box"></i>
              <span>User Roles</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/calendar.html" class="nav-link text-sm">
              <i class="nav-icon far fa-calendar-alt"></i>
              <span>Calendar</span>
              <span class="badge badge-info right">2</span>
            </a>
          </li>
          <li class="nav-item not-link">
            <a href="#" class="nav-link text-sm">
              <i class="nav-icon fas fa-search"></i>
              <span>Search</span>
              <i class="fas fa-angle-left right"></i>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item active">
                <a href="pages/search/simple.html" class="nav-link link text-sm">
                  <i class="far fa-circle nav-icon"></i>
                  <span>Simple Search</span>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/search/enhanced.html" class="nav-link link text-sm">
                  <i class="far fa-circle nav-icon"></i>
                  <span>Enhanced</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-header">API DOCUMENTATION</li>
          <li class="nav-item">
            <a href="/swagger/docu" class="nav-link text-sm">
              <i class="nav-icon bi bi-braces"></i>
              <span>Swagger</span>
            </a>
          </li>
          <li class="nav-header">WEB APP TRACKER</li>
          <li class="nav-item">
            <a href="/pulse/track" class="nav-link text-sm">
              <i class="nav-icon bi bi-clipboard2-pulse"></i>
              <span>Pulse</span>
            </a>
          </li>
          <li class="nav-item">
            <a href="/logs" class="nav-link text-sm">
              <i class="nav-icon bi bi-list-columns-reverse"></i>
              <span>Activity Logs</span>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </aside>
</template>