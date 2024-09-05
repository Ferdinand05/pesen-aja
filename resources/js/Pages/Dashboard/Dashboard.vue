<template>
    <DashboardLayout title="Dashboard" subtitle="Dashboard">
        <div
            class="grid mx-5 grid-cols-1 md:grid-cols-3 gap-3 md:gap-5 border-b py-2"
        >
            <div class="p-2 md:p-4 bg-red-500 text-center">
                <div class="border-b-2 border-b-black">
                    <h3 class="font-medium">Products</h3>
                </div>
                <div>
                    <h2>{{ $page.props.productCount }}</h2>
                </div>
            </div>
            <div class="p-2 md:p-4 bg-green-500 text-center">
                <div class="border-b-2 border-b-black">
                    <h3 class="font-medium">Orders</h3>
                </div>
                <div>
                    <h2>{{ $page.props.orderCount }}</h2>
                </div>
            </div>
            <div class="p-2 md:p-4 bg-blue-500 text-center">
                <div class="border-b-2 border-b-black">
                    <h3 class="font-medium">Monthly Revenue</h3>
                </div>
                <div>
                    <h3>
                        Rp.
                        {{
                            Intl.NumberFormat("id").format($page.props.revenue)
                        }}
                    </h3>
                </div>
            </div>
        </div>
        <div class="mt-10">
            <dir>
                Today Revenue :
                {{ Intl.NumberFormat("id").format($page.props.todayRevenue) }}
            </dir>
            <fwb-table>
                <caption>
                    Orderan yang telah SELESAI hari ini
                </caption>
                <fwb-table-head>
                    <fwb-table-head-cell>Order Code</fwb-table-head-cell>
                    <fwb-table-head-cell>Name</fwb-table-head-cell>
                    <fwb-table-head-cell>Total</fwb-table-head-cell>
                    <fwb-table-head-cell>Payment Method</fwb-table-head-cell>
                    <fwb-table-head-cell>Status</fwb-table-head-cell>
                </fwb-table-head>
                <fwb-table-body>
                    <fwb-table-row v-for="order in orderSelesai">
                        <fwb-table-cell>{{ order.order_code }}</fwb-table-cell>
                        <fwb-table-cell>{{
                            order.customer_name
                        }}</fwb-table-cell>
                        <fwb-table-cell>{{
                            Intl.NumberFormat("id").format(order.total)
                        }}</fwb-table-cell>
                        <fwb-table-cell>{{
                            order.payment.payment_method
                        }}</fwb-table-cell>
                        <fwb-table-cell
                            ><FwbBadge>{{
                                order.status
                            }}</FwbBadge></fwb-table-cell
                        >
                    </fwb-table-row>
                </fwb-table-body>
            </fwb-table>
        </div>
        <div class="mt-5 mb-10">
            <BarChart></BarChart>
        </div>
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from "../../../Layouts/DashboardLayout.vue";
import BarChart from "../../../Components/BarChart.vue";
defineProps({
    orderSelesai: {
        type: Object,
    },
});

import {
    FwbA,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
    FwbBadge,
} from "flowbite-vue";
</script>
