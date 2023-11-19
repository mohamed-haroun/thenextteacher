<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, useForm} from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import InputError from "@/Components/InputError.vue";
import axios from "axios";
import {ref, watch} from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    grades: Array,
})

let form = useForm({
    grade: '',
    subject: '',
    lessons: '',
    type: null,
    duration: "15",
    degree: "15"
})

let itemProps = (item) => {
    return {
        title: item?.title,
    }
}

let LessonProps = (item) => {
    return {
        title: item?.title,
        subtitle: "Lesson: " + item.code + ' chapter: ' + item.chapter,
    }
}

let getRules = (item) => {
    if (item?.rules?.length) {
        return item.rules.reduce((prev, current) => {
            return prev += ' => ' + current.count + ' ' + current.question_type.title
        }, '')
    } else {
        return 0
    }
}

let submit = () => {
    form.post(route('tests.store'))
}

// Getting the specified subject from a grade
let grade = ref()
let subjects = ref([])
let getSubjects = (grade) => {
    axios.get(route('tests.subjectsOfGrade', {grade: grade}))
        .then(response => subjects.value = response.data[0].subjects);
}

// Getting the specified lessons from a subject
let subject = ref([])
let lessons = ref([])
let getLessons = (grade, subject) => {
    axios.get(route('tests.lessonsOfSubject', {grade: grade, subject: subject}))
        .then(response => lessons.value = response.data);
}

let testTypes = ref([])
// Getting the exam types
let getTestsTypes = (grade, subject) => {
    axios.get(route('tests.testTypesOfSubjectGrade', {grade: grade, subject: subject}))
        .then(response => testTypes.value = response.data);
}


watch(grade, (newValue) => {
    getSubjects(form.grade);
})

watch(subject, (newValue) => {
    getLessons(form.grade, form.subject);
})

watch(subject, (newValue) => {
    getTestsTypes(form.grade, form.subject);
})

let snackbar = ref(true)

</script>

<template>
    <Head title="Tests/Generate"/>

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
                    <v-breadcrumbs-item disabled>
                        Generate
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>
        </div>
    </Header>

    <!--    The flash methods-->
    <div v-if="$page.props.flash.error">
        <v-snackbar
            v-model="snackbar"
            location="top"
            color="error"
            variant="tonal"
        >
            <template #default>
                <p class="font-bold ">
                    <v-icon icon="mdi-close-octagon-outline"/>
                    {{ $page.props.flash.error }}
                </p>
            </template>
        </v-snackbar>
    </div>

    <div class="flex justify-between items-start mx-12 xs:mb-3 md:mb-8 lg:mb-12 gap-8">
        <div class="basis-2/3 mx-auto border p-5 bg-white dark:bg-gray-800 shadow-lg rounded-lg">
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
                        :items="lessons"
                        :item-props="LessonProps"
                        label="Lessons"
                        v-model="form.lessons"
                        variant="outlined"
                        multiple
                    ></v-select>
                    <InputError class="mt-2" :message="form.errors.lessons"/>
                </div>

                <div class="mb-5 flex items-center justify-center gap-5">
                    <div>
                        <InputLabel for="type" value="Test Type"/>
                        <select
                            name="type"
                            id="type"
                            v-model="form.type"
                            placeholder="Select The type of test"
                            class="block border dark:text-gray-400 rounded mt-2 bg-white dark:bg-gray-900">
                            <option v-if="!form.type" :value="null" selected="selected">No type is selected yet</option>
                            <option
                                v-for="(testType, index) in testTypes"
                                :value="testType"
                                class="text-gray-600 dark:text-gray-400 p-5 my-3 block"
                                :key="testType.id"
                            >
                                {{ testType.title + ' ' }} {{ index + 1 }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.type"/>
                    </div>

                    <div>
                        <InputLabel for="degree" value="Degree"/>
                        <TextInput type="number" id="degree" name="degree" class="mt-2" v-model="form.degree" />
                        <InputError class="mt-2" :message="form.errors.degree"/>
                    </div>
                </div>

                <div>
                    <InputLabel class="font-bold" value="Duration" for="duration"/>
                    <v-slider
                        step="5"
                        max="120"
                        show-ticks="always"
                        tick-size="4"
                        thumb-label="always"
                        v-model="form.duration"
                    ></v-slider>
                    <InputError class="mt-2" :message="form.errors.duration"/>
                </div>

                <div class="mt-3">
                    <button
                        type="submit"
                        class="px-3 py-2 text-white bg-blue-500 dark:bg-blue-500/80 rounded w-full"
                    >Create
                    </button>
                </div>
            </v-form>
        </div>
        <div class="basis-1/3 bg-white dark:bg-gray-800 shadow-lg rounded-lg">
            <div class="mb-1">
                <h3 class="text-2xl font-bold text-white text-center bg-gray-500 py-5">Question Numbers</h3>
            </div>
            <div class="px-5 py-1">
                <p v-if="form.type?.rules.length" v-for="rule in form.type.rules" class="flex justify-between py-2">
                    <span class="uppercase">
                        {{ rule.question_type.title }}
                    </span>
                    <span>
                        {{ rule.count }} questions
                    </span>
                </p>
                <p v-else class="flex flex-col items-center gap-1 text-red-500">
                    <span>No type selected</span>
                    <span>
                        OR
                    </span>
                    <span>
                        No rules for that type.
                    </span>
                </p>
            </div>
        </div>
    </div>

</template>
