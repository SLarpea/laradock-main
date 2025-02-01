<script setup>
import { inject, onMounted, reactive, ref, watch } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import { getRouteName } from "@/helpers";
import { swalConfirmMsg, swalSuccessMsg } from "@/defaults";
import MainLayout from "@/Layouts/MainLayout.vue";
import SearchLayout from "@/Layouts/SearchLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import InputError from "@/Components/InputError.vue";

const swal = inject("$swal");
const global = inject("globalVar");

const props = defineProps({
  roles: Object,
  permissions: Object,
  permissions_count: Number,
});

let module = "roles";
let initialState = {
  id: null,
  name: "",
  permissions: [],
  status: 0,
};
const form = useForm({ ...initialState });
const originalForm = reactive({ ...initialState });
const formShow = ref(false);
const formAction = ref("");
const formURL = ref("");
const role = reactive({});
const roleStatus = ref([]);
const allPermissionsIndeterminate = ref(false);
const allPermissionsChkbox = ref(false);

const selectAction = (method, item = {}) => {
  formAction.value = method;
  formURL.value = getRouteName(module, method);
  switch (method) {
    case "view":
      Object.assign(role, { ...item });
      formShow.value = true;
      break;

    case "add":
      resetForm();
      formShow.value = true;
      break;

    case "status":
      Object.assign(role, { ...item });
      roleStatus.value[role.id] = role.status === 0 ? 1 : 0;
      fillForm(form);
      submit();
      break;

    case "delete":
      Object.assign(role, { ...item });
      resetForm();
      submit();
      break;

    default:
      Object.assign(role, { ...item });
      formShow.value = true;
      resetForm();
      break;
  }
};

const closeForm = () => {
  formShow.value = false;
  global.showAddForm = false;
  resetForm();
};

const resetForm = () => {
  form.clearErrors();
  switch (formAction.value) {
    case "add":
      Object.assign(form, { ...initialState });
      break;

    default:
      fillForm(form);
      fillForm(originalForm);
      break;
  }
};

const fillForm = (form) => {
  form.id = role.id ?? null;
  form.name = role.name ?? "";
  form.permissions = role.permissions.map((i) => i.name) ?? [];
  form.status = role.status ?? 0;
};

const formUnchanged = () => {
  return (
    JSON.stringify({
      id: form.id,
      name: form.name,
      permissions: form.permissions,
      status: form.status,
    }) === JSON.stringify(originalForm)
  );
};

const submit = () => {
  if (formAction.value == "edit" && formUnchanged()) {
    toast("The form hasn't been altered", {
      type: "warning",
      dangerouslyHTMLString: true,
    });
  } else {
    swal(swalConfirmMsg[formAction.value]()).then((result) => {
      if (result.isConfirmed) {
        form.post(route(formURL.value), {
          onStart: () => (global.isLoading = true),
          onSuccess: () => {
            swal(swalSuccessMsg[formAction.value]());
            closeForm();
          },
          onFinish: () => (global.isLoading = false),
        });
      } else {
        if (formAction.value == "status")
          roleStatus.value[role.id] = role.status;
        else closeForm();
      }
    });
  }
};

const handleUpdateQueryParams = (val) => {
  router.get(route("roles.index"), val, {
    preserveState: true,
    replace: true,
    onStart: () => (global.isSearchLoading = true),
    onFinish: () => (global.isSearchLoading = false),
  });
};

watch(
  () => props.roles.data,
  (newValue, oldValue) => {
    newValue.forEach((item) => {
      roleStatus.value[item.id] = item.status;
    });
  },
  { immediate: true, deep: true }
);

watch(
  () => form.permissions,
  (newValue, oldValue) => {
    if (newValue.length == 0 || newValue.length == props.permissions_count)
      allPermissionsIndeterminate.value = false;
    else allPermissionsIndeterminate.value = true;
  },
  { immediate: true, deep: true }
);

watch(allPermissionsChkbox, (val) => {
  if (val) {
    Object.keys(props.permissions).forEach((item) => {
      form.permissions.push(...props.permissions[item].map((i) => i.name));
    });
  } else {
    form.permissions = [];
  }
});

// watch(formShow, (newValue))

watch(
  () => global,
  (newValue, oldValue) => {
    if (newValue.showAddForm == true) selectAction('add');
  },
  { immediate: true, deep: true }
)
</script>

<template>
  <MainLayout module="Roles" header-module="Settings" :include-add-btn="true">
    <div class="px-6 pt-2 pb-6">
      <div class="page-content">
        <SearchLayout @update-query-params="handleUpdateQueryParams" />
        <div class="table-responsive">
          <table class="table table-sm table-striped table-bordered table-data">
            <colgroup>
              <!-- <col style="width: 1%" /> -->
              <col width="1%">
              <col width="*">
              <col width="1%">
              <col width="1%">
            </colgroup>
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Status</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Status</th>
                <th class="text-center">Action</th>
              </tr>
            </tfoot>
            <tbody>
              <tr v-for="(item, idx) in roles.data" :key="idx">
                <td class="text-center">{{ idx + 1 }}</td>
                <td>{{ item.name }}</td>
                <td class="text-center">
                  <div class="toggle">
                    <input type="checkbox" :id="'switch_' + item.id" :checked="roleStatus[item.id] === 1"
                      @click="selectAction('status', item)" v-tippy="(item.status === 1) ? 'Active' : 'Inactive'" />
                    <label :for="'switch_' + item.id"></label>
                  </div>
                </td>
                <td>
                  <div class="btn-groups">
                    <button type="button" class="btn btn-xs dropdown-toggle rounded-none" data-toggle="dropdown">
                      Select
                    </button>
                    <ul class="text-sm dropdown-menu dropdown-menu-md dropdown-menu-right">
                      <li>
                        <button type="button" class="dropdown-item py-1.5" @click.prevent="selectAction('edit', item)">
                          <i class="bi bi-pencil-square mr-2"></i>Edit
                        </button>
                      </li>
                      <li>
                        <button type="button" class="dropdown-item py-1.5" @click="selectAction('view', item)">
                          <i class="bi bi-eye mr-2"></i>View
                        </button>
                      </li>
                    </ul>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
        <Pagination :data="roles" />
      </div>
    </div>
  </MainLayout>
  <form @submit.prevent="submit">
    <transition name="modal-fade">
      <div v-if="formShow" class="modal custom-modal">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h6>{{ (formAction == 'add') ? "Add Role" : (formAction == 'edit') ? "Edit Role" : "Role Details" }}</h6>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click.prevent="closeForm">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <template v-if="formAction != 'view'">
                <div class="form-group floating" style="margin-bottom: 0.75rem;">
                  <input v-model="form.name" type="text" class="form-control floating" id="name" placeholder="Name" />
                  <label for="name">Name</label>
                  <InputError :message="form.errors.name" />
                </div>
                <div class="custom-form-input" style="margin-bottom: 0.75rem">
                  <span class="custom-input-label">Permissions</span>
                  <div class="select-all">
                    <input class="checkbox" id="checkbox_all" type="checkbox"
                      :indeterminate="allPermissionsIndeterminate" @click="allPermissionsChkbox = !allPermissionsChkbox"
                      :checked="allPermissionsChkbox" />
                    <label for="checkbox_all" class="checkbox">All</label>
                  </div>
                  <div v-for="(items, key, index) in permissions" :key="index" class="permission-module">
                    <span class="permission-module-label">{{ key }}</span>
                    <div class="permissions">
                      <div v-for="(permission, index) in items" :key="index" class="permission">
                        <input class="checkbox" v-model="form.permissions" :id="'checkbox_' + permission.id"
                          :value="permission.name" type="checkbox" />
                        <label :for="'checkbox_' + permission.id" class="checkbox">{{ permission.name }}</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="custom-form-input">
                  <span class="custom-input-label">Status</span>
                  <div class="status-wrapper" @click="form.status = form.status === 1 ? 0 : 1">
                    <div class="toggle">
                      <input type="checkbox" :checked="form.status === 1" />
                      <label></label>
                    </div>
                    <span class="status-label">{{
                      form.status === 1 ? "Active" : "Inactive"
                      }}</span>
                  </div>
                </div>
              </template>
              <template v-else>
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-striped table-view">
                    <colgroup>
                      <col width="25%" />
                      <col width="*" />
                    </colgroup>
                    <tbody>
                      <tr>
                        <td>
                          <strong>Name</strong>
                        </td>
                        <td>
                          <span>{{ role.name }}</span>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <strong>Permissions</strong>
                        </td>
                        <td>
                          <span v-for="(item, index) in role.permissions.map(i => i.name)" :key="index"
                            class="text-capitalize">
                            {{ item }} <br>
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <strong>Status</strong>
                        </td>
                        <td>
                          <span>{{ role.status == 1 ? "Active" : "Inactive" }}</span>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </template>
            </div>
            <div class="modal-footer">
              <span v-if="formAction != 'view'" class="text-xs">Assign permissions carefully, as they affect user
                access.</span>
              <div class="btn-footer">
                <button v-if="formAction != 'view'" type="submit" class="btn btn-sm btn-submit">
                  Submit
                </button>
                <button type="button" class="btn btn-secondary btn-sm btn-close" @click.prevent="closeForm">
                  Close
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </form>
</template>
