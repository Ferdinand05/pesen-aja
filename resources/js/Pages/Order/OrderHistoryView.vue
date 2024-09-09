<template>
    <DashboardLayout title="Order History" subtitle="Order History">
        <main>
            <div class="my-5">
                <p>Semua history Order yang masuk</p>
            </div>
            <small>Filter berdasarkan range tanggal : </small>
            <div
                class="grid grid-cols-1 space-y-1 md:space-y-0 md:grid-cols-3 gap-x-3"
            >
                <div>
                    <FwbInput
                        type="date"
                        size="sm"
                        v-model="formFilter.startDate"
                        @change="filterDate()"
                    ></FwbInput>
                </div>
                <div>
                    <FwbInput
                        type="date"
                        size="sm"
                        v-model="formFilter.endDate"
                        @change="filterDate()"
                    ></FwbInput>
                </div>
            </div>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table
                    class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                >
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                        <tr>
                            <th scope="col" class="px-6 py-3">No.</th>
                            <th scope="col" class="px-6 py-3">Customer</th>
                            <th scope="col" class="px-6 py-3">Table</th>
                            <th scope="col" class="px-6 py-3">Total</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Code</th>
                            <th scope="col" class="px-6 py-3">Created at</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700"
                            v-for="(order, i) in orderHistory.data"
                        >
                            <th
                                scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            >
                                {{ i + 1 }}
                            </th>
                            <td class="px-6 py-4">{{ order.customer_name }}</td>
                            <td class="px-6 py-4">{{ order.table_number }}</td>
                            <td class="px-6 py-4">{{ order.total }}</td>
                            <td class="px-6 py-4">
                                {{ order.status }}
                            </td>
                            <td>{{ order.order_code }}</td>
                            <td class="px-6 py-4">
                                {{ new Date(order.created_at) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- pagination -->
            <div class="mt-5 mb-3">
                <ul class="flex items-center -space-x-px h-10 text-base">
                    <li v-for="link in orderHistory.links">
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
                        Showing {{ orderHistory.from }} to
                        {{ orderHistory.to }} from
                        {{ orderHistory.total }} results
                    </small>
                </div>
            </div>
        </main>
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from "../../../Layouts/DashboardLayout.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { FwbInput, FwbBadge, FwbButton } from "flowbite-vue";
defineProps({
    orderHistory: Object,
});

const formFilter = useForm({
    startDate: null,
    endDate: null,
});

function filterDate() {
    formFilter.get(route("orders.history"), {
        preserveScroll: true,
        preserveState: true,
    });
}
</script>
