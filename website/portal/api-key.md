---
layout: false
---

<ClientOnly>
    <LayoutDashboard :page-title="store.cache.pageTitle ?? 'Api Key'">
        <PageApiKey />
    </LayoutDashboard>
</ClientOnly>

<script setup>
import { bootstrapStore } from "../.vitepress/store/bootstrap";
const store = bootstrapStore(); 
</script>
