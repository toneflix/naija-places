<template>
    <div>
        <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
        <div
            class="fixed inset-0 z-40 flex md:hidden"
            role="dialog"
            aria-modal="true"
            v-show="toggleSideBar"
        >
            <div
                class="fixed inset-0 bg-gray-600 bg-opacity-75"
                aria-hidden="true"
                @click="toggleSideBar = !toggleSideBar"
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
                        <a href="/">
                            <img
                                class="w-auto h-8"
                                :src="site.themeConfig.logo"
                                alt="Logo"
                            />
                        </a>
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
                                    class="text-xs font-medium text-gray-500 dark:text-gray-300 group-hover:text-gray-400"
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
                        <a href="/">
                            <img
                                class="w-auto h-8"
                                :src="site.themeConfig.logo"
                                alt="Logo"
                            />
                        </a>
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
                                    class="text-xs font-medium text-gray-500 dark:text-gray-300 group-hover:text-gray-400"
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
                class="sticky top-0 z-10 flex flex-shrink-0 h-16 bg-white shadow dark:bg-gray-700"
            >
                <button
                    type="button"
                    class="px-4 text-gray-500 border-r border-gray-200 dark:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary dark:focus:ring-gray-700 md:hidden"
                    @click="toggleSideBar = !toggleSideBar"
                >
                    <span class="sr-only">Open sidebar</span>
                    <i class="w-6 h-6 text-xl ri-menu-2-fill"></i>
                </button>
                <div class="flex justify-between flex-1 px-4">
                    <div class="flex flex-1"></div>
                    <div class="flex items-center ml-4 md:ml-6">
                        <button
                            type="button"
                            class="relative inline-flex flex-shrink-0 h-6 transition-colors duration-200 ease-in-out bg-gray-200 border-2 border-transparent rounded-full cursor-pointer w-11 focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-primary"
                            role="switch"
                            aria-checked="false"
                            @click="isDark = !isDark"
                        >
                            <span class="sr-only">Toggle Dark Mode</span>
                            <span
                                class="relative inline-block w-6 h-6 transition duration-200 ease-in-out transform translate-x-0 bg-white rounded-full shadow pointer-events-none ring-0"
                                :class="
                                    isDark ? 'translate-x-5' : 'translate-x-0'
                                "
                            >
                                <span
                                    class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity duration-200 ease-in opacity-100"
                                    aria-hidden="true"
                                    v-show="!isDark"
                                    :class="
                                        isDark
                                            ? 'opacity-0 ease-out duration-100'
                                            : 'opacity-100 ease-in duration-200'
                                    "
                                >
                                    <i
                                        class="text-xs text-gray-400 ri-sun-line"
                                    ></i>
                                </span>
                                <span
                                    class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity duration-100 ease-out opacity-0"
                                    aria-hidden="true"
                                    v-show="isDark"
                                    :class="
                                        isDark
                                            ? 'opacity-100 ease-in duration-200'
                                            : 'opacity-0 ease-out duration-100'
                                    "
                                >
                                    <i
                                        class="text-xs text-black ri-moon-fill"
                                    ></i>
                                </span>
                            </span>
                        </button>
                        <!-- Profile dropdown -->
                        <div class="relative ml-3">
                            <div>
                                <button
                                    type="button"
                                    class="flex items-center max-w-xs text-sm bg-white rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary"
                                    id="user-menu-button"
                                    aria-expanded="false"
                                    aria-haspopup="true"
                                    @click="toggleUserMenu = !toggleUserMenu"
                                >
                                    <span class="sr-only">Open user menu</span>
                                    <img
                                        class="w-8 h-8 rounded-full"
                                        :src="user.imageUrl"
                                        :alt="user.fullname"
                                    />
                                </button>
                            </div>

                            <Transition
                                enter-active-class="transition duration-100 ease-out"
                                enter-from-class="transform scale-95 opacity-0"
                                enter-to-class="transform scale-100 opacity-100"
                                leave-active-class="transition duration-75 ease-in"
                                leave-from-class="transform scale-100 opacity-100"
                                leave-to-class="transform scale-95 opacity-0"
                            >
                                <div
                                    class="absolute right-0 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                    role="menu"
                                    aria-orientation="vertical"
                                    aria-labelledby="user-menu-button"
                                    tabindex="-1"
                                    v-show="toggleUserMenu"
                                >
                                    <!-- Active: "bg-gray-100", Not Active: "" -->
                                    <!-- <a
                                        href="#"
                                        class="block px-4 py-2 text-sm text-gray-700"
                                        role="menuitem"
                                        tabindex="-1"
                                        id="user-menu-item-0"
                                        >Your Profile</a
                                    >

                                    <a
                                        href="#"
                                        class="block px-4 py-2 text-sm text-gray-700"
                                        role="menuitem"
                                        tabindex="-1"
                                        id="user-menu-item-1"
                                        >Settings</a
                                    > -->

                                    <a
                                        href="/portal/home?logout=true"
                                        class="block px-4 py-2 text-sm text-gray-700"
                                        role="menuitem"
                                        tabindex="-1"
                                        id="user-menu-item-2"
                                        @click="logout"
                                        >Logout</a
                                    >
                                </div>
                            </Transition>
                        </div>
                    </div>
                </div>
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
const route = useRouter();
const router = useRouter();
const toggleSideBar = ref(false);
const toggleUserMenu = ref(false);
const { site, isDark } = useData();

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

const { send: logout, onSuccess: loggedOut } = useRequest(
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
);

loggedOut(() => {
    router.go("/portal/login");
});

const links = [
    {
        label: "Dashboard",
        icon: "ri-dashboard-line",
        link: "/portal/home",
        click: () => route.go("/portal/home"),
    },
    {
        label: "API Keys",
        icon: "ri-key-line",
        link: "/portal/api-keys",
        click: () => route.go("/portal/api-keys"),
    },
    {
        label: "Documentation",
        icon: "ri-book-line",
        link: "/api-documentation",
        click: () => route.go("/api-documentation"),
    },
];
</script>
