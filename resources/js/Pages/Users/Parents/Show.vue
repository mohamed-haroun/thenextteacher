<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Header from "@/Components/Header.vue";
import {Link} from "@inertiajs/vue3";
import {Head} from "@inertiajs/vue3";

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    parent: Object,
})

</script>

<template>

    <Head :title="parent.first_name + ' ' + parent.last_name" />

    <Header class="sm:mx-3">
        <div class="flex justify-between items-center">
            <v-breadcrumbs class="text-sm" >
                <template #default>
                    <v-breadcrumbs-item>
                        <Link :href="route('users.index')">Users</Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider>
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>

                    <v-breadcrumbs-item>
                        <Link :href="route('parents.index')">Parents</Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider>
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>

                    <v-breadcrumbs-item disabled>
                        {{ parent.first_name + ' ' + parent.last_name }}
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>
        </div>

    </Header>

    <div class="flex flex-col md:flex-row md:gap-5 md:m-8">
        <!--        Profile info-->
        <div class="lg:basis-1/3">
            <div class="flex flex-col md:flex-row justify-center items-center md:items-end space-x-6 shadow-lg rounded-lg border-b p-5 bg-white dark:bg-gray-800">
                <div>
                    <img v-if="parent.profile_pic" class="w-24 h-24 md:w-36 md:h-36 rounded-full"
                         :src="'/pics/' + parent.profile_pic"
                         alt="profile pic">


                </div>

                <div class="space-y-1">
                    <p class="text-blue-500 font-bold">{{ parent.first_name + ' ' + parent.last_name }}</p>
                    <p class="text-gray-500 text-sm capitalize">{{ parent.type }}</p>
                </div>
            </div>
            <div class="my-3 p-2 md:p-5 bg-white dark:bg-gray-800 dark:text-gray-200 shadow-lg rounded-lg">
                <h2>Profile Details</h2>
                <dl class="divide-y divide-gray-300 dark:divide-gray-500">
                    <div class="px-4 py-4 sm:grid grid-cols-1 sm:grid-cols-4 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Email:</dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-3 sm:mt-0 overflow-x-hidden text-ellipsis">
                            {{
                                parent.email
                            }}
                        </dd>
                    </div>
                    <div class="px-4 py-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Phone:</dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-3 sm:mt-0">
                            {{
                                parent.phone_number
                            }}
                        </dd>
                    </div>
                    <div class="px-4 py-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Type:</dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-3 sm:mt-0">
                            {{
                                parent.type
                            }}
                        </dd>
                    </div>
                </dl>
            </div>
            <!--            Address Details-->
            <div class="my-3 p-2 md:p-5 bg-white dark:bg-gray-800 dark:text-gray-200 shadow-lg rounded-lg">
                <h2>Address Details</h2>
                <dl class="divide-y divide-gray-300 dark:divide-gray-500">
                    <div class="px-4 py-4 sm:grid grid-cols-1 sm:grid-cols-4 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 sm:col-span-2 dark:text-slate-100">Governorate:</dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0 overflow-x-hidden text-ellipsis">
                            {{
                                parent.governorate
                            }}
                        </dd>
                    </div>
                    <div class="px-4 py-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 sm:col-span-2  dark:text-slate-100">City:</dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                            {{
                                parent.city
                            }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 md:basis-2/3 p-5 shadow-lg rounded-lg">
            <div>
                <h3>Address Details:</h3>
            </div>
        </div>
    </div>

</template>
