<script setup>
import {Head, usePage} from "@inertiajs/vue3";
import html2PDF from 'jspdf-html2canvas';
import {onMounted, ref} from "vue";
import {MathJax} from "mathjax-vue3";
import _ from 'lodash';

let file = ref()

let download = null

onMounted(() => {
    download = () => {
        html2PDF(file.value, {
            jsPDF: {
                format: 'a4',
                orientation: 'portrait',
                unit: 'mm',
                putOnlyUsedFonts: true,
                hotfixes: ["px_scaling"],
                compress: true,
            },
            html2canvas: {
                imageTimeout: 15000,
                scale: 1,
                logging: true,
                useCORS: true,
                allowTaint: true,
                letterRendering: true,
                dpi: 192
            },
            imageQuality: 1,
            margin: {
                top: 2,
                right: 0,
                bottom: 2,
                left: 0,
            },
            pageBreak: { mode: 'css', before:'#nextpage1'},
            watermark({pdf, pageNumber, totalPageNumber}) {
                pdf.setTextColor("#ff0000");
                pdf.setDrawColor("#ff0000");
                pdf.setFontSize('48');
                pdf.setDisplayMode('fullwidth');
                pdf.setCreationDate(new Date())
                pdf.text("MR: " + usePage().props.test.user.first_name + ' ' + usePage().props.test.user.last_name, 50, 200, {
                    angle: 45,
                    renderingMode: "stroke",
                    opacity: 0.50
                });
            },
            imageType: 'image/jpeg',
            output: './pdf/generate.pdf',
            fontSize: 28,
        });
    }
})

// test if the question has an equation
function equation(question) {
    return question.match(/'[^']*'/ig)
}

// Printing the exam
function printExam() {
    window.print()
}

//checking gor long mcq answers
function containLongChoices(choices) {
    let long = false;
    for (let choice of choices) {
        if (choice.answer.length > 12) {
            return true
        }
    }
    return long
}

// shuffles the answers of the mcq questions.
const shuffledArray = (array) => {
    return _.shuffle(array)
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

defineProps({
    test: Object,
    question_types: Array
})
</script>

<template>
    <Head title="display"/>


    <div class="m-12 print:hidden space-x-5">
        <button
            v-if="test.subject.title !== '000'"
            @click="download"
            class="bg-blue-500 p-3 rounded text-white font-bold">
            Download
            <v-icon icon="mdi-download"/>
        </button>

        <button
            @click="printExam"
            class="bg-blue-500 p-3 rounded text-white font-bold">
            Print
            <v-icon icon="mdi-printer"/>
        </button>
    </div>


    <div
        ref="file"
        class="mx-auto w-[210mm] print:hidden min-h-screen print:m-0 print:p-0 p-2 pb-10 font-roboto bg-white font-semibold break-after-avoid"
    >
        <div class="border-4 border-double border-blue-500 p-3">
            <div class="text-xl font-bold border-b-2 border-blue-500 grid grid-cols-3 items-center">
                <div class="pb-3 font-medium text-lg basis-1/2">
                    <p class="space-x-2">
                        <span>{{ test.grade.title }} </span>
                        <span class="capitalize mx-1">{{ test.lessons[0].term }} term</span>
                    </p>
                    <p>
                        Subject: {{ test.subject.title }}
                    </p>
                    <p>
                        Lessons: {{ test.lessons.map((lesson) => lesson.code) }}
                    </p>
                    <p>
                        Time: {{ test.duration }} Minutes
                    </p>
                </div>
                <div class="text-gray-500 text-center font-sans">
                    <div>
                        <img src="/teacher.png" alt="" class="w-20 mx-auto">
                    </div>
                    <div>
                        <span>
                            {{ test.user.gender === 'male' ? 'MR' : 'MRS' }}:
                        </span>
                        <span>
                            {{ test.user.first_name + ' ' + test.user.last_name }}
                        </span>
                    </div>
                </div>
                <div class="justify-self-end flex flex-col gap-2">

                    <div>
                        {{ test.test_type.title }}
                    </div>

                    <table class="border">
                        <tr>
                            <td>
                                <div class="border-2 border-black p-5 w-24">

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="text-center border-2 border-black p-2">
                                    {{ test.degree }}
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="mt-5">

                <ul class="list-inside question break-before-all"
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
                        class="mt-4 mx-3 flex justify-start items-center gap-2 text-lg"
                    >
                        <div>
                            ({{ i + 1 }})
                        </div>

                        <!-- for mcq questions-->
                        <div :class="{'grid grid-cols-4': question.image}">
                            <div
                                v-if="question.type.title === 'mcq'"
                                class="w-full flex flex-col justify-center"
                                :class="{'col-span-3': question.image}"
                            >
                                <div class="text-lg"
                                     :class="{'flex': question.image}"
                                >
                                    <math-jax
                                        v-if=" test.subject.title === 'Math' && !!equation(question.title)"
                                        class="flex items-start font-sans"
                                        :latex="question.title.replaceAll(`\'`, ` `)"
                                    />
                                    <span class="flex" v-else>{{ question.title }}</span>

                                </div>

                                <div
                                    class="mt-2 text-lg gap-3 grid"
                                    :class="[containLongChoices(question.choices) ? 'grid-cols-2': 'grid-cols-4']"
                                >

                                    <p class="font-medium flex items-center space-x-1 w-fit"
                                       v-for="(choice, index) in shuffledArray(question.choices)"
                                       :key="choice.id">

                                        <span class="w-5 h-8 text-center rounded-2xl ">
                                            {{ String.fromCharCode(index + 97) }}.
                                        </span>

                                        <math-jax
                                            class="font-light w-fit"
                                            v-if=" test.subject.title === 'Math' && !!equation(choice.answer)"
                                            :latex="choice.answer.replaceAll(`\'`, ` `)"
                                        ></math-jax>

                                        <span v-else class="ms-3">
                                            {{ choice.answer }}
                                    </span>

                                    </p>
                                </div>
                            </div>
                            <div>
                                <img
                                    class="w-80"
                                    v-if="question.image"
                                    :src="'/questions/' + question.image" alt="">
                            </div>
                        </div>


                        <!-- for check questions-->
                        <div
                            v-if="question.type.title === 'check'"
                            class="w-full flex justify-between items-center">
                            <div class="basis-11/12">
                                <math-jax
                                    v-if=" test.subject.title === 'Math' && !!equation(question.title)"
                                    class="flex items-center font-sans"
                                    :latex="question.title.replaceAll(`\'`, ` `)"
                                ></math-jax>
                                <span v-else>{{ question.title }}</span>
                            </div>

                            <div class="basis-1/12 text-end space-x-6">
                                <span>(</span>
                                <span>)</span>
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


                        <!-- For scientific term answers -->
                        <div
                            v-if="question.type.title === 'scientific term'"
                            class="w-full flex justify-between items-center break-after-auto">
                            <div class="w-4/5">
                                <math-jax
                                    v-if=" test.subject.title === 'Math' && !!equation(question.title)"
                                    class="flex items-center font-sans"
                                    :latex="question.title.replaceAll(`\'`, ` `)"
                                ></math-jax>
                                <p v-else
                                    class="inline-block"
                                >
                                    {{ question.title }}
                                </p>
                            </div>
                            <div class="w-1/5 text-end space-x-6">
                                (..................)
                            </div>
                        </div>

                        <div
                            v-if="question.type.title === 'give reason' || question.type.title === 'what happens' || question.type.title === 'meaning'"
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

                        <!-- for generic questions-->
                        <div
                            v-if="question.type.title === 'generic'"
                            class="w-full">
                            <div>
                                <math-jax
                                    v-if=" test.subject.title === 'Math' && !!equation(question.title)"
                                    class="flex items-center font-sans"
                                    :latex="question.title.replaceAll(`\'`, ` `)"
                                ></math-jax>
                                <p v-else>{{ question.title }}</p>
                            </div>
                            <div>
                                ..................................................................................................................
                                ..................................................................................................................
                                ..................................................................................................................
                                ..................................................................................................................
                                ..................................................................................................................
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>


</template>
<style scoped>
.question, h4, ul, li {
    page-break-inside: avoid;
}
</style>
