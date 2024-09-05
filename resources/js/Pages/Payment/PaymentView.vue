<template>
    <DashboardLayout title="Payments" subtitle="Payments">
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
        <main class="my-5">
            <fwb-table striped-columns>
                <fwb-table-head>
                    <fwb-table-head-cell>No</fwb-table-head-cell>
                    <fwb-table-head-cell>Customer</fwb-table-head-cell>
                    <fwb-table-head-cell>Amount</fwb-table-head-cell>
                    <fwb-table-head-cell> Method</fwb-table-head-cell>
                    <fwb-table-head-cell>Status</fwb-table-head-cell>
                    <fwb-table-head-cell>Date</fwb-table-head-cell>
                    <fwb-table-head-cell>#</fwb-table-head-cell>
                </fwb-table-head>
                <fwb-table-body>
                    <fwb-table-row v-for="(payment, i) in payments.data">
                        <fwb-table-cell>{{
                            i +
                            1 +
                            (payments.meta.current_page - 1) *
                                payments.meta.per_page
                        }}</fwb-table-cell>
                        <fwb-table-cell>{{
                            payment.order.customer_name
                        }}</fwb-table-cell>
                        <fwb-table-cell>{{
                            Intl.NumberFormat("id").format(payment.amount)
                        }}</fwb-table-cell>
                        <fwb-table-cell>{{
                            payment.payment_method
                        }}</fwb-table-cell>
                        <fwb-table-cell
                            ><FwbBadge
                                :class="
                                    payment.payment_status == 'deny'
                                        ? 'bg-red-500'
                                        : ''
                                "
                                >{{ payment.payment_status }}</FwbBadge
                            ></fwb-table-cell
                        >
                        <fwb-table-cell>{{
                            payment.payment_date
                        }}</fwb-table-cell>

                        <fwb-table-cell class="flex gap-x-1">
                            <div v-show="payment.payment_status">
                                <FwbButton size="xs">Detail</FwbButton>
                                <FwbButton size="xs" color="green"
                                    >Print</FwbButton
                                >
                            </div>
                        </fwb-table-cell>
                    </fwb-table-row>
                </fwb-table-body>
            </fwb-table>
            <!-- pagination -->
            <div class="mt-5">
                <ul class="flex items-center -space-x-px h-10 text-base">
                    <li v-for="link in payments.meta.links">
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
                        Showing {{ payments.meta.from }} to
                        {{ payments.meta.to }} from
                        {{ payments.meta.total }} results
                    </small>
                </div>
            </div>
        </main>
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from "../../../Layouts/DashboardLayout.vue";
import {
    FwbA,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
    FwbButton,
    FwbInput,
    FwbBadge,
} from "flowbite-vue";
import { usePage, useForm } from "@inertiajs/vue3";
defineProps({
    payments: {
        type: Object,
    },
});

const formFilter = useForm({
    startDate: null,
    endDate: null,
});

function filterDate() {
    formFilter.get(route("payments.index"), {
        preserveScroll: true,
        preserveState: true,
    });
}
</script>
