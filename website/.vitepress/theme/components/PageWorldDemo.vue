<template>
    <div class="flex flex-col justify-center min-h-full py-12 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1">
            <div class="col-span-1 py-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 md:col-span-1">
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-white"
                        >
                            Choose Region
                        </label>
                        <CPlaceSelector
                            class="border-solid dark:border-black"
                            :params="{ regions: true }"
                            v-model="form.region"
                            @change="data.region = $event"
                        />
                        <small>
                            <code>{{ `${baseURL}/regions` }}</code>
                        </small>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-white"
                        >
                            Choose Subregion
                        </label>
                        <CPlaceSelector
                            class="border-solid dark:border-black"
                            :params="{ subregions: true }"
                            v-model="form.subregion"
                            @change="data.subregion = $event"
                        />
                        <small>
                            <code>{{ `${baseURL}/subregions` }}</code>
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-span-1">
                <label
                    class="block text-sm font-medium text-gray-700 dark:text-white"
                >
                    Choose Country
                </label>
                <CPlaceSelector
                    class="border-solid dark:border-black"
                    :params="{ countries: true }"
                    v-model="form.country"
                    @change="data.country = $event"
                />
                <small>
                    <code>{{ `${baseURL}/countries` }}</code>
                </small>
            </div>
            <div class="col-span-1 py-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 md:col-span-1">
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-white"
                        >
                            Choose State
                        </label>
                        <CPlaceSelector
                            class="border-solid dark:border-black"
                            :params="{ countries: form.country, states: true }"
                            v-model="form.state"
                            @change="data.state = $event"
                        />
                        <small>
                            <code>{{
                                `${baseURL}/countries/${
                                    data.country?.iso2 || form.country
                                }/states`
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
                            :params="{
                                countries: form.country,
                                states: form.state,
                                cities: true,
                            }"
                            v-model="form.city"
                            @change="data.city = $event"
                        />
                        <small>
                            <code>{{
                                `${baseURL}/countries/${
                                    data.country?.iso2 || form.country
                                }/states/${
                                    data.state?.iso2 || form.state
                                }/cities`
                            }}</code>
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
import { ref } from "vue";

const baseURL = "/v1";

const form = ref({
    subregion: null,
    country: null,
    region: null,
    state: null,
    city: null,
});

const data = ref({
    subregion: { iso2: "" },
    country: { iso2: "" },
    region: { iso2: "" },
    state: { iso2: "" },
    city: "",
});

const parse = (data: Record<string, any>) => {
    return JSON.stringify(
        {
            region: data.region?.name || "loading...",
            subregion: data.subregion?.name || "loading...",
            country: data.country?.name || "loading...",
            state: data.state?.name || "loading...",
            city: data.city?.name || "loading...",
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
