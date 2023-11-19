<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import {ref} from "vue";

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    type: Object
})

let dialog = ref(false)
</script>

<template>
    <Head title="Question Type"/>

    <Header class="sm:mx-3">
        <div class="flex justify-between items-center">
            <v-breadcrumbs class="text-sm" active-class="text-blue-500">
                <template v-slot:divider>
                    <v-icon icon="mdi-chevron-right"></v-icon>
                </template>

                <template #default>
                    <v-breadcrumbs-item class="hidden sm:block">
                        <Link :href="route('questions.index')">Questions</Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider class="hidden sm:block">
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>
                    <v-breadcrumbs-item>
                        <Link :href="route('types.index')">Types</Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider>
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>
                    <v-breadcrumbs-item disabled>
                        {{ type.title }}
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>
        </div>
    </Header>

    <div class="sm:m-1 md:m-5 lg:m-12 p-5 rounded bg-white dark:bg-gray-700 dark:text-gray-100 flex flex-col md:flex-row justify-between">
        <dl>
            <dt class="uppercase text-xl font-bold my-3">{{ type.title }} :</dt>
            <dd>{{ type.header }}</dd>
        </dl>

        <div>
            <!--                Actions-->
            <div class="mx-3 border-t-2 sm:border-t-0 sm:border-s-2">

                <div class="flex flex-col sm:flex-row justify-between gap-5 items-center mx-auto p-3 my-5 bg-white dark:bg-gray-700">
                    <Link :href="route('types.edit', {type: type})">
                        <v-btn color="blue" prepend-icon="mdi-pencil">update</v-btn>
                    </Link>
                    <v-row justify="center">
                        <v-dialog
                            v-model="dialog"
                            persistent
                            width="500"
                        >
                            <template v-slot:activator="{ props }">
                                <v-btn
                                    color="red"
                                    v-bind="props"
                                    prepend-icon="mdi-delete"
                                >
                                    Delete
                                </v-btn>
                            </template>
                            <v-card>
                                <v-card-title class="text-h6 text-red-500">
                                    Delete {{ type.title }} question
                                </v-card-title>
                                <v-card-text class="text-sm">
                                    Are you sure to delete {{ type.title }} question?
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        color="error"
                                        variant="text"
                                        @click="dialog = false"
                                    >
                                        Cancel
                                    </v-btn>
                                    <Link as="button" :href="route('types.destroy', {type: type})"
                                          method="delete">
                                        <v-btn
                                            color="green-darken-1"
                                            variant="text"
                                            @click="dialog = false"
                                        >
                                            Agree
                                        </v-btn>
                                    </Link>
                                </v-card-actions>
                            </v-card>
                        </v-dialog>
                    </v-row>
                </div>
            </div>
        </div>
    </div>
</template>
