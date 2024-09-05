<template>
    <Layout title="Order | PesenAja">
        <div>
            <div class="mb-4">
                <h3 class="">Order Here</h3>
            </div>
            <div class="mb-4 w-1/3 space-y-2">
                <div>
                    <FwbSelect
                        size="sm"
                        placeholder="Pilih Kategori"
                        :options="categoryOptions"
                        @change="filterCategory()"
                        v-model="formFilterCategory.category"
                    ></FwbSelect>
                </div>
            </div>
        </div>
        <main class="flex flex-col md:flex-row md:space-x-5 mb-20">
            <!-- container products -->
            <div
                class="border rounded-md grid grid-cols-2 md:grid-cols-4 p-2 gap-2 md:gap-4 md:w-full"
            >
                <!-- products -->
                <div class="border rounded-md" v-for="p in products">
                    <div>
                        <img
                            class="rounded-t-md h-40 w-full object-cover"
                            :src="imageUrl + p.image"
                            :alt="p.name"
                        />
                    </div>
                    <div class="text-center py-2">
                        <div class="font-medium text-sm md:text-base">
                            {{ p.name }}
                        </div>
                        <div class="text-sm md:text-base">
                            {{ Intl.NumberFormat("id").format(p.price) }}
                        </div>
                    </div>
                    <div class="text-center pb-2">
                        <FwbButton
                            size="xs"
                            color="green"
                            @click="addOrder(p.id)"
                            :disabled="form.processing"
                            >Add
                        </FwbButton>
                    </div>
                </div>
            </div>
            <!-- END container products -->
            <div class="border p-2 mt-2 md:mt-0 md:w-1/2 space-y-3 rounded-md">
                <!-- identity -->
                <div class="space-y-3 border-b py-3">
                    <div>
                        <FwbInput
                            label="Name"
                            placeholder="Nama Pemesan"
                            v-model="form.customer_name"
                        ></FwbInput>
                        <small class="text-red-600">{{
                            form.errors.customer_name ??
                            formCheckout.errors.customer_name
                        }}</small>
                    </div>

                    <div>
                        <FwbInput
                            label="Table No"
                            placeholder="Nomor Meja"
                            type="number"
                            v-model="form.table_number"
                        ></FwbInput>
                        <small class="text-red-600">{{
                            form.errors.table_number ??
                            formCheckout.errors.table_number
                        }}</small>
                    </div>
                </div>
                <!-- orders -->
                <div class="px-1 space-y-3 py-1">
                    <div class="space-y-3">
                        <!-- order  items -->
                        <div
                            class="flex justify-between"
                            v-for="item in userOrders"
                        >
                            <div>
                                <div>
                                    {{ item.product.name }}
                                    <span class="text-gray-600"
                                        >@{{ item.product.price }}</span
                                    >
                                    <span> (x{{ item.quantity }})</span>
                                </div>
                                <div class="flex gap-x-2">
                                    <FwbButton
                                        size="xs"
                                        color="green"
                                        @click="addOrder(item.product.id)"
                                        >+</FwbButton
                                    >
                                    <FwbButton
                                        size="xs"
                                        color="red"
                                        @click="deleteOrder(item.product.id)"
                                        >-</FwbButton
                                    >
                                    <FwbButton
                                        size="xs"
                                        @click="cancelOrder(item.product.id)"
                                        >Cancel</FwbButton
                                    >
                                </div>
                            </div>
                            <div class="font-medium">
                                {{
                                    Intl.NumberFormat("id").format(
                                        item.product.price * item.quantity
                                    )
                                }}
                            </div>
                        </div>
                        <!-- END order items -->
                        <!-- TOTAL -->
                        <div
                            class="flex justify-between font-bold mt-5 text-lg border-t"
                        >
                            <div>Total :</div>
                            <div>
                                {{
                                    Intl.NumberFormat("id", {
                                        currency: "IDR",
                                        style: "currency",
                                    }).format(totalPrice)
                                }}
                            </div>
                        </div>
                        <div class="text-center space-x-2">
                            <FwbButton
                                type="button"
                                as="button"
                                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                                :disabled="formCheckout.processing"
                                @click="checkout()"
                                id="pay-button"
                                >Checkout</FwbButton
                            >
                        </div>
                        <!-- END TOTAL -->
                    </div>
                </div>
            </div>
        </main>

        <!-- script midtrans snap -->
        <component
            is="script"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            :data-client-key="$page.props.clientKey"
            async
        ></component>
    </Layout>
</template>

<script setup>
import Layout from "../../Layouts/Layout.vue";
import { FwbButton, FwbInput, FwbSelect } from "flowbite-vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { ref, computed, onMounted, watchEffect, watch } from "vue";
import Swal from "sweetalert2";
const page = usePage();

defineProps({
    products: Object,
    userOrders: Object,
});

//ANCHOR Categories options Select
const categoryOptions = [
    {
        value: "All",
        name: "All",
    },
];
page.props.categories.forEach((c) => {
    categoryOptions.push({ value: c.name, name: c.name });
});
const formFilterCategory = useForm({
    category: page.props.category,
});
function filterCategory() {
    formFilterCategory.get(route("home"), {
        preserveState: true,
        preserveScroll: true,
    });
}

const imageUrl = "/storage/product-image/";
const form = useForm({
    customer_name: page.props.order.customer_name || "",
    table_number: page.props.order.table_number || "",
    product_id: null,
    quantity: 1,
});

const totalPrice = computed(() => {
    return page.props.userOrders.reduce((total, item) => {
        return total + item.product.price * item.quantity;
    }, 0);
});

//SECTION - ADC Order
function addOrder(id) {
    form.product_id = id;
    form.post(route("temporary-order.store"), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            filterCategory();
        },
    });
}
function deleteOrder(id) {
    form.product_id = id;
    form.post(route("temporary-order.delete"), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            filterCategory();
        },
    });
}
function cancelOrder(id) {
    form.product_id = id;
    form.delete(route("temporary-order.cancel"), {
        preserveScroll: true,
    });
}

//SECTION -  checkout
const formCheckout = useForm({
    customer_name: page.props.order.customer_name || "",
    table_number: page.props.order.table_number || "",
    userOrders: page.props.userOrders,
});

watchEffect(() => {
    formCheckout.customer_name = form.customer_name;
    formCheckout.table_number = form.table_number;
    formCheckout.userOrders = page.props.userOrders;
});

function checkout() {
    Swal.fire({
        title: "Apakah anda yakin ?",
        text: "Anda akan segera melakukan pembayaran!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
    }).then((result) => {
        if (result.isConfirmed) {
            formCheckout.post(route("checkout.store"), {
                preserveScroll: true,
                onSuccess() {
                    // midtrans snap
                    pay();
                    form.customer_name = null;
                    form.table_number = null;
                    page.props.payment.snapToken = "";
                },
            });
        }
    });
}

// update transaction after success
const formCheckoutUpdate = useForm({
    message: null,
});
// Function to handle payment process
function pay() {
    window.snap.pay(page.props.payment.snapToken, {
        onSuccess: function (result) {
            formCheckoutUpdate.message = result;
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Pesanan akan segera diproses. Terima Kasih!",
                showConfirmButton: false,
                timer: 1500,
            });
            updateTransactionMessage();
        },
        onPending: function (result) {
            formCheckoutUpdate.message = result;
            updateTransactionMessage();
        },
        onError: function (result) {
            formCheckoutUpdate.message = result;
            updateTransactionMessage();
        },
        onClose: function () {
            /* You may add your own implementation here */
            alert("you closed the popup without finishing the payment");
        },
    });
}

function updateTransactionMessage() {
    formCheckoutUpdate.post(route("checkout.update"), {
        preserveScroll: true,
        onSuccess: () => {
            console.log("success");
        },
    });
}
</script>
