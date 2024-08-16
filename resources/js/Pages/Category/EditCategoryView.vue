<template>
    <DashboardLayout title="Edit Category" subtitle="Form Edit Category">
        <div class="border p-5 rounded-md shadow w-full md:w-1/2">
            <div>
                <form method="post" action="" @submit.prevent>
                    <InputComponent
                        id="name"
                        placeholder="Category"
                        v-model="form.name"
                        label="Name : "
                        error=""
                    >
                    </InputComponent>
                    <ButtonComponent
                        type="submit"
                        :disabled="form.processing"
                        @click="updateCategory()"
                        >Update</ButtonComponent
                    >
                </form>

                <div class="bg-gray-100 rounded-sm py-1 px-2">
                    <div class="text-sm font-medium">
                        Products from {{ form.name }} :
                    </div>

                    <ul>
                        <li
                            class="text-sm list-decimal ms-4"
                            v-for="product in $page.props.category.products"
                        >
                            {{ product.name }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import DashboardLayout from "../../../Layouts/DashboardLayout.vue";
import InputComponent from "../../../Components/InputComponent.vue";
import ButtonComponent from "../../../Components/ButtonComponent.vue";
import Swal from "sweetalert2";
const page = usePage();

const form = useForm({
    id: page.props.category.id,
    name: page.props.category.name,
});

function updateCategory() {
    form.put(route("categories.update", form.id), {
        preserveScroll: true,
    });
}
</script>
