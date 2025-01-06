<template>
    <div class="inline-flex items-center">
        <label
            class="relative flex items-center cursor-pointer"
            :for="`check-${ins?.uid}`"
        >
            <input
                type="radio"
                class="w-5 h-5 transition-all border border-green-300 rounded-full appearance-none cursor-pointer peer checked:border-green-400"
                :id="`check-${ins?.uid}`"
                :name="name"
                :value="value"
                v-model="model"
            />
        </label>
        <label
            class="ml-2 text-sm text-green-600 cursor-pointer"
            :for="`check-${ins?.uid}`"
        >
            {{ label }}
        </label>
    </div>
</template>
<script setup>
import { getCurrentInstance } from "vue";

const ins = getCurrentInstance();
defineProps({
    value: {
        type: [String, Array, Number],
    },
    label: String,
    name: String,
});
const model = defineModel("modelValue", {
    required: false,
});
</script>
