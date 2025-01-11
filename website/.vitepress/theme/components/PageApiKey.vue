<template>
    <div>
        <h3 class="text-lg font-medium leading-6 text-gray-900">
            Last 30 days
        </h3>
        <CSpinner v-if="loading" />
        <div class="grid grid-cols-2 gap-4">
            <dl class="grid grid-cols-1 col-span-2 gap-5 mt-5 sm:grid-cols-3">
                <CStatCard label="Usage" :data="data.stats.totalCalls" />
                <CStatCard
                    label="Monthly Usage"
                    :data="data.stats.monthlyCalls"
                />
                <CStatCard label="Daily Usage" :data="data.stats.dailyCalls" />
            </dl>

            <div
                class="col-span-2 overflow-hidden bg-white shadow dark:bg-gray-700 sm:rounded-lg"
            >
                <div class="px-4 py-5 sm:px-6">
                    <h3
                        class="text-lg font-medium leading-6 text-gray-900 dark:text-white"
                    >
                        API Key
                    </h3>
                    <p
                        class="max-w-2xl mt-1 text-sm text-gray-500 dark:text-gray-200"
                    >
                        API Key details
                    </p>
                </div>
                <div
                    class="px-4 py-5 border-t border-gray-200 dark:border-gray-500 sm:p-0"
                >
                    <dl
                        class="sm:divide-y sm:divide-gray-200 dark:sm:divide-gray-500"
                    >
                        <div
                            class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6"
                            :key="field.label + i"
                            v-for="(field, i) in list"
                        >
                            <dt
                                class="text-sm font-medium text-gray-500 dark:text-gray-300"
                            >
                                {{ field.label }}
                            </dt>
                            <dd
                                class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 dark:text-white"
                            >
                                {{ field.value }}
                            </dd>
                        </div>
                        <div class="flex justify-center py-4 sm:py-5">
                            <CButton
                                dense
                                type="button"
                                class="px-1.5 py-1 text-white bg-red-600 hover:bg-red-700 focus:ring-red-500"
                                :loading="deleting"
                                @click.prevent="deleteIt()"
                            >
                                <i class="text-sm ri-delete-bin-fill"> </i>
                                &nbsp; Delete API Key
                            </CButton>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { useRequest } from "alova/client";
import { computed, ref } from "vue";
import { useRouter } from "vitepress";
import { alova } from "../../utils/alova";
import { confirm, notify } from "../../utils/tools";
import { bootstrapStore } from "../../store/bootstrap";
import CButton from "./CButton.vue";

const key = ref(new URL(location.href).searchParams.get("key"));
const store = bootstrapStore();
const router = useRouter();
const deleting = ref<boolean>(false);

store.cache.pageTitle = "API Key";

type ApiKey = {
    id: number;
    key: string;
    name: string;
    createdAt: string;
    rateLimit: number;
    createDate: number;
    rateLimited: boolean;
    stats: {
        totalCalls: number;
        dailyCalls: number;
        monthlyCalls: number;
        topEndpoint: {
            endpoint: string;
            total_calls: number;
        };
        dailyTopEndpoint: {
            endpoint: string;
            total_calls: number;
        };
    };
};

const list = computed<{ label: string; value: string | number | boolean }[]>(
    () => [
        { label: "Key", value: data.value.key ?? "--" },
        {
            label: "Rate Limit",
            value: (data.value.rateLimit ?? 0) + " Requests/s",
        },
        { label: "Rate Limited", value: data.value.rateLimited ? "Yes" : "No" },
        {
            label: "Top Endpoint",
            value: `${data.value.stats.topEndpoint.endpoint ?? "N/A"} (${
                data.value.stats.topEndpoint.total_calls ?? 0
            })`,
        },
        {
            label: "Top Endpoint Today",
            value: `${data.value.stats.dailyTopEndpoint.endpoint ?? "N/A"} (${
                data.value.stats.dailyTopEndpoint.total_calls ?? 0
            })`,
        },
        { label: "Date Created", value: data.value.createDate ?? "N/A" },
    ]
);

const { data, update, loading } = useRequest(
    () =>
        alova.Get("v1/account/api-keys/" + key.value, {
            params: { with: "stats" },
            hitSource: [/^createKey/],
            transform: (e: { data: ApiKey }) => e.data,
        }),
    {
        initialPageSize: 30,
        initialData: {
            rateLimit: 0,
            pageTitle: "",
            stats: {
                totalCalls: 0,
                dailyCalls: 0,
                monthlyCalls: 0,
                topEndpoint: {},
                dailyTopEndpoint: {},
            },
        },
    }
).onSuccess(({ data }) => {
    store.cache.pageTitle = "API Key: " + data.name;
});

const deleteIt = async () => {
    await confirm(
        "Once deleted, all applications dependent on this key will no longer be able to access the API.",
        "Cornfirm Delete",
        [true, "Yes Delete"]
    ).then(async () => {
        deleting.value = true;
        await alova
            .Delete("v1/account/api-keys/" + key.value, {
                name: "deleteKey",
            })
            .send()
            .finally(() => {
                deleting.value = false;
            });
        notify("API key deleted successfully!");
        router.go("/portal/api-keys");
    });
};
</script>
