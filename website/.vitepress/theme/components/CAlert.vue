<template>
    <div
        class="rounded-md p-4 my-2"
        :class="classes.bg"
        v-if="showing && message"
    >
        <div class="flex">
            <div class="flex-shrink-0">
                <i
                    class="ri-checkbox-circle-fill h-5 w-5"
                    :class="classes.text"
                ></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium" :class="classes.text">
                    {{ message }}
                </p>
            </div>
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button
                        type="button"
                        class="inline-flex rounded-md p-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2"
                        :class="classes.btn"
                        @click="showing = !showing"
                    >
                        <span class="sr-only">Dismiss</span>
                        <i class="ri-close-fill h-5 w-5"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed } from "vue";

const classes = computed(() => {
    const classes = {
        default: {
            btn: "text-gray-500 focus:ring-gray-600 bg-gray-50 hover:bg-gray-100 focus:ring-offset-gray-700",
            text: "text-gray-500",
            bg: "bg-gray-50",
        },
        success: {
            btn: "text-green-500 focus:ring-green-600 bg-green-50 hover:bg-green-100 focus:ring-offset-green-50",
            text: "text-green-800",
            bg: "bg-green-50",
        },
        warning: {
            btn: "text-amber-500 focus:ring-amber-600 bg-amber-50 hover:bg-amber-100 focus:ring-offset-amber-700",
            text: "text-amber-500",
            bg: "bg-amber-50",
        },
        info: {
            btn: "text-blue-500 focus:ring-blue-600 bg-blue-50 hover:bg-blue-100 focus:ring-offset-blue-50",
            text: "text-blue-800",
            bg: "bg-blue-50",
        },
        error: {
            btn: "text-red-500 focus:ring-red-600 bg-red-50 hover:bg-red-100 focus:ring-offset-red-50",
            text: "text-red-800",
            bg: "bg-red-50",
        },
    };

    return classes[props.type] || classes.default;
});

const showing = defineModel("showing", {
    default: false,
});

const props = defineProps({
    type: {
        type: String,
        default: "default",
    },
    message: String,
});
</script>
