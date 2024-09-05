<template>
    <DashboardLayout title="Order History" subtitle="Order History">
        <main>
            {{ orderHistory }}
        </main>
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from "../../../Layouts/DashboardLayout.vue";
defineProps({
    orderHistory: Object,
});
</script>
