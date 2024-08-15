<template>
    <select
        v-model="modelValue"
        class="block w-full py-2 pl-3 pr-10 mt-1 text-base text-black border-gray-300 rounded-md focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
    >
        <option disabled selected>Choose an option</option>
        <option :value="data.id" :key="i" v-for="(data, i) in places">
            {{ data.name }}
        </option>
    </select>
</template>

<script setup lang="ts">
import { useWatcher } from "alova/client";
import { alova } from "../../utils/alova";
import { computed, watch, type PropType } from "vue";

interface Params {
    states: string | number | boolean;
    cities?: string | number | boolean;
    wards?: string | number | boolean;
    units?: string | number | boolean;
    lgas?: string | number | boolean;
}

const emit = defineEmits<{
    (e: "change", state: any): void;
}>();

const modelValue = defineModel<string | number>("modelValue");

const params = defineModel("params", {
    type: Object as PropType<Params>,
    default: { states: true },
});

const url = computed<string | null>(() => {
    if (!Object.values(params.value).every((e) => !!e)) {
        return null;
    }

    const obj = params.value;

    let path = "";

    for (const [key, value] of Object.entries(obj)) {
        if (value === true) {
            path += `/${key}`;
        } else {
            path += `/${key}/${value}`;
        }
    }

    return path;
});

const { data: places, onSuccess } = useWatcher(
    () => {
        const config = alova.Get(`v1${url.value ?? ""}`, {
            transform: (e: {
                data: {
                    id: number;
                    name: string;
                    slug: string;
                }[];
            }) => e.data,
        });

        return config;
    },
    [params],
    {
        initialData: [],
        immediate: true,
        middleware(_, next) {
            if (Object.values(params.value).every((e) => !!e)) {
                return next();
            }
        },
    }
);

onSuccess(({ data }) => {
    if (!modelValue.value) {
        modelValue.value = data[0].id;
    }
});

watch(modelValue, (id) => {
    emit(
        "change",
        places.value.find((e) => e.id === id)
    );
});
</script>
