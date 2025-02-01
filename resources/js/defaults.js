export const pages = [10, 20, 30, 40, 50, 60, 70, 80, 90, 100];
export const methods = {
    'add': "create",
    'edit': "update",
    'delete': "remove",
    'status': "change-status",
    'assign': "assign"
}
export const swalConfirmMsg = {
    'add': () => ({
        title: "Are you sure?",
        text: "Do you want to create this item?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#188a42",
        cancelButtonText: '<i class="bi bi-hand-thumbs-down"></i> No',
        confirmButtonText: '<i class="bi bi-hand-thumbs-up"></i> Yes',
    }),
    'edit': () => ({
        title: "Are you sure?",
        text: "Do you want to update this item?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#188a42",
        cancelButtonText: '<i class="bi bi-hand-thumbs-down"></i> No',
        confirmButtonText: '<i class="bi bi-hand-thumbs-up"></i> Yes',
    }),
    'delete': (items = 0) => ({
        title: "Are you sure?",
        text: `Are you sure you want to remove this ${items.length <= 1 ? "item" : "items"}?`,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#EF4444",
        cancelButtonText: '<i class="bi bi-hand-thumbs-down"></i> No',
        confirmButtonText: '<i class="bi bi-hand-thumbs-up"></i> Yes',
    }),
    'status': () => ({
        title: "Are you sure?",
        text: "Do you want to change the status of this item?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#188a42",
        cancelButtonText: '<i class="bi bi-hand-thumbs-down"></i> No',
        confirmButtonText: '<i class="bi bi-hand-thumbs-up"></i> Yes',
    }),
    'assign': () => ({
        title: "Are you sure?",
        text: "Do you want to assign this item to the user?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#188a42",
        cancelButtonText: '<i class="bi bi-hand-thumbs-down"></i> No',
        confirmButtonText: '<i class="bi bi-hand-thumbs-up"></i> Yes',
    })
}
export const swalSuccessMsg = {
    'add': () => ({
        title: "Item Created!",
        text: "Your item has been successfully created.",
        icon: "success",
        showConfirmButton: false,
    }),
    'edit': () => ({
        title: "Item Updated!",
        text: "Your item has been successfully updated.",
        icon: "success",
        showConfirmButton: false,
    }),
    'delete': (items = 0) => ({
        title: "Item Removed!",
        text: `The ${items.length <= 1 ? "item" : "items"} has been successfully removed.`,
        icon: "success",
        showConfirmButton: false,
    }),
    'status': () => ({
        title: "Status Changed!",
        text: "The status of the item has been successfully changed.",
        icon: "success",
        showConfirmButton: false,
    }),
    'assign': () => ({
        title: "Item Assigned!",
        text: "The item has been successfully assigned to the user.",
        icon: "success",
        showConfirmButton: false,
    })
}