<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, router, useForm, usePage} from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import {ref} from "vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {useDark} from "@vueuse/core";

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    types: Array
})

let panel = ref([])

function all()  {
    panel.value = usePage().props.types.map((type) => {
        return type.title
    })
}
function none () {
    panel.value = []
}

let isDark = useDark()

let form = useForm({
    title: null,
    header: null
})

let submit = () => {
    form.post(route('types.store'))

    form.reset()
}
</script>

<template>
    <Head title="Question Type"/>

    <Header class="sm:mx-3">
        <div class="flex justify-between items-center">
            <v-breadcrumbs class="text-sm" active-color="error">
                <template v-slot:divider>
                    <v-icon icon="mdi-chevron-right"></v-icon>
                </template>

                <template #default>
                    <v-breadcrumbs-item>
                        <Link :href="route('questions.index')">Questions</Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider>
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>
                    <v-breadcrumbs-item disabled>
                        Types
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>

            <div v-if="form.recentlySuccessful" class="text-green-600">Type added successfully</div>

            <v-dialog width="500">
                <template v-slot:activator="{ props }">
                    <v-btn v-bind="props" class="bg-blue-500 text-white text-xs sm:text-sm md:text-md xl:text-base"
                           prepend-icon="mdi-plus-thick" text="Type"></v-btn>
                </template>

                <template v-slot:default="{ isActive }">
                    <v-card title="Add New Question Type" class="dark:bg-gray-800 dark:text-blue-400">
                        <v-card-text>
                            <v-form @submit.prevent="submit">
                                <div>
                                    <v-text-field
                                        clearable
                                        persistent-clear
                                        label="Title"
                                        type="text"
                                        class="mt-1 block w-full"
                                        v-model="form.title"
                                        required
                                        autocomplete="title"
                                    ></v-text-field>

                                    <InputError class="mt-2" :message="form.errors.title"/>
                                </div>

                                <div class="mt-3">
                                    <v-textarea
                                        label="Header"
                                        variant="outlined"
                                        id="header"
                                        type="text"
                                        class="mt-1 text-color-blue block w-full placeholder-slate-400 placeholder:text-sm"
                                        v-model="form.header"
                                        required
                                        placeholder="Enter question header"
                                    ></v-textarea>

                                    <InputError class="mt-2" :message="form.errors.header"/>
                                </div>

                                <div class="mt-3">
                                    <button
                                        type="submit"
                                        @click="isActive.value = false"
                                        class="px-3 py-2 text-white bg-blue-500 dark:bg-blue-500/80 rounded w-full"
                                    >Create</button>
                                </div>
                            </v-form>
                        </v-card-text>

                        <v-card-actions>
                            <v-spacer></v-spacer>

                            <v-btn
                                class="bg-red-500 text-white"
                                text="Cancel"
                                @click="isActive.value = false"
                            ></v-btn>
                        </v-card-actions>
                    </v-card>
                </template>
            </v-dialog>
        </div>
    </Header>

    <div class="m-1 md:m-3 lg:m-5 sm:p-5 md:p-12 shadow-lg rounded-lg bg-white dark:bg-gray-800 dark:text-gray-100">

        <div class="text-center d-flex pb-4">
            <v-btn class="ma-2 dark:bg-gray-500 dark:text-gray-200" @click="all">
                All
            </v-btn>
            <v-btn class="ma-2 dark:bg-gray-500 dark:text-gray-200" @click="none">
                None
            </v-btn>
        </div>

        <v-expansion-panels
            v-model="panel"
            multiple
        >
            <v-expansion-panel v-for="type in types" :value="type.title">
                <v-expansion-panel-title class="dark:bg-gray-700 dark:text-gray-300" expand-icon="mdi-plus" collapse-icon="mdi-minus">
                    <Link :href="route('types.show', {type: type})">{{ type.title }}</Link>
                </v-expansion-panel-title>
                <v-expansion-panel-text class="dark:bg-gray-700 dark:text-gray-300">
                    <p>Header: {{ type.header ?? 'customized by user !!' }}</p>
                    <Link class="text-blue-500 hover:underline underline-offset-4" :href="route('types.show', {type: type})">Show</Link>

                </v-expansion-panel-text>
            </v-expansion-panel>

        </v-expansion-panels>

    </div>
</template>
