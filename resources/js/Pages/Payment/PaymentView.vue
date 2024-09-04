<template>
    <DashboardLayout title="Payments" subtitle="Payments">
        <div class="w-1/2 my-5">
            <FwbInput type="text" placeholder="Search..."></FwbInput>
        </div>
        <main>
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
                    <fwb-table-row v-for="(payment, index) in payments.data">
                        <fwb-table-cell>{{ index + 1 }}</fwb-table-cell>
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
