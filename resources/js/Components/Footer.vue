<script setup>
import {Link} from "@inertiajs/vue3";


</script>

<template>
    <footer class="bg-blue-100/80 font-sans dark:bg-gray-900">
        <div class="container px-6 py-12 md:py-12 mx-auto">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 sm:gap-y-10 lg:grid-cols-4 sm:ms-24">
                <div class="sm:col-span-2">
                    <h1 class="max-w-lg text-xl font-semibold tracking-tight text-gray-800 xl:text-2xl dark:text-white">Subscribe our newsletter to get an update.</h1>

                    <div class="flex flex-col mx-auto mt-6 space-y-3 md:space-y-0 md:flex-row">
                        <input id="email" type="text" class="px-4 py-2 text-gray-700 bg-white border rounded-md dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-opacity-40 focus:ring-blue-300" placeholder="Email Address" />

                        <button class="w-full px-6 py-2.5 text-sm font-medium tracking-wider text-white transition-colors duration-300 transform md:w-auto md:mx-4 focus:outline-none bg-rose-600 dark:bg-gray-700 rounded-lg hover:bg-gray-700 dark:hover:bg-rose-600 focus:ring focus:ring-gray-300 focus:ring-opacity-80">
                            Subscribe
                        </button>
                    </div>
                </div>

                <div>
                    <p class="font-semibold text-gray-800 text-start sm:text-center dark:text-white">Quick Link</p>

                    <div class="flex flex-col items-center sm:items-start mt-5 space-y-2">
                        <Link :href="route('home')" class="text-gray-600 transition-colors duration-300 dark:text-gray-300 dark:hover:text-blue-400 hover:underline hover:cursor-pointer hover:text-blue-500">Home</Link>
                        <Link :href="route('about')" class="text-gray-600 transition-colors duration-300 dark:text-gray-300 dark:hover:text-blue-400 hover:underline hover:cursor-pointer hover:text-blue-500">Who We Are</Link>
                        <Link :href="route('contact')" class="text-gray-600 transition-colors duration-300 dark:text-gray-300 dark:hover:text-blue-400 hover:underline hover:cursor-pointer hover:text-blue-500">Get in touch</Link>
                    </div>
                </div>

                <div>
                    <p class="font-semibold text-gray-800 items-center sm:items-start dark:text-white">Registration</p>

                    <div class="flex flex-col items-center sm:items-start mt-5 space-y-2">
                        <Link :href="route('login')" class="text-gray-600 transition-colors duration-300 dark:text-gray-300 dark:hover:text-blue-400 hover:underline hover:cursor-pointer hover:text-blue-500">Login</Link>
                        <Link :href="route('register')" class="text-gray-600 transition-colors duration-300 dark:text-gray-300 dark:hover:text-blue-400 hover:underline hover:cursor-pointer hover:text-blue-500">Register</Link>
                    </div>
                </div>
            </div>

            <hr class="my-6 border-gray-200 md:my-8 dark:border-gray-700 h-2" />

            <p class="font-sans sm:p-5 text-center dark:text-gray-300 md:text-center md:text-lg md:p-2">© {{ (new Date()).getFullYear() }} <span class="text-rose-600">Teacher</span> Inc. All rights reserved.</p>
        </div>
    </footer>
</template>
