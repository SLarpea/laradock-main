<script setup>
import { inject } from 'vue';

defineProps({
    headerModule: {
        type: String,
        default: 'Home',
    },
    module: {
        type: String,
        default: 'Dashboard',
    },
    includeAddBtn: {
        type: Boolean,
        default: false,
    },
    includeDeleteBtn: {
        type: Boolean,
        default: false
    }
});

const global = inject('globalVar');

</script>

<template>
    <div class="header-page">
        <div class="header-wrapper">
            <div class="page-title">
                <p>{{ module }}</p>
                <div class="breadcrumb">
                    <ul class="breadcrumb-list">
                        <li class="link-icon">{{ headerModule }}</li>
                        <li>{{ module }}</li>
                    </ul>
                </div>
                <div class="buttons">
                    <button v-if="includeDeleteBtn" type="button" class="btn btn-sm btn-delete">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                    <button v-if="includeAddBtn" type="button" class="btn btn-sm btn-add" @click="global.showAddForm = true">
                        <i class="bi bi-plus-circle-dotted"></i> Add Item
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>