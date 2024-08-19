<template>
    <DashboardLayout title="Users" subtitle="Users">
        <div class="space-y-5">
            <div>
                <ModalComponent ref="modalRef" buttonType="Create User">
                    <template #header> Create new User </template>
                    <template #body>
                        <form
                            @submit.prevent="createUser()"
                            method="post"
                            class="space-y-4"
                        >
                            <div>
                                <FwbInput
                                    label="Name : "
                                    v-model="form.name"
                                    placeholder="Your Name"
                                ></FwbInput>
                                <small class="text-red-600">{{
                                    $page.props.errors.name
                                }}</small>
                            </div>
                            <div>
                                <FwbInput
                                    label="Email : "
                                    type="email"
                                    placeholder="Your Email"
                                    v-model="form.email"
                                ></FwbInput>
                                <small class="text-red-600">{{
                                    $page.props.errors.email
                                }}</small>
                            </div>
                            <div>
                                <FwbSelect
                                    v-model="form.role"
                                    :options="roles"
                                    label="Select a Role"
                                />
                                <small class="text-red-600">{{
                                    $page.props.errors.role
                                }}</small>
                            </div>
                            <div>
                                <FwbInput
                                    type="password"
                                    label="Password : "
                                    v-model="form.password"
                                ></FwbInput>
                                <small class="text-red-600">{{
                                    $page.props.errors.password
                                }}</small>
                            </div>
                            <div>
                                <FwbInput
                                    type="password"
                                    label="Password Confirmation : "
                                    v-model="form.password_confirmation"
                                ></FwbInput>
                            </div>
                            <FwbButton type="submit" :disabled="form.processing"
                                >Submit</FwbButton
                            >
                        </form>
                    </template>
                    <template #footer> &nbsp; </template>
                </ModalComponent>
            </div>
            <div>
                <fwb-table hoverable stripedColumns>
                    <fwb-table-head>
                        <fwb-table-head-cell>No.</fwb-table-head-cell>
                        <fwb-table-head-cell>Name</fwb-table-head-cell>
                        <fwb-table-head-cell>Email</fwb-table-head-cell>
                        <fwb-table-head-cell>Role</fwb-table-head-cell>
                        <fwb-table-head-cell>Created at</fwb-table-head-cell>
                        <fwb-table-head-cell> Action </fwb-table-head-cell>
                    </fwb-table-head>
                    <fwb-table-body>
                        <fwb-table-row v-for="(user, index) in users">
                            <fwb-table-cell>{{ index + 1 }}</fwb-table-cell>
                            <fwb-table-cell>{{ user.name }}</fwb-table-cell>
                            <fwb-table-cell>{{ user.email }}</fwb-table-cell>
                            <fwb-table-cell>{{ user.role }}</fwb-table-cell>
                            <fwb-table-cell>{{
                                new Date(user.created_at).toLocaleDateString(
                                    "id",
                                    {
                                        year: "numeric",
                                        month: "long",
                                        day: "2-digit",
                                    }
                                )
                            }}</fwb-table-cell>
                            <fwb-table-cell class="flex">
                                <ModalComponent
                                    buttonType="Edit"
                                    ref="modalEditRef"
                                >
                                    <template #header>
                                        <h4>
                                            Edit <b>{{ user.name }}</b>
                                        </h4>
                                    </template>
                                    <template #body>
                                        <form
                                            @submit.prevent="
                                                updateUser(user, index)
                                            "
                                            method="post"
                                            class="text-start space-y-4"
                                        >
                                            <div>
                                                <FwbInput
                                                    label="Name : "
                                                    v-model="user.name"
                                                ></FwbInput>
                                                <small class="text-red-600">{{
                                                    $page.props.errors.name
                                                }}</small>
                                            </div>
                                            <div>
                                                <FwbInput
                                                    label="Email : "
                                                    type="email"
                                                    v-model="user.email"
                                                ></FwbInput>
                                                <small class="text-red-600">{{
                                                    $page.props.errors.email
                                                }}</small>
                                            </div>
                                            <div>
                                                <FwbSelect
                                                    v-model="user.role"
                                                    :options="roles"
                                                    label="Select a Role"
                                                />
                                                <small class="text-red-600">{{
                                                    $page.props.errors.role
                                                }}</small>
                                            </div>
                                            <div>
                                                <FwbButton type="submit"
                                                    >Update</FwbButton
                                                >
                                            </div>
                                        </form>
                                    </template>
                                    <template #footer> </template>
                                </ModalComponent>
                                <FwbButton
                                    size="sm"
                                    color="red"
                                    class="ms-1"
                                    @click="destroyUser(user.id)"
                                    >Delete</FwbButton
                                >
                            </fwb-table-cell>
                        </fwb-table-row>
                    </fwb-table-body>
                </fwb-table>
            </div>
        </div>
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from "../../../Layouts/DashboardLayout.vue";
import ModalComponent from "../../../Components/ModalComponent.vue";
import {
    FwbButton,
    FwbInput,
    FwbSelect,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
} from "flowbite-vue";
import Swal from "sweetalert2";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
defineProps({
    users: Array,
});
const form = useForm({
    name: null,
    email: null,
    role: "",
    password: null,
    password_confirmation: null,
});

const roles = [
    { value: "Waitress", name: "Waitress" },
    { value: "Manager", name: "Manager" },
    { value: "Kasir", name: "Kasir" },
];

const modalRef = ref(null);
function createUser() {
    form.post(route("users.store"), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset("password", "password_confirmation", "role", "email");
            modalRef.value.closeModal();
        },
    });
}
const modalEditRef = ref(null);

function updateUser(user, index) {
    const formEdit = useForm({
        name: user.name,
        email: user.email,
        role: user.role,
    });

    formEdit.put(route("users.update", user.id), {
        preserveScroll: true,
        onSuccess: () => {
            modalEditRef.value[index].closeModal();
        },
    });
}

function destroyUser(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route("users.destroy", id));
        }
    });
}
</script>
