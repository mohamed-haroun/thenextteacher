<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, router, useForm, usePage} from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import {ref} from "vue";


defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    testType: Object,
    question_types: Array
})

let form = useForm({
    question: '',
    count: "1",
    test_type: usePage().props.testType.id
})

const itemProps = (item) => {
    return {
        title: item.title
    }
}

const submit = (testType) => {
    form.post(route('rule.store', {testType:testType}))

    form.reset()
}

let dialog = ref(false)
</script>

<template>
    <Head title="Types/Show"/>

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
                        Show
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>
        </div>
    </Header>

    <div v-if="$page.props.flash.message">
        <v-snackbar
            v-model="snackbar"
            location="top"
            color="success"
            variant="tonal"
        >
            <template #default>
                <p class="font-bold ">
                    <v-icon icon="mdi-check" />
                    {{ $page.props.flash.message }}
                </p>
            </template>
        </v-snackbar>
    </div>

    <div class="m-5">
        <div class="flex flex-col sm:flex-row justify-between items-start gap-5">

            <div class="sm:basis-1/2 bg-white dark:bg-gray-700 shadow-lg p-3 rounded-lg">
                <div
                    class="text-cyan-700 dark:text-cyan-500 border-b border-gray-600 dark:border-gray-300 p-3 flex items-center space-x-3">
                    <v-icon icon="mdi-layers"/>
                    <h2 class="text-2xl font-black">Type {{ testType.id }}</h2>
                </div>
                <div class="text-center my-3">
                    <v-list lines="one" class="bg-white dark:bg-gray-700 dark:text-gray-100">
                        <v-list-item>
                            <div class="flex justify-start">
                                <p class="font-bold">Type:</p>
                                <p class="basis-1/2">{{ testType.title }}</p>
                            </div>
                        </v-list-item>
                        <v-list-item>
                            <div class="flex justify-start">
                                <p class="font-bold">Subject:</p>
                                <p class="basis-1/2">{{ testType.subject.title }}</p>
                            </div>
                        </v-list-item>
                        <v-list-item>
                            <div class="flex justify-start">
                                <p class="font-bold">Grade:</p>
                                <p class="basis-1/2">{{ testType.grade.title }}</p>
                            </div>
                        </v-list-item>
                    </v-list>
                </div>
            </div>

            <div class="basis-1/2 bg-white dark:bg-gray-700 shadow-lg p-3 rounded-lg">
                <div
                    class="text-cyan-700 dark:text-cyan-500 border-b border-gray-600 dark:border-gray-300 p-3 flex justify-between items-center space-x-3">
                    <h2 class="text-2xl font-black">
                        <v-icon size="small" icon="mdi-playlist-check"/>
                        Rules
                    </h2>
                    <div>
                        <v-dialog width="500">
                            <template v-slot:activator="{ props }">
                                <v-btn v-bind="props"
                                       class="bg-teal-600 text-white text-xs sm:text-sm md:text-md xl:text-base"
                                       prepend-icon="mdi-plus-thick" text="Rule"></v-btn>
                            </template>

                            <template v-slot:default="{ isActive }">
                                <v-card title="Add New Rule" class="dark:bg-gray-800 dark:text-blue-500">
                                    <v-card-text>
                                        <v-form @submit.prevent="submit(testType)">
                                            <div class="mt-3">
                                                <v-select
                                                    class="dark:text-gray-300 dark:bg-gray-800 font-bold rounded-lg"
                                                    :closable-chips="true"
                                                    :chips="true"
                                                    label="Question"
                                                    :items="question_types"
                                                    :item-props="itemProps"
                                                    v-model="form.question"
                                                    variant="outlined"
                                                ></v-select>
                                                <InputError class="mt-2" :message="form.errors.question"/>
                                            </div>

                                            <div class="mt-3">
                                                <InputLabel for="count" value="Count"/>

                                                <TextInput
                                                    id="count"
                                                    type="number"
                                                    min="1"
                                                    max="50"
                                                    class="mt-1 block w-full placeholder-slate-400 placeholder:text-sm"
                                                    v-model="form.count"
                                                    required
                                                    placeholder="Enter the chapter of the lesson in numbers"
                                                />

                                                <InputError class="mt-2" :message="form.errors.count"/>
                                            </div>

                                            <div class="mt-3">
                                                <button
                                                    @click="isActive.value = false"
                                                    type="submit"
                                                    class="px-3 py-2 text-white bg-blue-500 rounded w-full"
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
                <div class="my-3">
                    <div class="dark:text-gray-200 mt-3" v-for="(rule,index) in testType.rules" :key="rule.id">
                        <div class="text-blue-500">Rule: {{ index + 1 }}</div>
                        <div class="flex justify-between items-center mx-3">
                            <div class="flex justify-start basis-1/2">
                                <p class="basis-1/2 font-bold text-teal-700">
                                    Question Type:
                                </p>
                                <p class="basis-1/2">
                                    {{ rule.question_type.title }}
                                </p>
                            </div>
                            <div class="flex justify-start space-x-2">
                                <p class="basis-1/2 font-bold text-teal-700">
                                    Count:
                                </p>
                                <p class="basis-1/2">
                                    {{ rule.count }}
                                </p>
                            </div>

                            <Link :href="route('rule.destroy', {rule: rule})"
                                  class="bg-red-500 text-white font-semibold px-3 py-1 rounded"
                                  as="button"
                                  method="delete"
                            >
                                <v-icon size="small" icon="mdi-delete" /> Delete
                            </Link>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

