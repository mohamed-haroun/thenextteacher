<script setup>
import {Head} from "@inertiajs/vue3";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import {ref} from "vue";

defineOptions({
    layout: GuestLayout
})

let loading = ref(false)
</script>

<template>
    <Head title="About US"/>

    <div class="sm:mt-4 md:mt-5">
        <div class="flex flex-col-reverse sm:flex-row justify-between items-center sm:py-8">
            <div class="basis-1/2">
                <h2
                    class="font-roboto sm:w-fit mx-auto sm:mt-20 text-center text-4xl sm:text-6xl font-black text-gray-700 dark:text-gray-500"
                >Who are <span class="text-rose-600 dark:text-rose-700">We?</span></h2>

                <p
                    class="w-4/5 text-center sm:w-2/3 sm:text-center mx-auto mt-8 mb-8 sm:mb-16 sm:text-lg text-gray-700 dark:text-gray-400"
                >
                    We are a platform that allows teachers to create and manage assignments, quizzes and exams. and
                    also allow students to take online exams and practice for real ones.
                </p>
            </div>

            <div class="basis-1/2">
                <img class="mix-blend-darken w-full sm:w-4/5 dark:mix-blend-luminosity" src="/images/who.svg"
                     alt="Question image">
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 py-12 flex flex-col justify-between items-center mt-12">
            <div>
                <h2
                    class="font-roboto sm:w-fit mx-auto mb-12 text-center text-4xl sm:text-6xl font-black text-gray-700 dark:text-gray-500"
                >Our <span class="text-rose-600 dark:text-rose-700">Team</span></h2>
            </div>

            <div class="flex flex-col sm:flex-row justify-center items-center gap-8">
                <v-card
                    :loading="loading"
                    class="mx-3 basis-1/4 bg-slate-200 shadow-2xl dark:bg-gray-700 dark:text-gray-200"
                >
                    <template v-slot:loader="{ isActive }">
                        <v-progress-linear
                            :active="isActive"
                            color="deep-purple"
                            height="4"
                            indeterminate
                        ></v-progress-linear>
                    </template>

                    <img
                        class="dark:mix-blend-luminosity"
                        src="/images/ahmed_nassr.jpg"
                        alt="Ahmed Nassr"
                    />

                    <v-card-item>
                        <v-card-title>Ahmed Nassr</v-card-title>

                        <v-card-subtitle>
                            <span class="me-1">Math Teacher</span>
                        </v-card-subtitle>
                    </v-card-item>

                    <v-card-text>

                        <div class="my-4 text-subtitle-1">
                            Socials
                        </div>

                        <div class="w-full flex flex-row justify-evenly">
                            <a
                                target="_blank"
                                href="https://www.facebook.com/ahmednassr330">
                                <v-icon size="x-large" class="text-blue-600" icon="mdi-facebook"/>
                            </a>

                            <a
                                target="_blank"
                                href="https://www.linkedin.com/in/ahmednassr330/">
                                <v-icon size="x-large" class="text-sky-700" icon="mdi-linkedin"/>
                            </a>

                            <a
                                target="_blank"
                                href="https://twitter.com/ahmednassr330">
                                <v-icon size="x-large" class="text-blue-400" icon="mdi-twitter"/>
                            </a>

                            <a
                                target="_blank"
                                href="https://www.youtube.com/@MathsMrAN">
                                <v-icon size="x-large" class="text-red-600" icon="mdi-youtube"/>
                            </a>
                        </div>
                    </v-card-text>
                </v-card>

                <v-card
                    :loading="loading"
                    class="mx-3 basis-1/4 bg-slate-200 shadow-2xl dark:bg-gray-700 dark:text-gray-200"
                >
                    <template v-slot:loader="{ isActive }">
                        <v-progress-linear
                            :active="isActive"
                            color="deep-purple"
                            height="4"
                            indeterminate
                        ></v-progress-linear>
                    </template>

                    <img
                        class="w-fit dark:mix-blend-luminosity"
                        src="/images/mohamed_haroun.png"
                        alt="Mohamed Haroun"
                    />

                    <v-card-item>
                        <v-card-title>Mohamed Haroun</v-card-title>

                        <v-card-subtitle>
                            <span class="me-1">Science Teacher & Web developer</span>
                        </v-card-subtitle>
                    </v-card-item>

                    <v-card-text>

                        <div class="my-4 text-subtitle-1">
                            Socials
                        </div>

                        <div class="w-full flex flex-row justify-evenly">
                            <a
                                target="_blank"
                                href="https://www.facebook.com/mohamedharoun230/">
                                <v-icon size="x-large" class="text-blue-600" icon="mdi-facebook"/>
                            </a>

                            <a
                                target="_blank"
                                href="https://www.linkedin.com/in/mohamed-haroun-673b67122/">
                                <v-icon size="x-large" class="text-sky-700" icon="mdi-linkedin"/>
                            </a>

                            <a
                                target="_blank"
                                href="https://twitter.com/mohamedharoun27">
                                <v-icon size="x-large" class="text-blue-400" icon="mdi-twitter"/>
                            </a>

                            <a
                                target="_blank"
                                href="https://www.youtube.com/@mohamedharoun6372">
                                <v-icon size="x-large" class="text-red-600" icon="mdi-youtube"/>
                            </a>
                        </div>
                    </v-card-text>
                </v-card>
            </div>
        </div>
    </div>

</template>

