<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, useForm, usePage} from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import {ref} from "vue";
import InputError from "@/Components/InputError.vue";
import {useDark} from "@vueuse/core";

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    type: Object
})

let dialog = ref(false)

const isDark = useDark();

const form = useForm({
    title: usePage().props.type.title,
    header: usePage().props.type.header,
})

let submit = (type) => {
    form.patch(route('types.update', {type:type}))
}
</script>

<template>
    <Head title="Question Type"/>

    <Header class="mx-3">
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
                    <v-breadcrumbs-item>
                        <Link :href="route('types.index')">Types</Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider>
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>
                    <v-breadcrumbs-item>
                        <Link :href="route('types.show', {type:type})">{{ type.title }}</Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider>
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>
                    <v-breadcrumbs-item disabled>
                        Edit
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>
        </div>
    </Header>

    <div class="w-full md:w-2/3 lg:w-1/2 sm:mx-auto bg-white dark:bg-gray-500 my-5 md:my-12 p-5 rounded shadow-lg">
        <v-form @submit.prevent="submit(type)">
            <div>
                <v-text-field
                    clearable
                    persistent-clear
                    label="Title"
                    type="text"
                    class="mt-1 block w-full placeholder-slate-400 placeholder:text-sm rounded-lg"
                    v-model="form.title"
                    required
                    autocomplete="title"
                ></v-text-field>

                <InputError class="mt-2" :message="form.errors.title"/>
            </div>

            <div class="mt-3">
                <v-textarea
                    :color="isDark ? 'white':'gray'"
                    label="Header"
                    variant="outlined"
                    :base-color="isDark ? 'white':'gray'"
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
                    class="px-3 py-2 text-white bg-blue-500 rounded w-full"
                >Update</button>
            </div>
        </v-form>
    </div>
</template>
