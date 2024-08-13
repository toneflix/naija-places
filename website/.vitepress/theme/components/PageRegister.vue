<template>
    <div class="flex flex-col justify-center min-h-full py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <img
                class="w-auto h-20 mx-auto"
                :src="site.themeConfig.logo"
                alt="Logo"
            />
            <h2
                class="mt-6 text-3xl font-extrabold text-center text-gray-900 dark:text-white"
            >
                Create your account
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600 dark:text-white">
                Or
                <a
                    href="/portal/login.html"
                    class="font-medium text-primary hover:text-green-800 dark:text-gray-300 dark:hover:text-gray-100"
                >
                    login to your existing account
                </a>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div
                class="px-4 py-8 bg-white shadow dark:bg-black sm:rounded-lg sm:px-10"
            >
                <form @submit.prevent="send" class="space-y-6">
                    <div>
                        <label
                            for="email"
                            class="block text-sm font-medium text-gray-700 dark:text-white"
                        >
                            Fullname
                        </label>
                        <div class="mt-1">
                            <input
                                v-model="form.name"
                                id="name"
                                type="text"
                                autocomplete="name"
                                required
                                class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 border-solid rounded-md appearance-none dark:border-gray-800 dark:bg-slate-950 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                            />
                            <p
                                class="mt-2 text-sm text-red-700"
                                v-if="errors?.name"
                            >
                                {{ errors.name }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <label
                            for="email"
                            class="block text-sm font-medium text-gray-700 dark:text-white"
                        >
                            Email address
                        </label>
                        <div class="mt-1">
                            <input
                                v-model="form.email"
                                id="email"
                                type="email"
                                autocomplete="email"
                                required
                                class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 border-solid rounded-md appearance-none dark:border-gray-800 dark:bg-slate-950 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                            />
                            <p
                                class="mt-2 text-sm text-red-700"
                                v-if="errors?.email"
                            >
                                {{ errors.email }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <label
                            for="password"
                            class="block text-sm font-medium text-gray-700 dark:text-white"
                        >
                            Password
                        </label>
                        <div class="mt-1">
                            <input
                                v-model="form.password"
                                id="password"
                                type="password"
                                autocomplete="new-password"
                                required
                                class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 border-solid rounded-md appearance-none dark:border-gray-800 focus:outline-none focus:ring-primary dark:bg-slate-950 focus:border-primary sm:text-sm"
                            />
                            <p
                                class="mt-2 text-sm text-red-700"
                                v-if="errors?.password"
                            >
                                {{ errors.password }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <label
                            for="password"
                            class="block text-sm font-medium text-gray-700 dark:text-white"
                        >
                            Repeat Password
                        </label>
                        <div class="mt-1">
                            <input
                                v-model="form.password_confirmation"
                                id="password_confirmation"
                                type="password"
                                autocomplete="new-password"
                                required
                                class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 border-solid rounded-md appearance-none dark:border-gray-800 focus:outline-none focus:ring-primary dark:bg-slate-950 focus:border-primary sm:text-sm"
                            />
                            <p
                                class="mt-2 text-sm text-red-700"
                                v-if="errors?.password_confirmation"
                            >
                                {{ errors.password_confirmation }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <CButton
                            type="submit"
                            label="Register"
                            :loading="loading"
                            class="w-full text-white focus:ring-primary bg-primary hover:bg-green-800"
                        />
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { useForm } from "alova/client";
import { alova } from "../../utils/alova";
import { useData, useRouter } from "vitepress";
import { computed } from "vue";
import { bootstrapStore } from "../../store/bootstrap";

const router = useRouter();
const errors = computed(() => (<any>error.value)?.errors);
const user = computed(() => bootstrapStore().user);

if (user.value?.id) {
    router.go("/portal/home");
}

const { send, form, error, loading } = useForm(
    (f) => {
        const e = alova.Post("v1/auth/register", f);
        e.meta = { authRole: "login" };
        return e;
    },
    {
        store: true,
        initialForm: {
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
        },
    }
).onSuccess(() => {
    router.go("/portal/home");
});
const { site } = useData();
</script>
