<template>
    <div class="flex flex-col justify-center min-h-full py-12 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1">
            <div class="col-span-1">
                <label
                    class="block text-sm font-medium text-gray-700 dark:text-white"
                >
                    Choose State
                </label>
                <CPlaceSelector
                    class="border-solid dark:border-black"
                    :params="{ states: true }"
                    v-model="form.state"
                    @change="data.state = $event"
                />
                <small>
                    <code>{{ `${baseURL}/states` }}</code>
                </small>
            </div>
            <div class="col-span-1 py-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 md:col-span-1">
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-white"
                        >
                            Choose LGA
                        </label>
                        <CPlaceSelector
                            class="border-solid dark:border-black"
                            :params="{ states: form.state, lgas: true }"
                            v-model="form.lga"
                            @change="data.lga = $event"
                        />
                        <small>
                            <code>{{
                                `${baseURL}/states/${
                                    data.state?.code || form.state
                                }/cities`
                            }}</code>
                        </small>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-white"
                        >
                            Choose City
                        </label>
                        <CPlaceSelector
                            class="border-solid dark:border-black"
                            :params="{ states: form.state, cities: true }"
                            v-model="form.city"
                            @change="data.city = $event"
                        />
                        <small>
                            <code>{{
                                `${baseURL}/states/${
                                    data.state?.code || form.state
                                }/lgas`
                            }}</code>
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-span-1">
                <label
                    class="block text-sm font-medium text-gray-700 dark:text-white"
                >
                    Choose Ward
                </label>
                <CPlaceSelector
                    class="border-solid dark:border-black"
                    :params="{
                        states: form.state,
                        lgas: form.lga,
                        wards: true,
                    }"
                    v-model="form.ward"
                    @change="data.ward = $event"
                />
                <small>
                    <code>{{
                        `${baseURL}/states/${
                            data.state?.code || form.state
                        }/lgas/${data.lga?.code || form.lga}/wards`
                    }}</code>
                </small>
            </div>
            <div class="col-span-1 py-4">
                <label
                    class="block text-sm font-medium text-gray-700 dark:text-white"
                >
                    Choose Polling Unit
                </label>
                <CPlaceSelector
                    class="border-solid dark:border-black"
                    :params="{
                        states: form.state,
                        lgas: form.lga,
                        wards: form.ward,
                        units: true,
                    }"
                    v-model="form.unit"
                    @change="data.unit = $event"
                />
                <small class="break-words">
                    <code class="min-w-0">{{
                        `${baseURL}/states/${
                            data.state?.code || form.state
                        }/lgas/${data.lga?.code || form.lga}/wards/${
                            form.ward
                        }/units`
                    }}</code>
                </small>
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
import { ref } from "vue";

const baseURL = "/v1";

const form = ref({
    state: null,
    city: null,
    lga: null,
    ward: null,
    unit: null,
});

const data = ref({
    lga: { code: "" },
    state: { code: "" },
    unit: "",
    ward: "",
    city: "",
});

const parse = (data: Record<string, any>) => {
    return JSON.stringify(
        {
            state: data.state?.name || "loading...",
            city: data.city?.name || "loading...",
            lga: data.lga?.name || "loading...",
            ward: data.ward?.name || "loading...",
            unit: data.unit?.name || "loading...",
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
