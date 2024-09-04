<template>
    <DashboardLayout title="Edit Product" subtitle="Edit Product">
        <div class="w-1/2 mt-10">
            <form
                @submit.prevent="updateProduct()"
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
                    <small class="text-red-600">{{ form.errors.name }}</small>
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
                    <small class="text-red-600">{{ form.errors.price }}</small>
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

                    <img
                        v-if="form.image_preview"
                        :src="form.image_preview"
                        class="max-w-52 mt-1 max-h-48 object-cover rounded"
                    />
                    <img
                        v-else
                        :src="imageUrl + $page.props.product.image"
                        class="max-w-52 mt-1 max-h-48 object-cover rounded"
                    />
                    <small class="text-red-600">{{ form.errors.image }}</small>
                </div>
                <div>
                    <FwbButton type="submit">Update</FwbButton>
                </div>
            </form>
        </div>
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from "../../../Layouts/DashboardLayout.vue";
import {
    FwbInput,
    FwbFileInput,
    FwbButton,
    FwbSelect,
    FwbImg,
} from "flowbite-vue";
import { usePage, useForm } from "@inertiajs/vue3";
defineProps({ product: Object });
const page = usePage({});
const categoryOptions = [];
page.props.categories.forEach((c) => {
    categoryOptions.push({ value: c.id, name: c.name });
});

const form = useForm({
    id: page.props.product.id,
    name: page.props.product.name,
    description: page.props.product.description,
    category_id: page.props.product.category_id,
    price: page.props.product.price,
    image: null,
    image_preview: null,
    _method: "put",
});
const imageUrl = "/storage/product-image/";
function changeImage(e) {
    form.image = e.target.files[0];
    form.image_preview = URL.createObjectURL(e.target.files[0]);
}

function updateProduct() {
    form.post(route("products.update", form.id), {
        forceFormData: true,
        preserveScroll: true,
    });
}
</script>
