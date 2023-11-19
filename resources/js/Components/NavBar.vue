<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import {ref} from "vue";
import NavLink from "@/Components/NavLink.vue";
import {useDark, useToggle} from "@vueuse/core";
// Dark mode switcher
const isDark = useDark();
const toggleDark = useToggle(isDark);

const showingNavigationDropdown = ref(false)
</script>

<template>
    <nav class="shadow-md sm:rounded-full">
        <div class="mx-auto px-8 bg-white/90 dark:bg-gray-700/70 sm:rounded-full">
            <div class="relative w-full flex h-16 items-center justify-between">
                <div class="sm:hidden absolute inset-y-0 right-0 flex items-center ">
                    <!-- Mobile menu button-->
                    <button @click="showingNavigationDropdown = !showingNavigationDropdown" type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="absolute -inset-0.5"></span>
                        <span class="sr-only">Open main menu</span>
                        <!--
                          Icon when menu is closed.

                          Menu open: "hidden", Menu closed: "block"
                        -->
                        <svg v-if="!showingNavigationDropdown" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <!--
                          Icon when menu is open.

                          Menu open: "block", Menu closed: "hidden"
                        -->
                        <svg v-else class="block h-6 w-6" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex flex-1 sm:items-center justify-between w-full">
                    <div class="flex flex-shrink-0 items-center gap-2">
                        <ApplicationLogo class="h-8 w-auto" />
                        <p class="text-rose-700 font-semibold">Teacher</p>
                    </div>

                    <div class="sm:hidden mx-12">
                        <v-btn size="small" v-if="isDark" @click="toggleDark()" class="text-orange-500 dark:bg-gray-700"
                               icon="mdi-weather-sunny">
                        </v-btn>
                        <v-btn size="small"  v-else @click="toggleDark()" class="text-blue-500"
                               icon="mdi-weather-night"></v-btn>
                    </div>

                    <div class="hidden sm:ml-6 sm:flex justify-center items-center space-x-12">
                        <div class="flex space-x-4 justify-center">
                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                            <NavLink href="/" :active="$page.component === 'Index'">Home</NavLink>
                            <NavLink href="/about" :active="$page.component === 'About'">About Us</NavLink>
                            <NavLink href="/contact" :active="$page.component === 'ContactUs'">Contact Us</NavLink>
                        </div>

                        <div class="w-fit">
                            <v-btn size="small" v-if="isDark" @click="toggleDark()" class="text-orange-500 bg-slate-700"
                                   icon="mdi-weather-sunny">
                            </v-btn>
                            <v-btn size="small" v-else @click="toggleDark()" class="text-blue-500"
                                   icon="mdi-weather-night"></v-btn>
                        </div>

                        <div class="flex space-x-4 justify-center">
                            <div v-if="! $page.props.auth.user" class="space-x-3">
                                <NavLink :href="route('login')" >Login</NavLink>
                                <NavLink :href="route('register')" >Register</NavLink>
                            </div>
                            <div v-else>
                                <NavLink :href="route('profile')" >
                                    <img v-if="$page.props.auth.user.profile_pic" class="w-8 h-10 rounded-full" :src="'/pics/' + $page.props.auth.user.profile_pic" alt="profile pic">
                                    <span v-else>{{ $page.props.auth.user.first_name }}</span>
                                </NavLink>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on menu state. -->
        <div v-if="showingNavigationDropdown" id="mobile-menu" class="mt-1 bg-white/70 dark:bg-gray-700/70">
            <div class="space-y-3 px-2 pb-3 pt-2 flex flex-col"  :class="{'flex-col-reverse':  $page.props.auth.user}">
                <div class="flex flex-col space-y-4 justify-center">
                    <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                    <NavLink href="/" :active="$page.component === 'Index'">Home</NavLink>
                    <NavLink href="/about" :active="$page.component === 'About'">About Us</NavLink>
                    <NavLink href="/contact" :active="$page.component === 'ContactUs'">Contact Us</NavLink>
                </div>

                <div class="flex flex-col space-y-4">
                    <div v-if="! $page.props.auth.user" class="flex flex-col space-y-4">
                        <NavLink :href="route('login')" >Login</NavLink>
                        <NavLink :href="route('register')" >Register</NavLink>
                    </div>
                    <div v-else class="flex flex-col space-y-1 mb-4">
                        <NavLink :href="route('dashboard')" class="font-bold">{{ $page.props.auth.user.first_name }}</NavLink>
                        <p class="text-xs text-slate-500 dark:text-slate-50">{{ $page.props.auth.user.email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </nav>

</template>
