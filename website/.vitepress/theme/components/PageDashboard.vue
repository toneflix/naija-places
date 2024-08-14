<template>
    <div>
        <h3 class="text-lg font-medium leading-6 text-gray-900">
            Last 30 days
        </h3>
        <dl class="grid grid-cols-1 gap-5 mt-5 sm:grid-cols-3">
            <div
                class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6 dark:bg-gray-700"
            >
                <dt
                    class="text-sm font-medium text-gray-500 truncate dark:text-gray-300"
                >
                    Keys
                </dt>
                <dd
                    class="mt-1 text-3xl font-semibold text-gray-600 dark:text-white"
                >
                    {{ data.totalKeys }}
                </dd>
            </div>

            <div
                class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6 dark:bg-gray-700"
            >
                <dt
                    class="text-sm font-medium text-gray-500 truncate dark:text-gray-300"
                >
                    Usage Rate
                </dt>
                <dd
                    class="mt-1 text-3xl font-semibold text-gray-600 dark:text-white"
                >
                    {{ data.usageRate }}%
                </dd>
            </div>

            <div
                class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow dark:bg-gray-700 sm:p-6"
            >
                <dt
                    class="text-sm font-medium text-gray-500 truncate dark:text-gray-300"
                >
                    Daily Usage
                </dt>
                <dd
                    class="mt-1 text-3xl font-semibold text-gray-600 dark:text-white"
                >
                    {{ data.dailyUsage }}
                </dd>
            </div>
            <div
                class="col-span-3 px-4 py-5 bg-white rounded-lg shadow dark:bg-gray-700 sm:p-6"
            >
                <canvas ref="usageTrend"></canvas>
            </div>
        </dl>
    </div>
</template>
<script setup lang="ts">
import { useRequest } from "alova/client";
import { alova } from "../../utils/alova";
import { ChartItem } from "chart.js";
import Chart from "chart.js/auto";
import { ref } from "vue";
import { useData } from "vitepress";

const { isDark } = useData();

type Dashboard = {
    usage: number;
    dailyUsage: number;
    weeklyUsage: number;
    totalKeys: number;
    usageRate: number;
    usageTrend: { month: string; usageRate: number }[];
};

const usageTrend = ref<ChartItem>();

const { data, update, loading } = useRequest(
    (page, limit) =>
        alova.Get("v1/account/dashboard", {
            hitSource: [/^createKey/],
            transform: (e: { data: Dashboard }) => e.data,
            params: {
                page,
                limit,
            },
        }),
    {
        initialData: {
            usage: 0,
            dailyUsage: 0,
            weeklyUsage: 0,
            totalKeys: 0,
            usageRate: 0,
            usageTrend: [],
        },
    }
).onSuccess(({ data }) => {
    if (usageTrend.value) {
        new Chart(usageTrend.value, {
            type: "line",
            data: {
                labels: data.usageTrend.map((e) => e.month),
                datasets: [
                    {
                        data: data.usageTrend.map((e) => e.usageRate),
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
        });
    }
});
</script>
