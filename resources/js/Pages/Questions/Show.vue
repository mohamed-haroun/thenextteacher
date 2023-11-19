<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link} from "@inertiajs/vue3";
import {ref} from "vue";
import Header from "@/Components/Header.vue";
import {MathJax} from "mathjax-vue3";

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    question: Object,
})

function containsEquation(question) {
    return !!question.match(/'[^']*'/ig)
}


let dialog = ref(false)
</script>

<template>
    <Head :title="'Question ' + question.id"/>


    <Header class="mx-3">
        <div class="flex justify-between items-center">
            <v-breadcrumbs class="text-sm">
                <template #default>
                    <v-breadcrumbs-item>
                        <Link :href="route('questions.index')">Questions</Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider>
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>
                    <v-breadcrumbs-item disabled>
                        {{ question.id }}
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>

            <div class="flex justify-between items-center gap-5">
                <Link :href="route('questions.edit', {question: question})">
                    <v-btn color="blue" prepend-icon="mdi-pencil">update</v-btn>
                </Link>
                <v-row justify="center">
                    <v-dialog
                        v-model="dialog"
                        persistent
                        width="500"
                    >
                        <template v-slot:activator="{ props }">
                            <v-btn
                                color="red"
                                v-bind="props"
                                prepend-icon="mdi-delete"
                            >
                                Delete
                            </v-btn>
                        </template>
                        <v-card>
                            <v-card-title class="text-h6 text-red-500">
                                Delete {{ question.id }} question
                            </v-card-title>
                            <v-card-text class="text-sm">
                                Are you sure to delete {{ question.title }} question?
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    color="error"
                                    variant="text"
                                    @click="dialog = false"
                                >
                                    Cancel
                                </v-btn>
                                <Link as="button" :href="route('questions.destroy', {question: question})"
                                      method="delete">
                                    <v-btn
                                        color="green-darken-1"
                                        variant="text"
                                        @click="dialog = false"
                                    >
                                        Agree
                                    </v-btn>
                                </Link>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-row>
            </div>
        </div>

    </Header>

    <div class="md:mx-5 my-2 md:p-3 bg-white dark:bg-gray-800 shadow-lg rounded-lg">

        <div class="flex flex-col md:flex-row sm:justify-between sm:space-x-6">
            <div class="basis-1 md:basis-1/2">
                <div class="px-4 sm:px-0">
                    <h3 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Question Details</h3>
                    <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500 dark:text-slate-300">Question details and
                        Answers.</p>
                </div>
                <div class="mt-6 border-t border-gray-100">
                    <dl class="divide-y divide-gray-300 dark:divide-gray-500">
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 md:grid-cols-4  sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Title :</dt>
                            <dd class="mt-1 text-sm text-gray-700 col-span-2 dark:text-gray-100 md:col-span-3 sm:mt-0">
                                <math-jax
                                    v-if="question.lesson.subject.title === 'Math' && containsEquation(question.title)"
                                    class="inline-flex justify-start items-start font-sans font-bold"
                                    :latex="question.title.replaceAll(`\'`, ` `)"
                                />
                                <p class="inline-block" v-else-if="question.type.title === 'correct'"
                                   v-for="item in question.title.split(' ')">
                                    <span class="ms-1"
                                          :class="{'underline underline-offset-4 text-red-600 dark:text-red-400 break-after-all' : item === question.correct.wrong}">
                                        {{ item.replace("_", ' ') }}
                                    </span>
                                </p>
                                <span class="flex" v-else>
                                    {{ question.title }}
                                </span>
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 md:grid-cols-4 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Type :</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-100 sm:col-span-2 md:col-span-3 sm:mt-0">
                                {{
                                    question.type.title
                                }}
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 md:grid-cols-4  sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Rating :</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-100 sm:col-span-2 md:col-span-3 sm:mt-0">
                                <v-rating
                                    readonly
                                    :length="5"
                                    :size="32"
                                    :model-value="question.rating"
                                    active-color="primary"
                                />
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 md:grid-cols-4  sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Lesson :</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-100 sm:col-span-2 md:col-span-3 sm:mt-0 capitalize">
                                {{
                                    question.lesson.title
                                }}
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 md:grid-cols-4  sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Subject :</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-100 sm:col-span-2 md:col-span-3 sm:mt-0">
                                {{
                                    question.lesson.subject.title
                                }}
                            </dd>
                        </div>
                        <div class="px-4 py-6 sm:grid sm:grid-cols-3 md:grid-cols-4  sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Grade :</dt>
                            <dd class="mt-1 text-sm leading-6 text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0 capitalize">
                                {{ question.lesson.grade.title }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
            <div class="sm:basis-1/2 p-5 mt-8 text-gray-900 dark:text-gray-100">
                <div>The answer of the question</div>

                <div v-if="question.type.title === 'mcq'" class="mt-5 flex gap-3 overflow-hidden">
                    <p v-for="choice in question.choices" :key="choice.id"
                       class="px-5 py-3 block"
                       :class="{'bg-blue-100 dark:bg-blue-500': !choice.check, 'bg-teal-100 dark:bg-teal-500': choice.check}"
                    >
                        <math-jax v-if="question.lesson.subject.title === 'Math' && containsEquation(choice.answer)"
                                  class="flex items-start space-x-2 text-2xl"
                                  :latex="choice.answer.replaceAll(`\'`, ` `)"></math-jax>

                        <span v-else>
                        {{ choice.answer }}
                        </span>
                    </p>
                </div>

                <div v-else-if="question.type.title === 'complete'" class="mt-5 flex gap-3 overflow-hidden">
                    <p v-for="complete in question.completions" :key="complete.id"
                       class="px-5 py-3 block bg-blue-100 dark:bg-blue-500"
                    >
                        <math-jax v-if="question.lesson.subject.title === 'Math' && containsEquation(question.title)"
                                  class="flex space-x-2 text-2xl"
                                  :latex="complete.answer.replaceAll(`\'`, ` `)"></math-jax>

                        <span v-else>
                        {{ complete.answer }}
                        </span>
                    </p>
                </div>

                <div v-else-if="question.type.title === 'correct'" class="mt-5 flex gap-3 overflow-hidden">
                    <p class="px-5 py-3 block bg-teal-100 dark:bg-teal-500/80">
                        {{ question.correct.right }}
                    </p>

                    <p class="px-5 py-3 block bg-red-100 dark:bg-red-500/80">
                        {{ question.correct.wrong.replace('_', ' ') }}
                    </p>
                </div>

                <div v-else-if="question.type.title === 'check'" class="mt-5 flex gap-3 overflow-hidden">
                    <p class="px-5 py-3 block bg-blue-100 dark:bg-blue-500">
                        <v-icon color="green" v-if="question.checks.answer === 1" icon="mdi-check"/>
                        <v-icon color="error" v-else size="large" icon="mdi-close"/>
                    </p>
                </div>

                <div v-else class="mt-5 bg-blue-100 dark:bg-blue-500 p-3 overflow-hidden">
                    {{ question.answer.title }}
                </div>
            </div>
        </div>
    </div>


</template>
