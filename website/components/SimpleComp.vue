<template>Hello</template>
<script setup lang="ts">
import { bootstrapStore } from "../.vitepress/store/bootstrap.ts";

const store = bootstrapStore();
console.log(store);
</script>
