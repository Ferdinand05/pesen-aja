<template>
    <div>
        <Bar id="my-chart-id" :options="chartOptions" :data="chartData"
            >Can't load chart</Bar
        >
    </div>
</template>

<script setup>
import { Bar } from "vue-chartjs";
import { usePage } from "@inertiajs/vue3";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    scales,
} from "chart.js";

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
);

const page = usePage({});

const chartData = {
    labels: page.props.dataChart.months,
    datasets: [
        {
            label: "Total Revenue",
            backgroundColor: "blue",
            data: page.props.dataChart.revenue,
            yAxisID: "y",
        },
        {
            label: "Jumlah Order",
            backgroundColor: "lightgreen",
            data: page.props.dataChart.orders,
            yAxisID: "y1",
        },
    ],
};

const chartOptions = {
    responsive: true,
    interaction: {
        mode: "index",
        intersect: false,
    },
    scales: {
        y: {
            type: "linear",
            display: true,
            position: "left",
        },
        y1: {
            type: "linear",
            display: true,
            position: "right",

            // grid line settings
            grid: {
                drawOnChartArea: false, // only want the grid lines for one axis to show up
            },
        },
    },
};
</script>
