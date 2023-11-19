<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Header from "@/Components/Header.vue";
import {Head, Link, useForm, usePage} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    grade: Object
})


let itemProps =  (item) => {
    return {
        title: item.title,
        subtitle: item.school,
    }
}

let schools = [
    {id: 1, title: "primary" },
    {id: 2, title: "preparatory"},
    {id: 3, title: "secondary"},
]

let formGrade = usePage().props.grade

const form = useForm({
    title: formGrade.title,
    school: formGrade.school
});

const submit = (grade) => {
    form.patch(route('grades.update', {grade: grade}));
};

</script>

<template>
    <Head :title="grade.title"/>

    <Header class="mx-3">
        <v-breadcrumbs class="text-sm">
            <template #default>
                <v-breadcrumbs-item>
                    <Link :href="route('grades.index')">Grades</Link>
                </v-breadcrumbs-item>
                <v-breadcrumbs-divider>
                    <v-icon icon="mdi-chevron-right"></v-icon>
                </v-breadcrumbs-divider>
                <v-breadcrumbs-item>
                    <Link :href="route('grades.show', {grade: grade})">{{ grade.title }}</Link>
                </v-breadcrumbs-item>
                <v-breadcrumbs-divider>
                    <v-icon icon="mdi-chevron-right"></v-icon>
                </v-breadcrumbs-divider>
                <v-breadcrumbs-item disabled>Update</v-breadcrumbs-item>
            </template>
        </v-breadcrumbs>
    </Header>


    <div class="w-1/2 mx-auto bg-white my-12 p-5 rounded">
        <v-form @submit.prevent="submit(grade.id)">
            <div>
                <v-text-field
                    clearable
                    persistent-clear
                    label="title"
                    type="text"
                    class="mt-1 block w-full placeholder-slate-400 placeholder:text-sm"
                    v-model="form.title"
                    required
                    autocomplete="title"
                ></v-text-field>

                <InputError class="mt-2" :message="form.errors.title"/>
            </div>

            <div class="mt-3">
                <v-select
                    class="bg-white text-black font-bold rounded-lg"
                    label="School"
                    :items="schools"
                    :item-props="itemProps"
                    v-model="form.school"
                ></v-select>
                <InputError class="mt-2" :message="form.errors.school"/>
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
