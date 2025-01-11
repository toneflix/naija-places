<template>
    <div
        class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow dark:bg-gray-700 sm:p-6"
    >
        <dt
            class="text-sm font-medium text-gray-500 truncate dark:text-gray-300"
        >
            {{ label }}
        </dt>
        <dd class="mt-1 text-3xl font-semibold text-gray-600 dark:text-white">
            {{ data }}
        </dd>
    </div>
</template>

<script setup lang="ts">
const { data = 0 } = defineProps<{
    data: string | number;
    label: string;
}>();
</script>
