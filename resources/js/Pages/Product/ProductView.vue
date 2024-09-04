<template>
    <DashboardLayout title="Products" subtitle="Products">
        <main class="space-y-5 mb-20">
            <div>
                <ModalComponent ref="modalRef" buttonType="Create Product">
                    <template #header> Add new product </template>
                    <template #body>
                        <form
                            @submit.prevent="createProduct()"
                            method="post"
                            class="space-y-3"
                            enctype="multipart/form-data"
                        >
                            <div>
                                <FwbInput
                                    label="Product Name "
                                    type="text"
                                    v-model="form.name"
                                ></FwbInput>
                                <small class="text-red-600">{{
                                    form.errors.name
                                }}</small>
                            </div>
                            <div>
                                <FwbInput
                                    label="Description"
                                    type="text"
                                    v-model="form.description"
                                ></FwbInput>
                                <small class="text-red-600">{{
                                    form.errors.description
                                }}</small>
                            </div>
                            <div>
                                <FwbInput
                                    label="Price"
                                    type="number"
                                    v-model="form.price"
                                ></FwbInput>
                                <small class="text-red-600">{{
                                    form.errors.price
                                }}</small>
                            </div>
                            <div>
                                <FwbSelect
                                    :options="categoryOptions"
                                    label="Select a category"
                                    v-model="form.category_id"
                                ></FwbSelect>
                                <small class="text-red-600">{{
                                    form.errors.category_id
                                }}</small>
                            </div>
                            <div>
                                <FwbFileInput
                                    label="Product Image"
                                    @change="changeImage($event)"
                                ></FwbFileInput>
                                <FwbImg
                                    v-if="form.image_preview"
                                    :src="form.image_preview"
                                    class="max-w-52 mt-1 max-h-48 object-cover rounded"
                                ></FwbImg>
                                <small class="text-red-600">{{
                                    form.errors.image
                                }}</small>
                            </div>
                            <div>
                                <FwbButton color="blue" type="submit"
                                    >Submit</FwbButton
                                >
                            </div>
                        </form>
                    </template>
                </ModalComponent>
            </div>
            <div>
                <fwb-table striped>
                    <fwb-table-head>
                        <fwb-table-head-cell>No</fwb-table-head-cell>
                        <fwb-table-head-cell>Product Name</fwb-table-head-cell>
                        <fwb-table-head-cell>Category</fwb-table-head-cell>
                        <fwb-table-head-cell>Price</fwb-table-head-cell>
                        <fwb-table-head-cell>Action</fwb-table-head-cell>
                    </fwb-table-head>
                    <fwb-table-body>
                        <fwb-table-row v-for="(p, i) in products.data">
                            <fwb-table-cell>{{
                                i +
                                1 +
                                (products.current_page - 1) * products.per_page
                            }}</fwb-table-cell>
                            <fwb-table-cell>
                                {{ p.name }}
                            </fwb-table-cell>
                            <fwb-table-cell>{{
                                p.category.name
                            }}</fwb-table-cell>
                            <fwb-table-cell>{{
                                Intl.NumberFormat("id").format(p.price)
                            }}</fwb-table-cell>
                            <fwb-table-cell>
                                <div class="flex items-center gap-x-1">
                                    <Link
                                        :href="route('products.edit', p.id)"
                                        as="button"
                                        class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-1.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900"
                                    >
                                        Edit
                                    </Link>
                                    <Link
                                        as="button"
                                        type="button"
                                        href="#"
                                        @click="destroyProduct(p.id)"
                                        class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-1.5 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-purple-900"
                                    >
                                        Delete
                                    </Link>
                                </div>
                            </fwb-table-cell>
                        </fwb-table-row>
                    </fwb-table-body>
                </fwb-table>
                <!-- pagination -->
                <div class="mt-5">
                    <ul class="flex items-center -space-x-px h-10 text-base">
                        <li v-for="link in products.links">
                            <Link
                                :href="link.url || ''"
                                v-html="link.label"
                                :class="{
                                    'flex items-center justify-center px-4 h-10 leading-tight text-gray-600 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white font-medium':
                                        link.active,
                                    'flex items-center justify-center px-4 h-10 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white':
                                        !link.active,
                                }"
                            ></Link>
                        </li>
                    </ul>
                    <div>
                        <small>
                            Showing {{ products.from }} to
                            {{ products.to }} from {{ products.total }} results
                        </small>
                    </div>
                </div>
            </div>
        </main>
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from "../../../Layouts/DashboardLayout.vue";
import { useForm } from "@inertiajs/vue3";
import ModalComponent from "../../../Components/ModalComponent.vue";
import {
    FwbInput,
    FwbFileInput,
    FwbSelect,
    FwbImg,
    FwbButton,
    FwbA,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
} from "flowbite-vue";

import Swal from "sweetalert2";
import { usePage } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps({
    products: Object,
});

const page = usePage();

const categoryOptions = [];
page.props.categories.forEach((c) => {
    categoryOptions.push({ value: c.id, name: c.name });
});

const form = useForm({
    name: null,
    description: null,
    price: null,
    image: null,
    category_id: "",
    image_preview: null,
});

const modalRef = ref(null);
function createProduct() {
    form.post(route("products.store"), {
        forceFormData: true,
        onSuccess: () => {
            modalRef.value.closeModal();
            form.reset(
                "image",
                "image_preview",
                "description",
                "name",
                "category_id",
                "price"
            );
        },
    });
}

function changeImage(e) {
    form.image = e.target.files[0];
    form.image_preview = URL.createObjectURL(e.target.files[0]);
}
function destroyProduct(id) {
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
            form.delete(route("products.destroy", id), {
                preserveScroll: true,
            });
        }
    });
}
</script>
