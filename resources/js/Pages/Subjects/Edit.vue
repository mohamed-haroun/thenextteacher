<script setup>
import {Head, Link, useForm, usePage} from "@inertiajs/vue3";
import {defineOptions} from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Header from "@/Components/Header.vue";
import TextInput from "@/Components/TextInput.vue";

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    subject: Object,
    grades: Array
})

let itemProps =  (item) => {
    return {
        title: item.title,
        subtitle: item.school,
    }
}

const form = useForm({
    title: usePage().props.subject.title,
    grades: usePage().props.subject.grades,
    lang: usePage().props.subject.school_lang
});

const update = (subject) => {
    form.patch(route('subjects.update', {subject: subject}));
};

</script>

<template>
    <Head title="Subject/Edit"/>

    <Header class="mx-3">
        <div class="text-sm">
            <v-breadcrumbs class="text-sm" active-color="error">
                <template v-slot:divider>
                    <v-icon icon="mdi-chevron-right"></v-icon>
                </template>

                <template #default>
                    <v-breadcrumbs-item>
                        <Link :href="route('subjects.index')">Subjects</Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider>
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>
                    <v-breadcrumbs-item>
                        <Link :href="route('subjects.show', [subject])">{{ subject.title }}</Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider>
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>
                    <v-breadcrumbs-item disabled>
                        Update
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>
        </div>
    </Header>


    <div class="w-full md:w-2/3 lg:w-1/2 sm:mx-auto bg-white dark:bg-gray-800 my-5 md:my-12 p-5 rounded shadow-lg">
        <v-form @submit.prevent="update(subject.id)">
            <div>
                <InputLabel for="title" value="Title"/>
                <TextInput
                    name="title"
                    id="title"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.title"
                    required
                ></TextInput>

                <InputError class="mt-2" :message="form.errors.title"/>
            </div>

            <div class="mt-3">
                <v-select
                    class="dark:text-white dark:bg-gray-800 font-bold rounded-lg"
                    label="School Language"
                    :items="['Arabic', 'English', 'Both']"
                    v-model="form.lang"
                    variant="outlined"
                ></v-select>
                <InputError class="mt-2" :message="form.errors.lang"/>
            </div>

            <div class="mt-3">
                <v-select
                    class="dark:text-white dark:bg-gray-800 font-bold rounded-lg"
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
                    type="submit"
                    class="px-3 py-2 text-white bg-blue-500 dark:bg-blue-500 rounded w-full"
                >Update</button>
            </div>
        </v-form>
    </div>
</template>
