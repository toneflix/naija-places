<template>
    <button
        v-if="!href && !to"
        :type="type"
        class="flex justify-center text-sm font-medium border border-transparent shadow-sm focus:outline-none"
        :class="{
            'px-4 py-2': !dense && !/p[x,y]?-\d+/.test($attrs.class),
            'rounded-md': !square,
            'py-0.5 px-0.5': dense && !/p[x,y]?-\d+/.test($attrs.class),
            'focus:ring-2 focus:ring-offset-2': !/focus:ring-+/.test(
                $attrs.class
            ),
        }"
    >
        <slot name="icon" :loading="loading">
            <i class="text-current" :class="icon" v-if="!loading" />
        </slot>
        <slot name="loading" :loading="loading">
            <CSpinner v-if="loading" />
        </slot>
        <slot :loading="loading" v-if="!loading">
            <span> {{ label }} </span>
        </slot>
    </button>
    <a
        v-else
        class="flex justify-center text-sm font-medium border border-transparent shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2"
        :class="{
            'px-4 py-2': !dense && !/p[x,y]?-\d+/.test($attrs.class),
            'rounded-md': !square,
            'py-0.5 px-0.5': dense && !/p[x,y]?-\d+/.test($attrs.class),
            'focus:ring-2 focus:ring-offset-2': !/focus:ring-+/.test(
                $attrs.class
            ),
        }"
        :href="href || to"
    >
        <slot name="icon" :loading="loading">
            <i :class="icon" v-if="!loading" />
        </slot>
        <slot name="loading" :loading="loading">
            <CSpinner v-if="loading" />
        </slot>
        <slot :loading="loading">
            <span v-if="!loading"> {{ label }} </span>
        </slot>
    </a>
</template>
<script setup>
defineProps({
    loading: Boolean,
    square: Boolean,
    dense: Boolean,
    label: String,
    icon: String,
    type: String,
    href: String,
    to: String,
});
</script>
