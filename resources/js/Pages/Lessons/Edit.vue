<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, useForm, usePage} from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    lesson: Object,
    subjects: Array,
    grades: Array
})


const form = useForm({
    code: usePage().props.lesson.code.toString(),
    title: usePage().props.lesson.title,
    chapter: usePage().props.lesson.chapter.toString(),
    term: usePage().props.lesson.term,
    subject: usePage().props.lesson.subject.title,
    grade: usePage().props.lesson.grade.title
})

let itemProps = (item) => {
    return {
        title: item,
    }
}

let defProps = (item) => {
    return {
        title: item.title,
    }
}

const submit = (lesson) => {
    form.patch(route('lessons.update', {lesson: lesson}))
}
</script>

<template>
    <Head title="Edit"/>

    <Header class="mx-3">
        <v-breadcrumbs class="text-sm">
            <template #default>
                <v-breadcrumbs-item>
                    <Link :href="route('lessons.index')">Lessons</Link>
                </v-breadcrumbs-item>
                <v-breadcrumbs-divider>
                    <v-icon icon="mdi-chevron-right"></v-icon>
                </v-breadcrumbs-divider>
                <v-breadcrumbs-item>
                    <Link :href="route('lessons.show', [lesson])">{{ lesson.title }}</Link>
                </v-breadcrumbs-item>
                <v-breadcrumbs-divider>
                    <v-icon icon="mdi-chevron-right"></v-icon>
                </v-breadcrumbs-divider>
                <v-breadcrumbs-item disabled>
                    Update
                </v-breadcrumbs-item>
            </template>
        </v-breadcrumbs>
    </Header>

    <div class="w-full md:w-2/3 lg:w-1/2 mx-auto my-5 md:my-12 p-5 bg-white dark:bg-gray-800 shadow-lg rounded-lg">
        <v-form @submit.prevent="submit(lesson.id)">
            <div>
                <InputLabel for="code" value="Code"/>

                <TextInput
                    id="code"
                    type="number"
                    min="1"
                    max="50"
                    class="mt-1 block w-full placeholder-slate-400 placeholder:text-sm"
                    v-model="form.code"
                    required
                    autofocus
                />

                <InputError class="mt-2" :message="form.errors.code"/>
            </div>

            <div class="mt-3">
                <InputLabel for="title" value="Title"/>

                <TextInput
                    id="title"
                    type="text"
                    class="mt-1 block w-full placeholder-slate-400 placeholder:text-sm"
                    v-model="form.title"
                    required
                    placeholder="eg. title of lesson"
                    autocomplete="title"
                />

                <InputError class="mt-2" :message="form.errors.title"/>
            </div>

            <div class="mt-3">
                <InputLabel for="chapter" value="Chapter"/>

                <TextInput
                    id="chapter"
                    type="number"
                    min="1"
                    max="50"
                    class="mt-1 block w-full placeholder-slate-400 placeholder:text-sm"
                    v-model="form.chapter"
                    required
                />

                <InputError class="mt-2" :message="form.errors.chapter"/>
            </div>


            <div class="mt-3">
                <v-select
                    class="dark:text-white dark:bg-gray-800 font-bold rounded-lg"
                    :closable-chips="true"
                    :chips="true"
                    label="Subject"
                    :items="subjects"
                    :item-props="defProps"
                    v-model="form.subject"
                    variant="outlined"
                ></v-select>
                <InputError class="mt-2" :message="form.errors.subject"/>
            </div>

            <div class="mt-3">
                <v-select
                    class="dark:text-white dark:bg-gray-800 font-bold rounded-lg"
                    :closable-chips="true"
                    :chips="true"
                    label="Grade"
                    :items="grades"
                    :item-props="defProps"
                    v-model="form.grade"
                    variant="outlined"
                ></v-select>
                <InputError class="mt-2" :message="form.errors.grade"/>
            </div>


            <div class="mt-3">
                <v-select
                    class="dark:text-white dark:bg-gray-800 font-bold rounded-lg"
                    :closable-chips="true"
                    :chips="true"
                    label="Term"
                    :items="['First', 'Second']"
                    :item-props="itemProps"
                    v-model="form.term"
                    variant="outlined"
                ></v-select>
                <InputError class="mt-2" :message="form.errors.term"/>
            </div>

            <div class="mt-3">
                <button
                    type="submit"
                    class="px-3 py-2 text-white bg-blue-500 rounded w-full"
                >Update
                </button>
            </div>
        </v-form>
    </div>
</template>
