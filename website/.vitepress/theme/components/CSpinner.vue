<template>
    <svg
        class="text-white animate-spin"
        :class="size"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
    >
        <circle
            class="opacity-25"
            cx="12"
            cy="12"
            r="10"
            stroke="currentColor"
            stroke-width="4"
        ></circle>
        <path
            class="opacity-75"
            fill="currentColor"
            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
        ></path>
    </svg>
</template>
<script setup>
import { computed } from "vue";

const size = computed(() => {
    const sizes = {
        xs: "w-2 h-2",
        sm: "w-5 h-5",
        md: "w-10 h-10",
        lg: "w-24 h-24",
        xl: "w-36 h-36",
    };

    return sizes[props.size] || sizes.sm;
});

const props = defineProps({
    size: {
        type: String,
        default: "sm",
    },
});
</script>
