<template>
    <div class="px-4 py-5 sm:px-6" v-if="!creating">
        <div
            class="flex flex-wrap items-center justify-between -mt-4 -ml-4 sm:flex-nowrap"
        >
            <div class="mt-4 ml-4"></div>
            <div class="flex-shrink-0 mt-4 ml-4">
                <CButton
                    class="text-white bg-primary hover:bg-primary focus:ring-primary"
                    @click="creating = true"
                >
                    Create new API key
                </CButton>
            </div>
        </div>
    </div>

    <div
        class="overflow-hidden bg-white shadow dark:bg-gray-700 sm:rounded-md"
        v-if="!creating"
    >
        <div class="flex justify-center p-4" v-if="loading">
            <CSpinner size="xl" />
        </div>
        <div class="text-center" v-else-if="!data?.length">
            <i class="mx-auto text-5xl text-gray-400 ri-folder-add-line"> </i>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">
                No API Keys
            </h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-200">
                Get started by creating a new one.
            </p>
            <div class="my-6">
                <CButton
                    type="button"
                    class="inline-flex items-center bg-green-600 hover:bg-green-700 focus:ring-green-500"
                    @click="creating = true"
                >
                    <i class="mr-2 -ml-1 text-xl ri-add-fill"> </i>
                    New API KEY
                </CButton>
            </div>
        </div>

        <ul role="list" class="divide-y divide-gray-200">
            <li :key="key.id" v-for="key in data">
                <a
                    :href="`/portal/api-key/?key=${key.id}`"
                    class="block hover:bg-gray-50 dark:hover:bg-gray-800"
                >
                    <div class="flex items-center px-4 py-4 sm:px-6">
                        <div class="flex items-center flex-1 min-w-0">
                            <div
                                class="flex-1 min-w-0 px-4 md:grid md:grid-cols-2 md:gap-4"
                            >
                                <div class="flex items-center gap-3">
                                    <div>
                                        <CButton
                                            dense
                                            type="button"
                                            class="px-1.5 py-1 text-white bg-red-600 hover:bg-red-700 focus:ring-red-500"
                                            :loading="deleting === key.id"
                                            @click.prevent="deleteIt(key.id)"
                                        >
                                            <i
                                                class="text-sm ri-delete-bin-fill"
                                            >
                                            </i>
                                        </CButton>
                                    </div>
                                    <div>
                                        <p
                                            class="text-sm font-medium truncate text-primary dark:text-white"
                                        >
                                            {{ key.name }}
                                        </p>
                                        <p
                                            class="flex items-center gap-2 mt-2 text-sm text-gray-500 dark:text-gray-400"
                                        >
                                            <CButton
                                                class="px-1 py-0.5 text-white hover:bg-gray-600 focus:ring-1"
                                                icon="ri-file-copy-fill"
                                                @click="copyClip(key.key)"
                                                v-if="!key.key.includes('****')"
                                            />
                                            <span class="truncate max-w-96">
                                                {{ key.key }}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                                <div class="items-center hidden md:flex">
                                    <div>
                                        <p
                                            class="text-sm text-gray-900 dark:text-white"
                                        >
                                            Created on
                                            <time :datetime="key.createdAt">
                                                {{ key.createDate }}
                                            </time>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <i
                                class="w-5 h-5 text-gray-400 dark:text-white ri-arrow-right-s-line"
                            >
                            </i>
                        </div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <div class="mt-10 sm:mt-0" v-else>
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="mt-5 md:mt-0 md:col-span-3">
                <form @submit.prevent="send">
                    <div class="overflow-hidden shadow sm:rounded-md">
                        <div class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6">
                                    <label
                                        for="name"
                                        class="block text-sm font-medium text-gray-700 dark:text-white"
                                        >Key name</label
                                    >
                                    <input
                                        v-model="form.name"
                                        type="text"
                                        name="name"
                                        id="name"
                                        autocomplete="off"
                                        class="block w-full mt-1 text-black border-gray-500 border-solid rounded-md shadow-sm dark:bg-gray-400 focus:ring-green-500 focus:border-primary sm:text-sm"
                                    />

                                    <p
                                        class="mt-2 text-sm text-red-700"
                                        v-if="errors?.name"
                                    >
                                        {{ errors.name }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="flex gap-3 px-4 py-3 text-right bg-gray-50 dark:bg-gray-700 sm:px-6"
                        >
                            <CButton
                                class="text-white bg-red-600 hover:bg-red-600 focus:ring-red-600"
                                @click="creating = false"
                            >
                                Cancel
                            </CButton>
                            <CButton
                                type="submit"
                                class="text-white bg-primary hover:bg-primary focus:ring-primary"
                                :loading="submitting"
                            >
                                Create
                            </CButton>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { useForm, usePagination } from "alova/client";
import { computed, ref } from "vue";
import { alova } from "../../utils/alova";
import { confirm, copyClip, notify } from "../../utils/tools";
import CButton from "./CButton.vue";

const creating = ref(false);

type ApiKey = {
    id: number;
    key: string;
    name: string;
    createdAt: string;
    rateLimit: number;
    createDate: number;
};

const { data, update, loading } = usePagination(
    (page, limit) =>
        alova.Get<{
            data: ApiKey[];
        }>("v1/account/api-keys", {
            hitSource: [/^createKey/],
            params: {
                page,
                limit,
            },
        }),
    {
        initialPageSize: 30,
        initialData: { data: [] },
    }
);

const errors = computed(() => (<any>error.value)?.errors);

const {
    send,
    form,
    error,
    loading: submitting,
} = useForm(
    (f) =>
        alova.Post<{ data: ApiKey }>("v1/account/api-keys", f, {
            name: "createKey",
        }),
    {
        store: true,
        resetAfterSubmiting: true,
        initialForm: {
            name: "",
        },
    }
).onSuccess(({ data: e }) => {
    creating.value = false;
    update({ data: [...data.value, e.data] });
    notify("API key created successfully!");
});

const deleting = ref<number | null>(null);
const deleteIt = async (id: number) => {
    await confirm(
        "Once deleted, all applications dependent on this key will no longer be able to access the API.",
        "Cornfirm Delete",
        [true, "Yes Delete"]
    ).then(async () => {
        deleting.value = id;
        await alova
            .Delete("v1/account/api-keys/" + id, {
                name: "deleteKey",
            })
            .send()
            .finally(() => {
                deleting.value = null;
            });
        update({ data: data.value.filter((e) => e.id !== id) });
        notify("API key deleted successfully!");
    });
};
</script>
