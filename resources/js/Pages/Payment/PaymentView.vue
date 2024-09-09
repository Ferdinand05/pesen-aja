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
            <div class="space-x-2">
                <FwbButton size="sm" color="green" @click="exportPdf()"
                    >Export as PDF</FwbButton
                >
                <FwbButton size="sm" color="dark" @click="exportExcel()"
                    >Export as Excel</FwbButton
                >
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

                        <fwb-table-cell>
                            <div v-show="payment.payment_status" class="flex">
                                <ModalComponent buttonType="Detail">
                                    <template #header>
                                        <div class="space-x-2">
                                            <span class="text-lg">{{
                                                payment.order.customer_name
                                            }}</span>
                                            <span>
                                                #{{ payment.order.order_code }}
                                            </span>
                                        </div>
                                    </template>
                                    <template #body>
                                        <div
                                            class="text-start space-y-2 border-b pb-2"
                                        >
                                            <div>
                                                <div>Status</div>
                                                <div class="font-medium">
                                                    <div class="flex">
                                                        <FwbBadge
                                                            :type="
                                                                payment.payment_status ==
                                                                'deny'
                                                                    ? 'red'
                                                                    : 'default'
                                                            "
                                                            >{{
                                                                payment.payment_status
                                                            }}</FwbBadge
                                                        >
                                                        <FwbBadge
                                                            :type="
                                                                payment.order
                                                                    .status ==
                                                                'menunggu pembayaran'
                                                                    ? 'red'
                                                                    : 'yellow'
                                                            "
                                                            >{{
                                                                payment.order
                                                                    .status
                                                            }}</FwbBadge
                                                        >
                                                    </div>
                                                </div>
                                            </div>
                                            <div>
                                                <div>Table Number</div>
                                                <div class="font-medium">
                                                    {{
                                                        payment.order
                                                            .table_number
                                                    }}
                                                </div>
                                            </div>
                                            <div>
                                                <div>Payment Date</div>
                                                <div class="font-medium">
                                                    {{ payment.payment_date }}
                                                </div>
                                            </div>
                                            <div>
                                                <div>Payment Method</div>
                                                <div class="font-medium">
                                                    {{ payment.payment_method }}
                                                </div>
                                            </div>
                                            <div>
                                                <div>Payment Detail</div>
                                                <div class="font-medium">
                                                    {{
                                                        payment.payment_details
                                                    }}
                                                </div>
                                            </div>
                                            <div class="border-t pt-1">
                                                <ul>
                                                    <li
                                                        v-for="item in payment.order_items"
                                                    >
                                                        {{ item.product }} ({{
                                                            item.quantity
                                                        }}
                                                        x
                                                        {{
                                                            Intl.NumberFormat(
                                                                "id"
                                                            ).format(
                                                                item.price
                                                            )
                                                        }})
                                                    </li>
                                                    <li>
                                                        Total :
                                                        {{
                                                            Intl.NumberFormat(
                                                                "id"
                                                            ).format(
                                                                payment.amount
                                                            )
                                                        }}
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </template>
                                </ModalComponent>
                                <FwbButton
                                    v-show="payment.payment_status == 'capture'"
                                    size="xs"
                                    color="green"
                                    class="ms-1"
                                    @click="
                                        printInvoice(
                                            payment.order.customer_name,
                                            payment.order.table_number,
                                            payment.order_items,
                                            payment.payment_date,
                                            payment.payment_method,
                                            payment.order.order_code,
                                            payment.payment_status
                                        )
                                    "
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
import { ref } from "vue";
import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";
import ModalComponent from "../../../Components/ModalComponent.vue";
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
import { usePage, useForm, router } from "@inertiajs/vue3";
defineProps({
    payments: {
        type: Object,
    },
});
const page = usePage({});

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

// print payment invoice
function printInvoice(
    customer_name,
    table_number,
    order_items,
    payment_date,
    payment_method,
    order_code,
    payment_status
) {
    const orderItems = ref(order_items);
    var doc = new jsPDF({
        orientation: "p",
        unit: "mm",
        format: "a6",
        putOnlyUsedFonts: true,
    });

    const date = new Date();
    const printDate = Intl.DateTimeFormat("id", {
        day: "2-digit",
        month: "long",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    }).format(date);

    doc.setFontSize(18);
    doc.text("PesenAja", 7, 7);
    doc.setFontSize(10);
    doc.text(`Order Code : #${order_code}`, 7, 15);
    doc.text(`Payment date : ${payment_date}`, 7, 20);
    doc.text(`Payment Status : ${payment_status}`, 7, 25);
    doc.text(`Customer name : ${customer_name}`, 7, 30);
    doc.text(`Table number :  ${table_number}`, 7, 35);
    doc.text(`Payment method : ${payment_method}`, 7, 40);

    // Data untuk tabel
    const tableColumn = ["Product", "Quantity", "Price", "Subtotal"];
    const tableRows = orderItems.value.map((item) => [
        item.product,
        item.quantity,
        `${item.price}`,
        `${item.quantity * item.price}`,
    ]);

    // Menambahkan total ke baris terakhir
    const totalAmount = orderItems.value.reduce(
        (sum, item) => sum + item.quantity * item.price,
        0
    );
    tableRows.push([
        {
            content: "Total",
            colSpan: 3,
            styles: { halign: "right" },
        },
        `Rp. ${totalAmount}`,
    ]);

    // Generate table
    doc.autoTable({
        head: [tableColumn],
        body: tableRows,
        startY: 45,
        margin: { left: 7, bottom: 10 },
        theme: "grid",
    });

    // Tambahkan teks pertama di bawah tabel
    doc.text(
        "Thank you for your purchase!",
        7,
        doc.autoTable.previous.finalY + 10
    );

    // Tambahkan teks kedua di bawah teks pertama
    doc.text(
        "If you have any questions, feel free to contact us.",
        7,
        doc.autoTable.previous.finalY + 15
    );
    doc.setFontSize(8);
    doc.text(
        `Dicetak pada ${printDate}`,
        7,
        doc.autoTable.previous.finalY + 20
    );

    doc.save("order-invoice.pdf");
}

// export
const formExport = useForm({
    startDate: null,
    endDate: null,
});

const filteredData = ref([]);
function exportPdf() {
    formExport.startDate = formFilter.startDate;
    formExport.endDate = formFilter.endDate;

    formExport.get(route("export.pdf"), {
        onSuccess: (results) => {
            filteredData.value = results.props.flash.filterPaymentData.data;
        },
        onFinish: () => {
            var doc = new jsPDF({
                orientation: "p",
                unit: "mm",
                format: "a4",
                putOnlyUsedFonts: true,
            });

            const date = new Date();
            const printDate = Intl.DateTimeFormat("id", {
                day: "2-digit",
                month: "long",
                year: "numeric",
                hour: "2-digit",
                minute: "2-digit",
            }).format(date);

            // pdf
            // Data untuk tabel
            const tableColumn = [
                "Order Code",
                "Amount",
                "Date",
                "Method",
                "Status",
            ];
            const tableRows = filteredData.value.map((item) => [
                item.order.order_code,
                item.amount,
                item.payment_date,
                item.payment_method,
                item.payment_status,
            ]);

            // Menambahkan total ke baris terakhir
            const totalAmount = filteredData.value.reduce(
                (sum, item) => sum + item.amount,
                0
            );

            // Generate table
            doc.autoTable({
                head: [tableColumn],
                body: tableRows,
                startY: 5,
                margin: { left: 10, bottom: 10 },
                theme: "grid",
            });

            // Tambahkan teks pertama di bawah tabel
            doc.text(
                `Total Amount : ${totalAmount}`,
                7,
                doc.autoTable.previous.finalY + 10
            );

            doc.setFontSize(8);
            doc.text(
                `Dicetak pada ${printDate}`,
                10,
                doc.autoTable.previous.finalY + 20
            );

            doc.save("laporan-payment.pdf");
        },
    });
}
</script>
