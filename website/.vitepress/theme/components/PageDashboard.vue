<template>
    <div>
        <h3 class="text-lg font-medium leading-6 text-gray-900">
            Last 30 days
        </h3>
        <dl class="grid grid-cols-1 gap-5 mt-5 sm:grid-cols-3">
            <div
                class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6 dark:bg-gray-700"
            >
                <dt
                    class="text-sm font-medium text-gray-500 truncate dark:text-gray-300"
                >
                    Keys
                </dt>
                <dd
                    class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white"
                >
                    10
                </dd>
            </div>

            <div
                class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow sm:p-6 dark:bg-gray-700"
            >
                <dt
                    class="text-sm font-medium text-gray-500 truncate dark:text-gray-300"
                >
                    Usage Rate
                </dt>
                <dd
                    class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white"
                >
                    58
                </dd>
            </div>

            <div
                class="px-4 py-5 overflow-hidden bg-white rounded-lg shadow dark:bg-gray-700 sm:p-6"
            >
                <dt
                    class="text-sm font-medium text-gray-500 truncate dark:text-gray-300"
                >
                    Usage Today
                </dt>
                <dd
                    class="mt-1 text-3xl font-semibold text-gray-900 dark:text-white"
                >
                    400
                </dd>
            </div>
        </dl>
    </div>
</template>
<script setup></script>
