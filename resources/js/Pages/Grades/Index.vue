<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Link, Head, useForm} from '@inertiajs/vue3'
import {usePage} from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    grades: Array
})

let schools = [
    {id: 1, school: "Primary School", title: "Primary"},
    {id: 2, school: "Preparatory School", title: "Preparatory"},
    {id: 3, school: "Secondary School", title: "Secondary"},
]

let itemProps = (item) => {
    return {
        title: item.title,
        subtitle: item.school,
    }
}

function schoolFilter(school) {
    return usePage().props.grades.filter(item => item.school === school.title.toLowerCase())
}

const form = useForm({
    title: '',
    school: ''
})

const submit = () => {
    form.post(route('grades.store'), {
        onFinish: () => form.reset(),
    });
}

</script>
<template>
    <Head title="Grades"/>

    <Header class="sm:mx-3">
        <div class="flex justify-between items-center">
            <v-breadcrumbs class="text-sm h-fit" :items="['Grades']">
                <template v-slot:divider>
                    <v-icon icon="mdi-chevron-right"></v-icon>
                </template>
            </v-breadcrumbs>

            <div>
                <v-dialog width="500">
                    <template v-slot:activator="{ props }">
                        <v-btn v-bind="props" class="bg-blue-500 text-white text-xs sm:text-sm md:text-md xl:text-base"
                               prepend-icon="mdi-plus-thick" text="Grade"></v-btn>
                    </template>

                    <template v-slot:default="{ isActive }">
                        <v-card title="Add New Grade" class="dark:bg-gray-700 dark:text-blue-500">
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
                                            placeholder="Grade title"
                                            autocomplete="title"
                                        />

                                        <InputError class="mt-2" :message="form.errors.title"/>
                                    </div>

                                    <div class="mt-3">
                                        <v-select
                                            class="dark:bg-gray-700 dark:text-white font-bold rounded-lg"
                                            :closable-chips="true"
                                            :chips="true"
                                            label="School"
                                            :items="schools"
                                            :item-props="itemProps"
                                            v-model="form.school"
                                            variant="outlined"
                                        ></v-select>
                                        <InputError class="mt-2" :message="form.errors.school"/>
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
                                    class="bg-red-500 text-white font-bold"
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

    <div class="flex flex-col sm:flex-row justify-between sm:mx-6 gap-3 sm:gap-6">
        <div class="pb-3 shadow-lg dark:bg-gray-800 bg-white basis-1/3 rounded-lg"
             v-for="school in schools"
             :key="school.id"
        >
            <h1 class="mx-auto mb-5 px-5 py-5 rounded bg-sky-400/60 dark:bg-sky-700 dark:text-gray-200 w-full text-center text-base sm:text-lg font-bold">
                {{ school.title }} School
            </h1>

            <div class="text-center mx-2">
                <div class="w-full" v-for="grade in schoolFilter(school)" :key="grade.id">
                    <Link :href="route('grades.show', {grade: grade})">
                        <h2
                            class="my-2 py-3 md:py-5 font-bold rounded-lg text-gray-800 dark:text-gray-200 shadow=lg"
                            :class="[
                                        {'bg-fuchsia-500/20 dark:bg-fuchsia-900/80 hover:bg-fuchsia-400/90 dark:hover:bg-fuchsia-800 transition-all': school.title === 'Primary'},
                                        {'bg-teal-700/20 dark:bg-teal-900/80 hover:bg-teal-400/90 dark:hover:bg-teal-800 transition-all': school.title === 'Preparatory'},
                                        {'bg-blue-700/20 dark:bg-blue-900/80 hover:bg-blue-400/90 dark:hover:bg-blue-800 transition-all': school.title === 'Secondary'}
                                    ]"
                        >

                            {{ grade.title }}
                            <v-icon icon="mdi-share"></v-icon>
                        </h2>
                    </Link>

                </div>
            </div>
        </div>
    </div>
</template>
