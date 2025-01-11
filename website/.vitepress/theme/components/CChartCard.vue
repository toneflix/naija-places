<template>
    <div
        class="col-span-3 px-4 py-5 bg-white rounded-lg shadow dark:bg-gray-700 sm:p-6"
    >
        <canvas ref="usageTrend"></canvas>
    </div>
</template>

<script setup lang="ts">
import { ChartConfiguration, ChartItem } from "chart.js";
import {
    computed,
    onBeforeUnmount,
    onMounted,
    ref,
    shallowRef,
    watch,
} from "vue";
import Chart from "chart.js/auto";
import { useData } from "vitepress";

const { data = [] } = defineProps<{
    data: { month: string; usageRate: number }[];
}>();

const usageTrend = ref<ChartItem>();
const chart = shallowRef<Chart>();
const { isDark } = useData();

const chartConfig = computed<ChartConfiguration>(() => ({
    type: "line",
    data: {
        labels: data.map((e) => e.month),
        datasets: [
            {
                data: data.map((e) => e.usageRate),
                tension: 0.3,
                borderColor: isDark.value ? "#fff" : "green",
            },
        ],
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: "Usage Rate for the last 6 months",
                color: isDark.value ? "#d1d5db" : "#6b7280",
                font: {
                    size: 14,
                    weight: 500,
                },
            },
            legend: {
                display: false,
            },
            tooltip: {
                callbacks: {
                    label: function (context) {
                        return context.formattedValue + "%";
                    },
                },
            },
        },
        scales: {
            x: {
                grid: {
                    color: "#8388918c",
                },
                ticks: {
                    color: isDark.value ? "#fff" : "#666666",
                },
            },
            y: {
                grid: {
                    color: "#8388918c",
                },
                ticks: {
                    color: isDark.value ? "#fff" : "#666666",
                },
            },
        },
    },
}));

watch(
    chartConfig,
    (chartConfig) => {
        const to = setInterval(() => {
            if (chart.value) {
                clearInterval(to);
                chart.value.data.labels = chartConfig.data.labels;
                chart.value.data.datasets = chartConfig.data.datasets;
                chart.value.update();
            }
        }, 100);
    },
    { immediate: true }
);

onBeforeUnmount(() => {
    chart.value?.destroy();
});

onMounted(() => {
    if (usageTrend.value && (!chart.value || !chart.value.attached)) {
        chart.value = new Chart(usageTrend.value, chartConfig.value);
    }
});
</script>
