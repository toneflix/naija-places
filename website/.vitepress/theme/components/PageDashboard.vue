<template>
    <div>
        <h3 class="text-lg font-medium leading-6 text-gray-900">
            Last 30 days
        </h3>
        <dl class="grid grid-cols-1 gap-5 mt-5 sm:grid-cols-3">
            <CStatCard label="Keys" :data="data.totalKeys" />
            <CStatCard label="Usage Rate" :data="data.usageRate + '%'" />
            <CStatCard label="Daily Usage" :data="data.dailyUsage" />
            <CChartCard
                :data="data.usageTrend"
                v-if="data.usageTrend?.length"
            />
            <CChartCard :data="[]" v-else />
        </dl>
    </div>
</template>
<script setup lang="ts">
import { useRequest } from "alova/client";
import { alova } from "../../utils/alova";
import CChartCard from "./CChartCard.vue";

type Dashboard = {
    usage: number;
    dailyUsage: number;
    weeklyUsage: number;
    totalKeys: number;
    usageRate: number;
    usageTrend: { month: string; usageRate: number }[];
};

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
);
</script>
