<template>
    <div class="flex flex-col justify-center min-h-full py-12 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1">
            <div class="col-span-1 py-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="flex col-span-2 gap-4">
                        <CRadio
                            v-for="(x, i) in periods"
                            v-model="range"
                            name="range"
                            :value="i"
                            :label="x"
                        />
                    </div>
                    <div class="col-span-2 md:col-span-1">
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-white"
                        >
                            Choose Origin/Country
                        </label>
                        <CPlaceSelector
                            class="border-solid dark:border-black"
                            :base-url="baseURL"
                            :params="{ countries: true }"
                            v-model="form.country"
                            @change="data.country = $event"
                        />
                        <small>
                            <code>{{ `${baseURL}/countries` }}</code>
                        </small>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-white"
                        >
                            Choose Make Year
                        </label>
                        <CPlaceSelector
                            class="border-solid dark:border-black"
                            :base-url="baseURL"
                            :params="{ years: true }"
                            :query="period"
                        />
                        <small>
                            <code>{{ `${baseURL}/years` }}</code>
                        </small>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-white"
                        >
                            Choose Make Year (By Country ID)
                        </label>
                        <CPlaceSelector
                            class="border-solid dark:border-black"
                            :base-url="baseURL"
                            :params="{ countries: form.country, years: true }"
                            :query="period"
                            v-model="form.year"
                            @change="data.year = $event"
                        />
                        <small>
                            <code>{{
                                `${baseURL}/countries/${form.country}/years`
                            }}</code>
                        </small>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-white"
                        >
                            Choose Manufacturer (By Year ID)
                        </label>
                        <CPlaceSelector
                            class="border-solid dark:border-black"
                            :base-url="baseURL"
                            :params="{
                                years: form.year,
                                manufacturers: true,
                            }"
                            v-model="form.manufacturer"
                            @change="data.manufacturer = $event"
                        />
                        <small>
                            <code>{{
                                `${baseURL}/years/${form.country}/manufacturers`
                            }}</code>
                        </small>
                    </div>

                    <div class="col-span-2">
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-white"
                        >
                            Choose Vehicle (By Manufacturer ID)
                        </label>
                        <CPlaceSelector
                            class="border-solid dark:border-black"
                            :base-url="baseURL"
                            :params="{
                                manufacturers: form.manufacturer,
                                vehicles: true,
                            }"
                            v-model="form.vehicle"
                            @change="data.vehicle = $event"
                        />
                        <small>
                            <code>{{
                                `${baseURL}/manufacturers/${form.manufacturer}/vehicles`
                            }}</code>
                        </small>
                    </div>

                    <div class="col-span-2">
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-white"
                        >
                            Choose derivatives
                        </label>
                        <CPlaceSelector
                            class="border-solid dark:border-black"
                            :base-url="baseURL"
                            :params="{
                                derivatives: true,
                            }"
                            v-model="form.derivatives"
                            @change="data.derivatives = $event"
                        />
                        <small>
                            <code>{{ `${baseURL}/derivatives` }}</code>
                        </small>
                    </div>
                </div>
            </div>

            <div class="flex flex-col justify-center p-4 vp-doc">
                <div class="language-json vp-adaptive-theme">
                    <button title="Copy Code" class="copy"></button>
                    <span class="lang">json</span>
                    <pre
                        class="shiki shiki-themes github-light github-dark vp-code"
                    ><code v-html="parse(data)"></code></pre>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { computed, ref } from "vue";

const range = ref(0);
const baseURL = "/v1/vehicle";
const period = computed(() => {
    const x = periods[range.value].split("-");
    return { min: x[0], max: x[1] };
});
const periods = ["1904-1940", "1940-1990", "1990-" + new Date().getFullYear()];

const form = ref({
    country: null,
    year: null,
    manufacturer: null,
    vehicle: null,
    derivatives: null,
});

const data = ref({
    country: { id: "" },
    year: { id: "" },
    manufacturer: { id: "" },
    vehicle: { id: "" },
    derivatives: { id: "" },
});

const parse = (data: Record<string, any>) => {
    return JSON.stringify(
        {
            manufacturer: data.manufacturer?.name || "loading...",
            country: data.country?.name || "loading...",
            year: data.year?.name || "loading...",
            vehicle: data.vehicle?.name || "loading...",
            derivatives: data.derivatives?.name || "loading...",
        },
        null,
        4
    )
        .split("\n")
        .map((line) => `<span class="line">${line}</span>`)
        .join("\n");
};
</script>

<style scoped>
.grid-cols-2 {
    grid-template-columns: repeat(2, minmax(0, 1fr));
}

.gap-4 {
    gap: 1rem;
}
</style>
