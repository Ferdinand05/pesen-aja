<template>
    <DashboardLayout title="Categories" subtitle="Categories">
        <div class="space-y-3">
            <div>
                <ModalComponent ref="modalRef" buttonType="Create Category">
                    <template #header>
                        <h4>Create new Category</h4>
                    </template>
                    <template #body>
                        <form method="post">
                            <!-- body -->
                            <div>
                                <InputComponent
                                    id="name"
                                    label="Name : "
                                    placeholder="Food"
                                    v-model="form.name"
                                    :error="form.errors.name"
                                ></InputComponent>
                            </div>
                        </form>
                    </template>

                    <!-- footer -->
                    <template #footer>
                        <button
                            type="submit"
                            @click="createCategory()"
                            class="text-white bg-blue-700 disabled:bg-blue-300 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            :disabled="form.processing"
                        >
                            Submit
                        </button>
                    </template>
                </ModalComponent>
            </div>

            <!-- table -->
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table
                    class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                >
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                        <tr>
                            <th scope="col" class="px-6 py-3">No</th>
                            <th scope="col" class="px-6 py-3">Category Name</th>
                            <th scope="col" class="px-6 py-3">Count</th>
                            <th scope="col" class="px-6 py-3">Created at</th>
                            <th scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(c, i) in categories"
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                        >
                            <th
                                scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            >
                                {{ i + 1 }}
                            </th>
                            <td class="px-6 py-4">{{ c.name }}</td>
                            <td class="px-6 py-4">{{ c.products.length }}</td>
                            <td class="px-6 py-4">
                                {{
                                    new Date(c.created_at).toLocaleDateString(
                                        "id-ID",
                                        {
                                            year: "numeric",
                                            month: "long",
                                            day: "2-digit",
                                        }
                                    )
                                }}
                            </td>
                            <td class="px-6 py-4 space-x-2">
                                <Link
                                    :href="route('categories.edit', c.id)"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                    >Edit</Link
                                >

                                <Link
                                    href=""
                                    as="button"
                                    @click.prevent="destroyCategory(c.id)"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline"
                                    >Delete</Link
                                >
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-gray-600 text-sm">
                Total : {{ categories.length }}
            </div>
        </div>
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from "../../../Layouts/DashboardLayout.vue";
import ModalComponent from "../../../Components/ModalComponent.vue";
import InputComponent from "../../../Components/InputComponent.vue";
import { useForm } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import { ref } from "vue";
defineProps({
    categories: Array,
});
const form = useForm({
    name: null,
});
const modalRef = ref(null);

function callCloseModal() {
    modalRef.value.closeModal();
}

function createCategory() {
    form.post(route("categories.store"), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset("name");
            callCloseModal();
        },
    });
}

function destroyCategory(id) {
    console.log(id);
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
            form.delete(route("categories.destroy", id), {
                onSuccess: () => {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success",
                    });
                },
            });
        }
    });
}
</script>
