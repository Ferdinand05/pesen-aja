<template>
    <DashboardLayout title="Payments" subtitle="Payments">
        <small>Filter berdasarkan range tanggal : </small>
        <div
            class="grid grid-cols-1 space-y-1 md:space-y-0 md:grid-cols-3 gap-x-3"
        >
            <div>
                <FwbInput type="date" size="sm"></FwbInput>
            </div>
            <div>
                <FwbInput type="date" size="sm"></FwbInput>
            </div>
            <div>
                <FwbButton type="button">Filter</FwbButton>
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
                        <fwb-table-cell>{{
                            payment.payment_status
                        }}</fwb-table-cell>
                        <fwb-table-cell>{{
                            payment.payment_date
                        }}</fwb-table-cell>

                        <fwb-table-cell class="flex gap-x-1"
                            ><FwbButton size="xs">Detail</FwbButton>
                            <FwbButton size="xs" color="green"
                                >Print</FwbButton
                            ></fwb-table-cell
                        >
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
} from "flowbite-vue";

defineProps({
    payments: {
        type: Object,
    },
});
</script>
