<template>
    <DashboardLayout title="Orders" subtitle="Orders">
        <small class="text-red-500"
            >*Hanya pesanan yang sudah dibayar yang akan tampil</small
        >
        <main class="my-5">
            <!--SECTION parent -->
            <div class="grid grid-cols-1 md:grid-cols-3 md:gap-4">
                <!-- card orders -->
                <div class="card rounded-md" v-for="order in orders.data">
                    <div
                        class="header text-center text-gray-200 rounded-t-md px-2 bg-gray-800"
                    >
                        <div class="text-xl">
                            {{ order.customer_name }}
                        </div>
                        <div class="text-xs">
                            #{{ order.order_code }} - {{ order.status }}
                        </div>
                    </div>

                    <div class="body p-2 bg-gray-200">
                        <div>
                            Table Number :
                            <span class="text-lg font-medium">{{
                                order.table_number
                            }}</span>
                        </div>
                        <div>
                            <details>
                                <summary>Order Items</summary>
                                <ul class="list-decimal ms-4">
                                    <li v-for="item in order.order_items">
                                        {{ item.product.name }}
                                        <span class="text-lg font-medium">
                                            - ({{ item.quantity }})</span
                                        >
                                    </li>
                                </ul>
                            </details>
                        </div>
                    </div>
                    <div
                        class="footer text-center p-2 bg-gray-400 rounded-b-md"
                    >
                        <div class="text-lg font-medium">
                            Rp.
                            {{ Intl.NumberFormat("id").format(order.total) }}
                        </div>
                        <div class="text-xs text-gray-600">
                            {{ order.created_at }}
                        </div>
                        <div class="text-center mt-1">
                            <FwbButton
                                color="red"
                                size="xs"
                                @click="selesaiOrder(order.order_code)"
                                >Selesai</FwbButton
                            >
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Parent -->
        </main>
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from "../../../Layouts/DashboardLayout.vue";
import { FwbButton } from "flowbite-vue";
import { useForm, usePage } from "@inertiajs/vue3";
import Swal from "sweetalert2";

defineProps({
    orders: {
        type: Object,
    },
});

const formSelesaiOrder = useForm({
    order_code: null,
});
function selesaiOrder(code) {
    Swal.fire({
        title: "Apakah pesanan sudah selesai?",
        text: "pesanan sudah selesai diantar",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, selesaikan!",
    }).then((result) => {
        if (result.isConfirmed) {
            formSelesaiOrder.order_code = code;
            formSelesaiOrder.post(route("selesai-order"), {
                onSuccess: () => {
                    Swal.fire({
                        title: "Selesai!",
                        text: "Pesanana telah diselesaikan!",
                        icon: "success",
                    });
                },
            });
        }
    });
}
</script>
