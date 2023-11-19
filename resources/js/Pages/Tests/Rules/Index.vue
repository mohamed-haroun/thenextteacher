<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, router, useForm} from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
})

const form = useForm({

});
</script>

<template>
    <Head title="Tests"/>

    <Header class="mx-3">
        <div class="flex justify-between items-center">
            <v-breadcrumbs class="text-sm">
                <template v-slot:divider>
                    <v-icon icon="mdi-chevron-right"></v-icon>
                </template>

                <template #default>
                    <v-breadcrumbs-item>
                        <Link :href="route('tests.index')">Tests</Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider>
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>
                    <v-breadcrumbs-item disabled>
                        Rules
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>
        </div>

    </Header>

    <div class="m-5">
        <div class="flex justify-between items-center gap-5">
            <div class="bg-white dark:bg-gray-700 w-full h-full shadow p-3">total</div>
            <div class="bg-white dark:bg-gray-700 w-full h-full shadow p-3">exams</div>
            <div class="bg-white dark:bg-gray-700 w-full h-full shadow p-3">quizzes</div>
            <div class="bg-white dark:bg-gray-700 w-full h-full shadow p-3">Rules</div>
        </div>

    </div>

</template>
