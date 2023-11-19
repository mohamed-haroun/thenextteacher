<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, useForm} from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import InputError from "@/Components/InputError.vue";
import axios from "axios";
import {ref, watch} from "vue";

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    grades: Array,
    types: Array
})

let form = useForm({
    grade:      '',
    subject:    '',
    type:       ''
})

let itemProps = (item) => {
    return {
        title: item.title,
    }
}

let submit = () => {
    form.post(route('testTypes.store'))
}

let grade = ref()
let subjects = ref([])
let getSubjects = (grade) => {
    axios.get(route('tests.subjectsOfGrade', {grade: grade})).then(response => subjects.value = response.data[0].subjects);
}

let subject = ref([])
let lessons = ref([])
let getLessons = (grade ,subject) => {
    axios.get(route('tests.lessonsOfSubject' , {grade: grade ,subject: subject})).then(response => lessons.value = response.data);
}

watch(grade, (newValue) => {
    getSubjects(form.grade);
})

watch(subject, (newValue) => {
    getLessons(form.grade, form.subject);
})

let snackbar = ref(true)

</script>

<template>
    <Head title="Types/Create"/>

    <Header class="sm:mx-3">
        <div class="flex justify-between items-center">
            <v-breadcrumbs class="text-sm">
                <template #default>
                    <v-breadcrumbs-item>
                        <Link :href="route('tests.index')">Tests</Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider>
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>
                    <v-breadcrumbs-item>
                        <Link :href="route('testTypes.index')">Types</Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider>
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>
                    <v-breadcrumbs-item disabled>
                        Create
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>

            <div v-if="$page.props.flash.error">
                <v-snackbar
                    v-model="snackbar"
                    location="top"
                    color="error"
                    variant="tonal"
                >
                    <template #default>
                        <p class="font-bold ">
                            <v-icon icon="mdi-close-octagon-outline" />
                            {{ $page.props.flash.error }}
                        </p>
                    </template>
                </v-snackbar>
            </div>
        </div>
    </Header>

    <div class="mx-auto sm:my-3 md:my-12 border p-5 w-full md:w-2/3  bg-white dark:bg-gray-800 shadow-lg rounded-lg">
        <v-form @submit.prevent="submit">

            <div class="mt-3">
                <v-select
                    class="dark:text-white dark:bg-gray-800 font-bold rounded-lg"
                    :closable-chips="true"
                    :chips="true"
                    :items="grades"
                    :item-props="itemProps"
                    label="Grade"
                    v-model="form.grade"
                    variant="outlined"

                    @update:modelValue="grade = form.grade"
                ></v-select>
                <InputError class="mt-2" :message="form.errors.grade"/>
            </div>
            <div class="mt-3">
                <v-select
                    class="dark:text-white dark:bg-gray-800 font-bold rounded-lg"
                    :closable-chips="true"
                    :chips="true"
                    :items="subjects"
                    :item-props="itemProps"
                    label="Subject"
                    v-model="form.subject"
                    variant="outlined"

                    @update:modelValue="subject = form.subject"
                ></v-select>
                <InputError class="mt-2" :message="form.errors.subject"/>
            </div>

            <div class="mt-3">
                <v-select
                    class="dark:text-white dark:bg-gray-800 font-bold rounded-lg"
                    :closable-chips="true"
                    :chips="true"
                    :items="types"
                    label="Type"
                    v-model="form.type"
                    variant="outlined"

                ></v-select>
                <InputError class="mt-2" :message="form.errors.type"/>
            </div>

            <div class="mt-3">
                <button
                    type="submit"
                    class="px-3 py-2 text-white bg-blue-500 rounded w-full"
                >Create
                </button>
            </div>
        </v-form>
    </div>

</template>
