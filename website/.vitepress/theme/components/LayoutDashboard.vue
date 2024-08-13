<template>
    <div>
        <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
        <div
            class="fixed inset-0 z-40 flex md:hidden"
            role="dialog"
            aria-modal="true"
            v-if="toggleSideBar"
        >
            <div
                class="fixed inset-0 bg-gray-600 bg-opacity-75"
                aria-hidden="true"
            ></div>
            <div
                class="relative flex flex-col flex-1 w-full max-w-xs bg-white dark:bg-gray-800"
            >
                <div class="absolute top-0 right-0 pt-2 -mr-12">
                    <button
                        type="button"
                        class="flex items-center justify-center w-10 h-10 ml-1 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                        @click="toggleSideBar = false"
                    >
                        <span class="sr-only">Close sidebar</span>

                        <i
                            class="w-6 h-6 text-xl text-white 0 ri-close-line"
                        ></i>
                    </button>
                </div>

                <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                    <div class="flex items-center flex-shrink-0 px-4">
                        <img
                            class="w-auto h-8"
                            :src="site.themeConfig.logo"
                            alt="Logo"
                        />
                    </div>
                    <nav class="px-2 mt-5 space-y-1">
                        <a
                            class="flex items-center px-2 py-2 text-sm font-medium rounded-md group"
                            :href="link.link"
                            :class="buildLinkClass(link.link)"
                            :key="link.link"
                            @click.prevent="link.click"
                            v-for="link in links"
                        >
                            <i
                                class="flex-shrink-0 mr-4 text-xl text-gray-400 group-[.active]:text-gray-700 dark:group-[.active]:text-gray-300"
                                :class="link.icon"
                            >
                            </i>
                            {{ link.label }}
                        </a>
                    </nav>
                </div>
                <div class="flex flex-shrink-0 p-4 bg-gray-700">
                    <a href="#" class="flex-shrink-0 block group">
                        <div class="flex items-center">
                            <div>
                                <img
                                    class="inline-block w-10 h-10 rounded-full"
                                    :src="user.imageUrl"
                                    :alt="user.fullname"
                                />
                            </div>
                            <div class="ml-3">
                                <p class="text-base font-medium text-white">
                                    {{ user.fullname }}
                                </p>
                                <p
                                    class="text-sm font-medium text-gray-400 group-hover:text-gray-300"
                                >
                                    {{ user.email }}
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="flex-shrink-0 w-14">
                <!-- Force sidebar to shrink to fit close icon -->
            </div>
        </div>

        <!-- Static sidebar for desktop -->
        <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div
                class="flex flex-col flex-1 min-h-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-r-0"
            >
                <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
                    <div class="flex items-center flex-shrink-0 px-4">
                        <img
                            class="w-auto h-8"
                            :src="site.themeConfig.logo"
                            alt="Logo"
                        />
                    </div>
                    <nav class="flex-1 px-2 mt-5 space-y-1">
                        <a
                            class="flex items-center px-2 py-2 text-sm font-medium rounded-md group"
                            :href="link.link"
                            :class="buildLinkClass(link.link)"
                            :key="link.link"
                            @click.prevent="link.click"
                            v-for="link in links"
                        >
                            <i
                                class="flex-shrink-0 mr-4 text-xl text-gray-400 group-[.active]:text-gray-700 dark:group-[.active]:text-gray-300"
                                :class="link.icon"
                            >
                            </i>
                            {{ link.label }}
                        </a>
                    </nav>
                </div>
                <div
                    class="flex flex-shrink-0 p-4 bg-white border-t border-gray-200 dark:bg-gray-700 dark:border-t-0"
                >
                    <a href="#" class="flex-shrink-0 block w-full group">
                        <div class="flex items-center">
                            <div>
                                <img
                                    class="inline-block rounded-full h-9 w-9"
                                    :src="user.imageUrl"
                                    :alt="user.fullname"
                                />
                            </div>
                            <div class="ml-3">
                                <p
                                    class="text-sm font-medium text-gray-700 dark:text-white"
                                >
                                    {{ user.fullname }}
                                </p>
                                <p
                                    class="text-xs font-medium text-gray-500 dark:text-gray-300 group-hover:text-gray-200"
                                >
                                    {{ user.email }}
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="flex flex-col flex-1 md:pl-64">
            <div
                class="sticky top-0 z-10 pt-1 pl-1 bg-gray-100 md:hidden sm:pl-3 sm:pt-3"
            >
                <button
                    type="button"
                    class="-ml-0.5 -mt-0.5 h-12 w-12 inline-flex items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                    @click="toggleSideBar = true"
                >
                    <span class="sr-only">Open sidebar</span>
                    <i class="w-6 h-6 text-xl ri-menu-fill"></i>
                </button>
            </div>
            <main class="flex-1">
                <div class="py-6">
                    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <h1
                            class="text-2xl font-semibold text-gray-900 dark:text-white"
                        >
                            {{ pageTitle }}
                        </h1>
                    </div>
                    <div class="px-4 mx-auto max-w-7xl sm:px-6 md:px-8">
                        <div class="py-4">
                            <slot></slot>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>
<script setup lang="ts">
import { computed, ref } from "vue";
import { bootstrapStore } from "../../store/bootstrap";
import { useData, useRouter } from "vitepress";
import { alova } from "../../utils/alova";
import { useRequest } from "alova/client";

const user = computed(() => bootstrapStore().user);
const toggleSideBar = ref(false);
const route = useRouter();
const router = useRouter();
const { site } = useData();

defineProps({
    pageTitle: {
        type: String,
        default: "Dashboard",
    },
});

bootstrapStore().$subscribe((e, state) => {
    if (state.redirect) {
        router.go(state.redirect);
        bootstrapStore().setRedirect();
    }
});

if (!user.value?.id) {
    router.go("/portal/login");
}

const buildLinkClass = (link: string) => {
    return route.route.path === link
        ? "dark:bg-gray-900 dark:text-white text-gray-900 bg-gray-300 group active hover:bg-gray-50 hover:text-gray-900 text-gray-600"
        : "dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white hover:bg-gray-50 hover:text-gray-900 text-gray-700 group-hover:text-gray-500";
};

const { send: logout } = useRequest(
    () => {
        const e = alova.Post("v1/account/logout");
        e.meta = {
            authRole: "logout",
        };
        return e;
    },
    {
        immediate: false,
    }
).onSuccess(() => {
    router.go("/");
});

const links = [
    {
        label: "Dashboard",
        icon: "ri-dashboard-line",
        link: "/portal/home.html",
        click: () => route.go("/portal/home"),
    },
    {
        label: "API Keys",
        icon: "ri-key-line",
        link: "/portal/api-keys.html",
        click: () => route.go("/portal/api-keys"),
    },
    {
        label: "Documentation",
        icon: "ri-book-line",
        link: "/api-documentation.html",
        click: () => route.go("/api-documentation"),
    },
    {
        label: "Logout",
        icon: "ri-logout-circle-line",
        link: "/portal/keys.html",
        click: logout,
    },
];
</script>
