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
                    <h3 class="font-medium">Revenue</h3>
                </div>
                <div>
                    <h3>Rp. {{ $page.props.revenue }}</h3>
                </div>
            </div>
        </div>
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from "../../../Layouts/DashboardLayout.vue";
</script>
