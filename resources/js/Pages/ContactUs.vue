<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';

import {defineOptions} from "vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {useDark} from "@vueuse/core";

defineOptions({
    layout: GuestLayout
})

let form = useForm({
    name: '',
    email: '',
    message: ''
})

let isDark = useDark()

</script>

<template>
    <Head title="Contact Us" />

    <div class="my-12 flex flex-col-reverse md:flex-row">
        <div class="basis-1/2">
            <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
                <div class="mx-auto">
                    <h1 class="text-3xl font-bold font-roboto text-gray-600 dark:text-gray-300">Get in touch</h1>

                    <p class="mt-5 text-gray-500 dark:text-gray-400">
                        How can we help you? please write down your query.
                    </p>
                </div>

                <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                    <form class="space-y-6 bg-white dark:bg-gray-800 p-5 rounded" @submit.prevent="submit">
                        <div>
                            <InputLabel for="name" value="Full Name"/>

                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full placeholder-slate-400 placeholder:text-sm"
                                v-model="form.name"
                                required
                                autofocus
                                placeholder="Jone Doe"
                                autocomplete="first_name"
                            />

                            <InputError class="mt-2" :message="form.errors.first_name"/>
                        </div>

                        <div>
                            <InputLabel for="email" value="Email"/>

                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full placeholder-slate-400 placeholder:text-sm"
                                v-model="form.email"
                                required
                                placeholder="jonedoe@example.com"
                                autocomplete="email"
                            />

                            <InputError class="mt-2" :message="form.errors.email"/>
                        </div>

                            <div class="mt-3">
                                <v-textarea
                                    :color="isDark ? 'white':'gray'"
                                    label="Message"
                                    variant="outlined"
                                    :base-color="isDark ? 'white':'gray'"
                                    id="message"
                                    type="text"
                                    class="dark:text-blue-500 dark:bg-gray-800 font-bold rounded-lg"
                                    v-model="form.message"
                                    required
                                    placeholder="Enter Message"
                                    autocomplete="message"
                                ></v-textarea>

                                <InputError class="mt-2" :message="form.errors.message"/>
                            </div>
                            <div class="mt-3">
                                <button
                                    type="submit"
                                    class="px-3 py-2 text-white bg-rose-700 dark:bg-rose-800 rounded w-full"
                                >Send
                                    <v-icon icon="mdi-send-circle-outline" />
                                </button>
                            </div>
                    </form>
                </div>
            </div>

        </div>

        <div class="basis-1/2">
            <img class="mix-blend-darken dark:mix-blend-luminosity" src="/images/contact.svg" alt="Contact Us" />
        </div>
    </div>
</template>
