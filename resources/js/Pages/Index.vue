<script setup>
import {Head, router} from '@inertiajs/vue3';
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {Link} from "@inertiajs/vue3";

defineOptions({
    layout: GuestLayout
})

</script>

<template>
    <Head title="Home"/>

    <div class="my-6 lg:py-20 px-12 flex flex-col-reverse sm:flex-row justify-between items-center">
        <div class="basis-1/2">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-black sm:w-4/5 leading-tight py-6 text-indigo-700 dark:text-indigo-300">There's a New
                Way to Learn More...</h1>
            <p class="text-gray-700 dark:text-gray-200 sm:font-bold sm:w-4/5">
                By make it easy for teachers to create exams, quizzes, revisions
                easily, and for students to practice what they learnt with ease and efficient.</p>
            <div class="my-8 flex flex-col sm:flex-row sm:space-x-6 gap-4 mx-auto">
                <Link
                    :href="route('register')"
                    class="bg-indigo-500 hover:bg-indigo-600 dark:bg-gray-800 hover:dark:bg-indigo-500 text-white text-sm font-semibold px-4 py-3">
                    Join Us Now
                </Link>

                <Link
                    :href="route('about')"
                    class="bg-rose-500 hover:bg-rose-600 dark:bg-gray-500 hover:dark:bg-rose-500 transition-all text-white text-sm font-semibold px-4 py-3">
                    Learn more about us
                </Link>
            </div>
        </div>
        <div class="basis-1/2">
            <img class="mix-blend-darken dark:mix-blend-luminosity" src="/images/hero.png" alt="Hero Image">
        </div>
    </div>

    <div class="my-8 py-12 bg-white dark:bg-gray-800">
        <div class="header p-7 sm:p-10">
            <h2
                class="font-roboto sm:w-fit mx-auto text-center text-4xl sm:text-6xl font-black text-gray-700 dark:text-gray-500"
            >What is <span class="text-rose-600 dark:text-rose-700">Teacher</span></h2>

            <p
                class="sm:w-1/2 sm:text-center mx-auto mt-8 mb-8 sm:mb-16 sm:text-lg text-gray-700 dark:text-gray-400"
            >
                Teacher is a platform that allows educators to create and manage assignments, quizzes and exams. and
                also allow students to take online exams and practice for real ones.
            </p>
        </div>

        <div class="mt-4 flex flex-col sm:flex-row justify-evenly items-center gap-5">
            <div class="h-96 w-64 basis-5/6 sm:basis-1/3 bg-no-repeat rounded-lg flex flex-col items-center justify-center relative">
                <img src="/images/teachers.jpg" class="mix-blend-darken dark:mix-blend-luminosity" alt="Teachers">
                <div class="absolute">
                    <span class="block w-fit bg-white/80 p-3 mt-8 text-indigo-600 rounded-lg text-lg sm:text-3xl font-black">For instructors</span>
                    <Link
                        :href="route('profile.edit')"
                        class="block w-fit bg-indigo-600 mt-3 px-3 py-2 mx-auto text-white font-bold rounded-full">
                        Create Exam
                    </Link>
                </div>
            </div>
            <div class="h-96 w-64 basis-5/6 sm:basis-1/3 bg-no-repeat rounded-lg flex flex-col items-center justify-center relative">
                <img src="/images/21852399_students_09.svg" class="mix-blend-darken dark:mix-blend-luminosity" alt="Teachers">
                <div class="absolute">
                    <span class="block w-fit bg-white/80 p-3 mt-8 text-indigo-600 rounded-lg text-lg sm:text-3xl font-black">For Students</span>
                    <Link
                        :href="route('profile.edit')"
                        class="block w-fit bg-indigo-600 mt-3 px-3 py-2 mx-auto text-white font-bold rounded-full">
                        Attend Exam
                    </Link>
                </div>
            </div>
        </div>

        <div class="my-12 sm:my-24 mx-8 sm:px-12 flex flex-col sm:flex-row justify-between items-center gap-5 sm:gap-8">
            <div class="basis-1/2">
                <h3 class="text-2xl sm:text-3xl font-bold text-gray-600 dark:text-gray-400 my-4 font-roboto">
                    Everything you can do in physical exams you can do in <span
                    class="text-rose-600">Teacher Platform</span>
                </h3>
                <p class="sm:text-lg text-gray-500 dark:text-gray-400">
                    Teacher platform software helps traditional and online ways of taking exams and quizzes and get the
                    answer for each question.
                    that makes it easy for teachers to create exams and for the students to know their degrees quickly,
                    and also improve themselves.
                </p>
            </div>
            <div class="basis-1/2 text-center bg-white dark:bg-gray-700 rounded-xl">
                <img class="w-full mix-blend-darken dark:mix-blend-luminosity" src="/images/exam.svg" alt="Not Found">
            </div>
        </div>
    </div>

    <div class="mt-6 py-8 px-12">
        <div class="header">
            <h2
                class="font-roboto w-fit mx-auto sm:mt-20 text-4xl sm:text-6xl font-black text-gray-700 dark:text-gray-500"
            >Our <span class="text-rose-600 dark:text-rose-700">Features</span></h2>

            <p
                class="text-center w-fit mx-auto mt-8 mb-16 sm:text-lg text-gray-700 dark:text-gray-400"
            >
                This very extraordinary feature, can make learning activities more efficient
            </p>
        </div>

        <div class="mt-4">
            <div class="flex flex-col sm:flex-row justify-between gap-8">
                <div class="basis-1/2">
                    <img class="mix-blend-darken sm:w-4/5 dark:mix-blend-luminosity" src="/images/29658253_7605882.jpg"
                         alt="Not Found">
                </div>
                <div class="basis-1/2">
                    <h3 class="text-center my-5 sm:my-8 text-2xl sm:text-4xl font-bold font-roboto text-gray-700 dark:text-gray-400">
                        A <span class="text-orange-600 dark:text-orange-700">user interface</span> designed for easy use
                    </h3>
                    <!-- component -->
                    <div
                        class="flex flex-col space-y-4 animated fadeIn faster  justify-center items-center inset-0  outline-none focus:outline-none">
                        <div
                            class="flex flex-col p-4 bg-gray-200 dark:bg-white shadow-lg hover:shodow-xl hover:scale-105 transition-all rounded-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center justify-between gap-5">
                                    <v-icon class="block text-teal-600 dark:text-gray-500" size="x-large"
                                            icon="mdi-account-plus"/>
                                    <p class="text-gray-600 leading-none mt-1">
                                        It is easy for users to create, login accounts.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex flex-col p-4 bg-gray-200 dark:bg-white shadow-lg hover:shodow-xl hover:scale-105 transition-all rounded-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center justify-between gap-5">
                                    <v-icon class="block text-rose-600 dark:text-gray-500" size="x-large"
                                            icon="mdi-file-pdf-box"/>
                                    <p class="text-gray-600 leading-none mt-1">
                                        We provide exams as pdf files and as online
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex flex-col p-4 bg-gray-200 dark:bg-white shadow-lg hover:shodow-xl hover:scale-105 transition-all rounded-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center justify-between gap-5">
                                    <v-icon class="block text-cyan-600 dark:text-gray-500" size="x-large"
                                            icon="mdi-map-marker-path"/>
                                    <p class="text-gray-600 leading-none mt-1">
                                        Roadmap for each subject and each grade...
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="flex flex-col p-4 bg-gray-200 dark:bg-white shadow-lg hover:shodow-xl hover:scale-105 transition-all rounded-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center justify-between gap-5">
                                    <v-icon class="block text-slate-600 dark:text-gray-500" size="x-large"
                                            icon="mdi-timer"/>
                                    <p class="text-gray-600 leading-none mt-1">
                                        Save time taken by teachers in making exams
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col-reverse sm:flex-row justify-center items-center mt-24 gap-5 sm:gap-12">
                <div class="sm:basis-1/2">
                    <h3 class="sm:text-center my-5 sm:my-8 text-2xl sm:text-4xl font-bold font-roboto text-gray-700 dark:text-gray-400">
                        <span class="text-orange-600 dark:text-orange-700">Tools</span> designed for Teachers and
                        Learners
                    </h3>

                    <p class="text-gray-600 dark:text-gray-300 sm:px-8">
                        Teachers can handout assignments in real-time for students to complete and submit,
                        They can also generate an quiz for each lesson, so the program give them the ability to
                        specify which part to generate exam to.
                    </p>
                </div>
                <div class="sm:basis-1/2">
                    <img class="mix-blend-darken w-full sm:w-4/5 dark:mix-blend-luminosity" src="/images/confusing.svg"
                         alt="Not Found">
                </div>
            </div>
        </div>
    </div>

    <div class="my-8 py-12 bg-white dark:bg-gray-800">
        <div class="header mx-8">
            <h2
                class="font-roboto w-fit mx-auto sm:mt-20 text-4xl sm:text-6xl font-black text-gray-700 dark:text-gray-500"
            >All in one <span class="text-rose-600 dark:text-rose-700">cloud software</span></h2>

            <p
                class="sm:w-1/2 sm:text-center mx-auto mt-8 mb-16 sm:text-lg text-gray-700 dark:text-gray-400"
            >
                <span class="text-rose-600">Teacher</span> is one powerful online software suite that combine tools
                needed for both students and teachers to run educational process
            </p>
        </div>

        <div class="flex flex-col sm:flex-row justify-center items-center gap-5 sm:gap-12 sm:mb-24 mx-5">
            <div class="basis-1/4 bg-white dark:bg-gray-700 p-5 rounded-lg shadow-lg">
                <h4 class="text-xl font-bold py-3 space-y-4">
                    <v-icon class="text-5xl text-indigo-600 bg-indigo-200 dark:text-gray-500 dark:bg-gray-700 p-1 block"
                            icon="mdi-monitor-cellphone-star"/>
                    <span class="block text-gray-700 dark:text-gray-200 font-roboto">Responsive design</span>
                </h4>

                <p class="text-gray-600 dark:text-gray-300">
                    It can run in all kind of devices, as computers, tablets, and phones as well
                </p>
            </div>

            <div class="basis-1/4 bg-white dark:bg-gray-700 p-5 rounded-lg shadow-lg">
                <h4 class="text-xl font-bold py-3 space-y-4">
                    <v-icon class="text-5xl text-teal-700 bg-teal-100 dark:text-gray-500 dark:bg-gray-700  block"
                            icon="mdi-cash-fast"/>
                    <span class="block text-gray-700 dark:text-gray-200 font-roboto">Fair Pricing</span>
                </h4>

                <p class="text-gray-600 dark:text-gray-300">
                    It Manages you for creating exams, quizzes and even revisions in low prices
                </p>
            </div>

            <div class="basis-1/4  bg-white dark:bg-gray-700 p-5 rounded-lg shadow-lg">
                <h4 class="text-xl font-bold py-3 space-y-4">
                    <v-icon class="text-5xl text-blue-600 bg-blue-200 dark:text-gray-500 dark:bg-gray-700 block"
                            icon="mdi-robot-confused-outline"/>
                    <span class="block text-gray-700 dark:text-gray-200 font-roboto">Interactive software</span>
                </h4>

                <p class="text-gray-600 dark:text-gray-300">
                    It can interact with users to suite their needs and we also it always evolves
                </p>
            </div>
        </div>
    </div>

    <div class="mt-6 py-8 px-5 sm:px-12">
        <div class="header">
            <h2
                class="font-roboto w-fit mx-auto sm:mt-20 text-4xl sm:text-6xl font-black text-gray-700 dark:text-gray-500"
            >Our <span class="text-rose-600 dark:text-rose-700">Achievements</span></h2>

            <p
                class="text-center w-fit mx-auto mt-8 sm:mb-16 sm:text-lg text-gray-700 dark:text-gray-400"
            >
                Up till now we have achieved with you a lot of work
            </p>
        </div>

        <div class="flex flex-col justify-center items-center  pt-4">
            <div
                class="w-full md:w-1/2 md:min-w-[700px] xl:min-w-[800px] mt-3 grid grid-cols-1 gap-5 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-3 3xl:grid-cols-6">
                <div
                    class="relative flex flex-grow  flex-col items-center rounded-[10px] border-[1px] border-gray-200 bg-white bg-clip-border shadow-md hover:shadow-xl transition-all shadow-[#F3F3F3] dark:border-[#ffffff33] dark:bg-gray-700 dark:text-white dark:shadow-none">
                    <div class="ml-[18px] flex h-[90px] w-auto flex-row items-center">
                        <div class="rounded-full p-3">
                                <span class="flex items-center text-slate-600 dark:text-gray-300">
                                    <v-icon size="x-large" icon="mdi-note-edit"/>
                                </span>
                        </div>
                    </div>
                    <div class="h-50 ml-4 flex w-auto flex-col justify-center">
                        <p class="font-dm text-sm font-medium text-gray-600 dark:text-gray-300">Exams</p>
                        <h4 class="text-xl font-bold text-gray-600 dark:text-gray-300">>10K</h4>
                    </div>
                </div>
                <div
                    class="relative flex flex-grow  flex-col items-center rounded-[10px] border-[1px] border-gray-200 bg-white bg-clip-border shadow-md hover:shadow-xl transition-all shadow-[#F3F3F3] dark:border-[#ffffff33] dark:bg-gray-700 dark:text-white dark:shadow-none">
                    <div class="ml-[18px] flex h-[90px] w-auto flex-row items-center">
                        <div class="rounded-full p-3">
                                <span class="flex items-center text-blue-700 dark:text-gray-300">
                                    <v-icon size="x-large" icon="mdi-human-male-board"/>
                                </span>
                        </div>
                    </div>
                    <div class="h-50 ml-4 flex w-auto flex-col justify-center">
                        <p class="font-dm text-sm font-medium text-gray-600 dark:text-gray-300">Teachers</p>
                        <h4 class="text-xl font-bold text-gray-600 dark:text-gray-300">2000</h4>
                    </div>
                </div>
                <div
                    class="relative flex flex-grow flex-col items-center rounded-[10px] border-[1px] border-gray-200 bg-white bg-clip-border shadow-md hover:shadow-xl transition-all shadow-[#F3F3F3] dark:border-[#ffffff33] dark:bg-gray-700 dark:text-white dark:shadow-none">
                    <div class="ml-[18px] flex h-[90px] w-auto flex-row items-center">
                        <div class="rounded-full p-3">
                                <span class="flex items-center text-green-800 dark:text-gray-300">
                                    <v-icon size="x-large" icon="mdi-account-multiple"/>
                                </span>
                        </div>
                    </div>
                    <div class="h-50 ml-4 flex w-auto flex-col justify-center">
                        <p class="font-dm text-sm font-medium text-gray-600 dark:text-gray-300">Students</p>
                        <h4 class="text-xl font-bold text-gray-600 dark:text-gray-300">1500</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="my-8 py-12 bg-white dark:bg-gray-800">
        <div class="header">
            <h2
                class="font-roboto w-fit mx-auto sm:mt-16 text-6xl font-black text-gray-700 dark:text-gray-500"
            ><span class="text-rose-600 dark:text-rose-700">FAQ</span></h2>

            <p
                class="sm:w-1/2 text-center mx-auto mt-8  text-lg text-gray-700 dark:text-gray-400"
            >
                <span class="text-rose-600">Teacher</span> answers your frequently asked questions
            </p>
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-center w-4/5 gap-5 mx-auto py-8">
            <div class="sm:basis-1/2">
                <img class="mix-blend-darken w-full sm:w-4/5 dark:mix-blend-luminosity" src="/images/questions.svg"
                     alt="Question image">
            </div>
            <div class="sm:basis-1/2">
                <v-expansion-panels variant="accordion">
                    <v-expansion-panel class="my-1">
                        <v-expansion-panel-title class="dark:bg-gray-700 dark:text-gray-300">
                            What kind of schools you have exams to?
                        </v-expansion-panel-title>
                        <v-expansion-panel-text class="dark:bg-gray-800 dark:text-gray-300">
                            We provide exams for Arabic and English from grade 1 to grade 12
                        </v-expansion-panel-text>
                    </v-expansion-panel>
                    <v-expansion-panel class="my-1">
                        <v-expansion-panel-title class="dark:bg-gray-700 dark:text-gray-300">
                            What kind exams in the site?
                        </v-expansion-panel-title>
                        <v-expansion-panel-text class="dark:bg-gray-800 dark:text-gray-300">
                            We provide all kinds of exams, texts, quizzes, revisions.
                        </v-expansion-panel-text>
                    </v-expansion-panel>
                    <v-expansion-panel class="my-1">
                        <v-expansion-panel-title class="dark:bg-gray-700 dark:text-gray-300">
                            How can i pay for the exams?
                        </v-expansion-panel-title>
                        <v-expansion-panel-text class="dark:bg-gray-800 dark:text-gray-300">
                            You can pay using your credit card and cash wallets.
                        </v-expansion-panel-text>
                    </v-expansion-panel>
                </v-expansion-panels>
            </div>
        </div>
    </div>

</template>
