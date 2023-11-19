<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Header from "@/Components/Header.vue";
import {Link, router, usePage} from "@inertiajs/vue3";
import {Head} from "@inertiajs/vue3";
import {ref} from "vue";
import {MathJax} from "mathjax-vue3";

defineOptions({
    layout: AuthenticatedLayout
})

let props = defineProps({
    test: Object
})

let user = ref(usePage().props.auth.user)

let studentAnswers = props.test.student_answers

// test if the question has an equation
function equation(question) {
    return question.match(/'[^']*'/ig)
}

//checking for long mcq answers
function containLongChoices(choices) {
    let long = false;
    for (let choice of choices) {
        if (choice.answer.length > 12) {
            return true
        }
    }
    return long
}

const questionTypes = (questions) => {
    return new Set(questions.map(question => {
        return question.type.id
    }))
}

const questionsOfType = (questions, type) => {
    return questions.filter((question) => {
        if (question.question_type_id === type) {
            return question
        }
    });
}

const questionHeader = (type_id) => {
    let questionTypes = usePage().props.question_types

    for (let questionType of questionTypes) {
        if (questionType.id === type_id) {
            return questionType.header
        }
    }
}

let getUserChoices = () => {
    if (studentAnswers?.length > 0) {
        return studentAnswers.map((answer) => {
            return {key: answer.question_id, value: answer.answer}
        })
    } else {
        return null
    }
}

let userChoices = ref(new Map(getUserChoices()?.map(obj => [obj.key, obj.value])))

let chosen = (item) => {
    props.test.questions.filter(q => {
        if (q.id === item.question) {
            return q
        }
    })
    userChoices.value.set(item.question, item.answer)
}

let isChosen = (question, answer) => {
    if (userChoices.value.has(question)) {
        return userChoices.value.get(question) === answer
    }
}

let isAnswered = (question) => {
    return userChoices.value.has(question) || studentAnswers?.length > 0
}

let correctQuestion = () => {
    if (props.test.questions.length !== userChoices.value.size) {
        alert('Complete the questions first')
    } else {
        router.post('/users/students/exam/' + props.test.id + '/correct', {
            testQuestions: Array.from(userChoices.value, ([question, answer]) => ({question, answer}))
        })
    }
}

</script>

<template>

    <Head title="Exam"/>

    <Header class="sm:mx-3">
        <div class="flex justify-between items-center">
            <v-breadcrumbs class="text-sm">
                <template #default>
                    <v-breadcrumbs-item>
                        <Link :href="route('profile')">
                            Profile
                        </Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider>
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>

                    <v-breadcrumbs-item disabled>
                        <Link :href="route('student.subject', {subject: test.subject.id})">
                            {{ test.subject.title }}
                        </Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider>
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>

                    <v-breadcrumbs-item disabled>
                        Exam
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>
        </div>
    </Header>

    <div class="mx-12 bg-white text-gray-800 dark:bg-gray-800 dark:text-white p-3 rounded-lg shadow-lg mb-12">

        <div class="my-5">

            <ul class="list-inside question break-after-avoid-page"
                :class="index > 0 ? 'mt-12':'mt-2'"
                v-for="(rule, index) in questionTypes(test.questions)"
            >
                <li>
                    <h3 class="text-xl font-black underline underline-offset-8 mb-2"
                        v-if="questionsOfType(test.questions, rule).length !== 0"
                    >
                        Question {{ index + 1 }}: {{ questionHeader(rule) }}
                    </h3>
                </li>
                <li
                    v-for="(question, i) in questionsOfType(test.questions, rule)"
                    :key="question.id"
                    class="mt-4 mx-3 flex justify-start gap-2 text-lg hover:cursor-pointer"
                    :class="{'text-gray-700 dark:text-gray-400': isAnswered(question.id)}"
                >
                    <div>
                        ({{ i + 1 }})
                    </div>

                    <!-- for mcq questions-->
                    <div
                        v-if="question.type.title === 'mcq'"
                        class=" w-full flex flex-col justify-center "
                    >
                        <div class="text-lg">
                            <math-jax
                                v-if=" test.subject.title === 'Math' && !!equation(question.title)"
                                class="flex items-end font-sans text-xl font-bold"
                                :latex="question.title.replaceAll(`\'`, ` `)"
                            />
                            <p v-else>{{ question.title }}</p>
                        </div>

                        <div
                            class="mt-2 text-lg gap-3 grid"
                            :class="[containLongChoices(question.choices) ? 'grid-cols-2': 'grid-cols-4']"
                        >

                            <p class="font-medium flex items-center space-x-1 w-fit"
                               v-for="(choice, index) in question.choices"
                               :key="choice.id"
                               @click="chosen({question: question.id, answer: choice.answer})"
                               :class="{
                                   'hover:text-blue-400 focus:bg-red-300': studentAnswers?.length === 0,
                                   'text-green-500 font-bold' : choice.check && studentAnswers?.length > 0,
                                   'text-blue-500': isChosen(question.id ,choice.answer),
                               }"
                            >
                                        <span
                                            class="w-5 h-8 text-center rounded-2xl ">
                                            {{ String.fromCharCode(index + 97) }}.
                                        </span>

                                <math-jax
                                    class="font-light w-fit"
                                    v-if=" test.subject.title === 'Math' && !!equation(choice.answer)"
                                    :latex="choice.answer.replaceAll(`\'`, ` `)"
                                ></math-jax>

                                <span v-else class="ms-3"
                                :class="{'underline underline-offset-8 font-bold' : choice.check && studentAnswers?.length > 0}"

                                >
                                    {{ choice.answer }}
                                </span>

                            </p>
                        </div>
                    </div>

                    <!-- for check questions-->
                    <div
                        v-if="question.type.title === 'check'"
                        class="w-full flex justify-between items-center">
                        <div class="basis-4/5">
                            <math-jax
                                v-if=" test.subject.title === 'Math' && !!equation(question.title)"
                                class="flex items-center font-sans"
                                :latex="question.title.replaceAll(`\'`, ` `)"
                            ></math-jax>
                            <span v-else>{{ question.title }}</span>
                        </div>

                        <div class="basis-1/5 text-end space-x-6">
                            <label :for="'true'+question.id" class="items-center">
                                <input
                                    type="radio"
                                    :name="'check'+question.id"
                                    :id="'true'+question.id"
                                    class="border border-gray-900 ring mx-1"
                                    @click="chosen({question: question.id, answer: true})"
                                >
                                True
                            </label>
                            <label :for="'false'+question.id">
                                <input
                                    type="radio"
                                    :name="'check'+question.id"
                                    :id="'false'+question.id"
                                    class="border border-gray-900 ring mx-1"
                                    @click="chosen({question: question.id, answer: false})"
                                >
                                False
                            </label>
                        </div>
                    </div>

                    <!-- For correct answers -->
                    <div
                        v-if="question.type.title === 'correct'"
                        class="w-full flex justify-between items-center break-after-auto">
                        <div class="w-4/5">
                            <math-jax
                                v-if=" test.subject.title === 'Math' && !!equation(question.title)"
                                class="flex items-center font-sans"
                                :latex="question.title.replaceAll(`\'`, ` `)"
                            ></math-jax>
                            <p class="inline-block" v-else
                               v-for="(item, index) in question.title.split(' ')">
                                    <span class="ms-1"
                                          :class="{'underline underline-offset-4 text-red-600 dark:text-red-400 break-after-all' : item === question.correct.wrong}">
                                        {{ item.replace("_", ' ') }}
                                    </span>
                            </p>
                        </div>
                        <div class="w-1/5 text-end space-x-6">
                            (..................)
                        </div>
                    </div>

                    <div
                        v-if="question.type.title === 'give reason' || question.type.title === 'what happens'"
                        class="w-full">
                        <div class="w-4/5">
                            <math-jax
                                v-if=" test.subject.title === 'Math' && !!equation(question.title)"
                                class="flex items-center font-sans"
                                :latex="question.title.replaceAll(`\'`, ` `)"
                            ></math-jax>
                            <p class="inline-block" v-else>
                                {{ question.title }}
                            </p>
                        </div>
                        <div>
                            ..................................................................................................................
                            ..................................................................................................................
                        </div>
                    </div>

                    <!-- for complete questions-->
                    <div
                        v-if="question.type.title === 'complete'"
                        class="w-full">
                        <div>
                            <math-jax
                                v-if=" test.subject.title === 'Math' && !!equation(question.title)"
                                class="flex items-center font-sans"
                                :latex="question.title.replaceAll(`\'`, ` `)"
                            ></math-jax>
                            <p v-else>{{ question.title }}</p>
                        </div>
                    </div>

                    <!-- for scientific questions-->
                    <div
                        v-if="question.type.title === 'scientific term'"
                        class="w-full">
                        <div>
                            <math-jax
                                v-if=" test.subject.title === 'Math' && !!equation(question.title)"
                                class="flex items-center font-sans"
                                :latex="question.title.replaceAll(`\'`, ` `)"
                            ></math-jax>
                            <p v-else>{{ question.title }}</p>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <button
            :disabled="studentAnswers?.length !== 0"
            @click="correctQuestion"
            class="px-3 py-2 rounded bg-indigo-600 text-gray-200 font-bold disabled:bg-gray-500 disabled:cursor-not-allowed"
        >
            Submit
        </button>
    </div>

</template>
