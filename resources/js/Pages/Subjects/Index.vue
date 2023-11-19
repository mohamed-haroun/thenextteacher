<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, useForm, Link} from "@inertiajs/vue3";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import {ref} from "vue";
import Header from "@/Components/Header.vue";

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    subjects: Array,
    grades: Array
})

const form = useForm({
    title: '',
    grades: 'Grade 1',
    lang: 'Arabic'
});


let itemProps = (item) => {
    return {
        title: item.title,
        subtitle: item.school,
    }
}

let dialog = ref(false)

const submit = () => {
    form.post(route('subjects.store'), {
        onFinish: () => form.reset('title', 'selected'),
    });

    form.reset()
};

let sortedSubjects = (subjects) => {
    return subjects.sort((a, b) => {
        return b.grades.length - a.grades.length;
    });
}

</script>

<template>

    <Head title="Subjects"/>

    <!--    {{ grades }}-->

    <Header class="sm:mx-3 text-sm">
        <div class="flex justify-between items-center">
            <v-breadcrumbs class="text-sm" active-color="error">
                <template v-slot:divider>
                    <v-icon icon="mdi-chevron-right"></v-icon>
                </template>

                <template #default>
                    <v-breadcrumbs-item disabled>
                        Subjects
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>

            <div class="flex justify-center gap-3">
                <p class="text-green-400" v-if="form.recentlySuccessful">Added successfully !!</p>
                <v-dialog width="500">
                    <template v-slot:activator="{ props }">
                        <v-btn v-bind="props" class="bg-blue-500 text-white dark:bg-blue-500/80 text-xs sm:text-sm md:text-md xl:text-base"
                               prepend-icon="mdi-plus-thick" text="Subject"></v-btn>
                    </template>

                    <template v-slot:default="{ isActive }">
                        <v-card title="Add New Subject" class="dark:bg-gray-700 dark:text-blue-500">
                            <v-card-text>
                                <v-form @submit.prevent="submit">
                                    <div>
                                        <InputLabel for="title" value="Title"/>

                                        <TextInput
                                            id="title"
                                            type="text"
                                            class="mt-1 block w-full placeholder-slate-400 placeholder:text-sm"
                                            v-model="form.title"
                                            required
                                            autofocussdsd
                                            placeholder="subject title"
                                            autocomplete="title"
                                        />

                                        <InputError class="mt-2" :message="form.errors.title"/>
                                    </div>

                                    <div class="mt-3">
                                        <v-select
                                            class="dark:text-white dark:bg-gray-700 font-bold rounded-lg"
                                            label="School Language"
                                            :items="['Arabic', 'English', 'Both']"
                                            v-model="form.lang"
                                            variant="outlined"
                                        ></v-select>
                                        <InputError class="mt-2" :message="form.errors.lang"/>
                                    </div>

                                    <div class="mt-3">
                                        <v-select
                                            class="dark:text-white dark:bg-gray-700 font-bold rounded-lg"
                                            :closable-chips="true"
                                            :chips="true"
                                            label="Grades"
                                            :items="grades"
                                            :item-props="itemProps"
                                            v-model="form.grades"
                                            :multiple="true"
                                            variant="outlined"
                                        ></v-select>
                                        <InputError class="mt-2" :message="form.errors.grades"/>
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
        </div>

    </Header>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 sm:px-5 gap-2 my-4">
        <div v-for="subject in sortedSubjects(subjects)" class="w-full min-h-max">
            <v-card class="dark:text-white dark:bg-gray-800 hover:shadow-lg">
                <v-card-title class="text-indigo-600 dark:text-indigo-300/80 mb-2 p-0">
                    <Link :href="route('subjects.show', {subject: subject})">
                        <h1 class="bg-slate-100 dark:bg-gray-700 p-3">
                            {{ subject.title }}
                            <v-icon size="small" icon="mdi-share"/>
                        </h1>
                    </Link>
                </v-card-title>

                <v-card-subtitle class="mb-1">
                    For {{ subject.school_lang }} schools
                </v-card-subtitle>

                <v-card-item class="text-gray-500 dark:text-white mx-2 border-t dark:border-t-gray-500 flex justify-between items-center">
                    <v-chip class="w-fit m-px border" v-for="grade in subject.grades" :key="grade.id">{{ grade.title }}</v-chip>
                </v-card-item>
            </v-card>
        </div>
    </div>

</template>
