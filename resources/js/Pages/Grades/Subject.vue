<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, router, useForm, usePage} from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";

defineProps({
    subject: Object,
    grade: Object,
    lessons: Array
})

defineOptions({
    layout: AuthenticatedLayout
})

const terms = (lessons) => {
    return lessons.map(lesson => {
        return lesson.term;
    }).filter((current, index, array) => {
        return index === array.indexOf(current);
    });
}

const chapters = (lessons, term) => {
    return lessons.map(lesson => {
        if (lesson.term === term) {
            return lesson.chapter
        }
    }).filter((current, index, array) => {
        if (current !== undefined) {
            return index === array.indexOf(current);
        }
    }).sort();
}


const form = useForm({
    code: '',
    title: '',
    chapter: '',
    term: '',
    subject_id: usePage().props.subject.id,
    grade_id: usePage().props.grade.id
})

let itemProps = (item) => {
    return {
        title: item,
    }
}

const submit = () => {
    form.post(route('lessons.store'))

    form.reset()
}


</script>

<template>

    <Head :title="subject.title + '/' + grade.title"/>

    <Header class="sm:mx-3">
        <div class="flex flex-col sm:flex-row justify-between items-center">

            <v-breadcrumbs class="text-sm">
                <template #default>
                    <v-breadcrumbs-item class="hidden sm:block">
                        <Link :href="route('grades.index')">Grades</Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider>
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>
                    <v-breadcrumbs-item>
                        <Link :href="route('grades.show', [grade])">{{ grade.title }}</Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider>
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>
                    <v-breadcrumbs-item disabled>
                        {{ subject.title }}
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>

            <v-dialog width="500">
                <template v-slot:activator="{ props }">
                    <v-btn v-bind="props"
                           class="text-white bg-blue-500 dark:bg-blue-500/80 text-xs sm:text-sm md:text-md xl:text-base"
                           prepend-icon="mdi-plus-thick" text="Lesson"></v-btn>
                </template>

                <template v-slot:default="{ isActive }">
                    <v-card :title="'Add New Lesson to ' + subject.title" class="dark:bg-gray-700 dark:text-blue-500">
                        <v-card-text>
                            <v-form @submit.prevent="submit">
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
                                        placeholder="Enter the order of the lesson in numbers"
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
                                        placeholder="Enter the chapter of the lesson in numbers"
                                    />

                                    <InputError class="mt-2" :message="form.errors.chapter"/>
                                </div>

                                <div class="mt-3">
                                    <v-select
                                        class="dark:bg-gray-700 dark:text-white font-bold rounded-lg"
                                        :closable-chips="true"
                                        :chips="true"
                                        label="Term"
                                        :items="['first', 'second']"
                                        :item-props="itemProps"
                                        v-model="form.term"
                                        variant="outlined"
                                    ></v-select>
                                    <InputError class="mt-2" :message="form.errors.term"/>
                                </div>

                                <div class="mt-3">
                                    <button
                                        @click="isActive.value = false"
                                        type="submit"
                                        class="px-3 py-2 text-white bg-blue-500 dark:bg-blue-500/80 rounded w-full"
                                    >Submit
                                    </button>
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

    <div>
        <div v-if="!!lessons.length" >
            <div class="sm:mx-5 flex flex-col md:flex-row justify-between gap-8">
                <div class="basis-1 md:basis-1/2 bg-white dark:bg-slate-800 dark:text-slate-300 shadow-lg rounded-lg"
                     v-for="term in terms(lessons)" :key="term">
                    <h1 class="capitalize text-2xl font-black bg-gray-200 dark:bg-gray-600 dark:text-white text-center w-full p-5">
                        {{ term }} Term</h1>
                    <div class="px-5 py-2">

                        <div class="my-4"
                             v-for="chapter in chapters(lessons, term)"
                             :key="chapter"
                        >
                            <h3 class="text-xl font-bold mb-2">Chapter {{ chapter }}</h3>
                            <div v-for="item in lessons" :key="item.id">
                                <Link v-if="item.chapter === chapter && item.term === term" :href="route('lessons.show', {lesson: item})"
                                      class="py-2 text-blue-500 dark:text-blue-400 hover:underline underline-offset-4">
                                    <span class="text-black dark:text-gray-100 font-bold text-base">Lesson ( {{ item.code }} ) :</span>
                                    {{ item['title'] }}
                                    <v-icon icon="mdi-link" class="text-blue-500"></v-icon>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-else class="flex justify-center items-center h-24 md:h-96">
            <p class="text-red-500">No Lessons in this subject yet</p>
        </div>
    </div>
</template>
