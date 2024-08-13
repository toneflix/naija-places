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
                Account Recovery
            </h2>
            <p class="mt-2 text-sm text-center text-gray-600 dark:text-white">
                We'll help you recover your account
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div
                class="px-4 py-8 bg-white shadow dark:bg-black sm:rounded-lg sm:px-10"
            >
                <form @submit.prevent="send" class="space-y-6">
                    <CAlert
                        :showing="!!(<any>error)?.data?.message || !!data?.message"
                        :message="(<any>error)?.data?.message || data?.message"
                        :type="error ? 'error' : 'success'"
                    />
                    <div v-if="step === 1">
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
                    <div v-else-if="step === 2">
                        <label
                            for="email"
                            class="block text-sm font-medium text-gray-700 dark:text-white"
                        >
                            Recovery Code
                        </label>
                        <div class="mt-1">
                            <input
                                v-model="form.code"
                                id="code"
                                type="text"
                                required
                                class="block w-full px-3 py-2 placeholder-gray-400 border border-gray-300 border-solid rounded-md appearance-none dark:border-gray-800 dark:bg-slate-950 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm"
                            />
                            <p
                                class="mt-2 text-sm text-red-700"
                                v-if="errors?.code"
                            >
                                {{ errors.code }}
                            </p>
                        </div>
                    </div>
                    <template v-else-if="step === 3">
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
                                    autocomplete="current-password"
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
                                    id="password"
                                    type="password"
                                    autocomplete="current-password"
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
                    </template>

                    <div
                        class="flex items-center justify-between"
                        v-if="step < 4"
                    >
                        <div class="flex items-center">
                            <CButton
                                v-if="step === 2"
                                label="Resend"
                                class="w-full text-gray-600 border-gray-400 border-solid focus:ring-gray-500 dark:border-white dark:hover:border-gray-400 dark:hover:text-gray-400 dark:text-white hover:text-gray-400 hover:border-gray-400"
                                @click="(step = 1), (data.message = null)"
                            />
                        </div>

                        <div class="text-sm">
                            <a
                                href="/portal/login.html"
                                class="font-medium text-primary hover:text-primary"
                            >
                                Login Instead
                            </a>
                        </div>
                    </div>

                    <div>
                        <CButton
                            v-if="step < 4"
                            label="Request"
                            type="submit"
                            :loading="loading"
                            class="w-full text-white focus:ring-primary bg-primary hover:bg-green-800"
                        />
                        <CButton
                            v-else
                            href="/portal/login.html"
                            class="w-full text-white focus:ring-primary bg-primary hover:bg-green-800"
                        >
                            Continue to login
                        </CButton>
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
import { computed, ref } from "vue";
import { bootstrapStore, User } from "../../store/bootstrap";

const step = ref(1);
const router = useRouter();
const errors = computed(() => (<any>error.value)?.errors);
const user = computed(() => bootstrapStore().user);

if (user.value?.id) {
    router.go("/portal/home");
}

const { send, form, error, data, reset, loading } = useForm(
    (f) => {
        let url = "v1/auth/forgot-password";
        if (step.value >= 2) {
            url = `v1/auth/reset-password/${!f?.password ? "check-code" : ""}`;
        }

        const e = alova.Post<{ message: string | null }>(url, f);
        e.meta = { authRole: null };
        return e;
    },
    {
        store: true,
        initialForm: {
            code: null,
            email: null,
            password: null,
            password_confirmation: null,
        },
    }
).onSuccess(() => {
    if (step.value === 3) {
        // router.go("/portal/login");
        step.value = 4;
        reset();
    } else if (step.value === 2) {
        step.value = 3;
    } else if (step.value === 1) {
        step.value = 2;
    } else {
        step.value = 1;
    }
});

const { site } = useData();
</script>
