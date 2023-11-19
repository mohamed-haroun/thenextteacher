<script setup>
import {computed, ref} from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {Link, usePage} from '@inertiajs/vue3';
import {useDark, useToggle} from "@vueuse/core";

const showingNavigationDropdown = ref(false);
let drawer = ref()
let rail = ref(localStorage.getItem('rail') === 'true')

let drawerToggle = () => {
    rail.value = !rail.value;
    if (localStorage.getItem('rail') === 'true') {
        localStorage.setItem('rail', "false")
    } else {
        localStorage.setItem('rail', "true")
    }
}

const page = usePage()

const user = computed(() => page.props.auth.user)

const getRoles = () => {
    return user.value.roles.map(role => {
        return role.name
    })
}

// Dark mode switcher
const isDark = useDark();
const toggleDark = useToggle(isDark);

// Change Language
let language = ref('ar')

</script>

<template>
    <v-layout class="print:flex print:flex-col-reverse">
        <v-navigation-drawer
            v-if="getRoles().includes('admin')"
            v-model="drawer"
            :rail="rail"
            class=" bg-white print:hidden print:m-0 border rounded-lg shadow-xl ms-2 mt-3 dark:bg-gray-800 text-gray-800 dark:text-slate-100"
            :temporary="false"
        >
            <v-list-item
                class="py-2 border-b dark:border-blue-100 dark:border-opacity-30"
                nav
                @click.stop="drawerToggle"
            >

                <template v-slot:prepend>
                    <ApplicationLogo class="h-10 w-10"/>
                </template>

                <template v-slot:append>
                    <v-btn
                        class="text-blue-500 hover:text-gray-400"
                        variant="text"
                        icon="mdi-chevron-left"
                        @click.stop="drawerToggle"
                    ></v-btn>
                </template>
            </v-list-item>

            <v-list density="comfortable" class="mt-12">
                <Link :href="route('dashboard')">
                    <v-list-item class="py-4"
                                 color="blue"
                                 :active="$page.component==='Dashboard'"
                                 prepend-icon="mdi-view-dashboard"
                                 title="Dashboard" value="dashboard">
                    </v-list-item>
                </Link>
                <v-divider class="border-opacity-100 dark:opacity-20 border-blue-200"></v-divider>

                <!--Users List-->
                <v-menu location="end">
                    <template v-slot:activator="{ props }">
                        <v-list-item
                            v-bind="props"
                            class="py-4" color="blue" :active="$page.url.startsWith('/users')"
                            prepend-icon="mdi-account-group"
                            title="Users" value="users"
                        >
                        </v-list-item>
                    </template>
                    <v-list class="dark:bg-gray-700 dark:text-gray-300">
                        <Link :href="route('users.index')">
                            <v-list-item class="py-4" color="blue" :active="$page.component === 'Users/Index'"
                                         prepend-icon="mdi-clipboard-text-search"
                                         title="Users Overview" value="users">
                            </v-list-item>
                        </Link>

                        <v-divider class="border-opacity-100 dark:opacity-20 border-blue-200"></v-divider>

                        <Link :href="route('teachers.index')">
                            <v-list-item class="py-4" color="blue" :active="$page.component === 'Users/Teachers/Index'"
                                         prepend-icon="mdi-human-male-board"
                                         title="Teachers" value="teachers">
                            </v-list-item>
                        </Link>

                        <v-divider class="border-opacity-100 dark:opacity-20 border-blue-200"></v-divider>

                        <Link :href="route('students.index')">
                            <v-list-item class="py-4" color="blue" :active="$page.component === 'Users/Students/Index'"
                                         prepend-icon="mdi-account-multiple-plus"
                                         title="Students" value="students">
                            </v-list-item>
                        </Link>

                        <v-divider class="border-opacity-100 dark:opacity-20 border-blue-200"></v-divider>

                        <Link :href="route('parents.index')">
                            <v-list-item class="py-4" color="blue" :active="$page.component === 'Users/Parents/Index'"
                                         prepend-icon="mdi-account-child"
                                         title="Parents" value="parents">
                            </v-list-item>
                        </Link>
                    </v-list>
                </v-menu>

                <v-divider class="border-opacity-100 dark:opacity-20 border-blue-200"></v-divider>

                <Link :href="route('grades.index')">
                    <v-list-item class="py-4" color="blue" :active="$page.url.startsWith('/grades')"
                                 prepend-icon="mdi-domain"
                                 title="Grades" value="grades">
                    </v-list-item>
                </Link>

                <v-divider class="border-opacity-100 dark:opacity-20 border-blue-200"></v-divider>

                <Link :href="route('subjects.index')">
                    <v-list-item class="py-4" color="blue" :active="$page.url.startsWith('/subjects')"
                                 prepend-icon="mdi-bookshelf"
                                 title="Subjects" value="subjects">
                    </v-list-item>
                </Link>

                <v-divider class="border-opacity-100 dark:opacity-20 border-blue-200"></v-divider>

                <Link :href="route('lessons.index')">
                    <v-list-item class="py-4" color="blue" :active="$page.url.startsWith('/lessons')"
                                 prepend-icon="mdi-book"
                                 title="Lessons" value="lessons">
                    </v-list-item>
                </Link>

                <v-divider class="border-opacity-100 dark:opacity-20 border-blue-200"></v-divider>

                <Link :href="route('questions.index')">
                    <v-list-item class="py-4" color="blue" :active="$page.url.startsWith('/questions')"
                                 prepend-icon="mdi-help-box"
                                 title="Questions" value="questions">
                    </v-list-item>
                </Link>

                <v-divider class="border-opacity-100 dark:opacity-20 border-blue-200"></v-divider>

                <Link :href="route('tests.index')">
                    <v-list-item class="py-4" color="blue" :active="$page.url.startsWith('/tests')"
                                 prepend-icon="mdi-note-edit"
                                 title="Tests" value="tests">
                    </v-list-item>
                </Link>
            </v-list>
        </v-navigation-drawer>
        <v-main class="min-h-screen min-w-full bg-gray-100 dark:bg-gray-900">
            <nav
                class="sticky print:hidden print:m-0 top-3 rounded-2xl ms-3 me-2 sm:mx-3 px-2 z-50  shadow-lg bg-white dark:bg-gray-800 border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between w-full h-16">
                        <div>
                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <v-btn
                                    v-if="$page.props.auth.user.roles[0].name === 'admin'"
                                    class="dark:bg-gray-700 dark:text-gray-300"
                                    @click.stop="drawer = !drawer"
                                >
                                    <v-icon icon="mdi-format-indent-decrease"/>
                                </v-btn>

                                <NavLink :href="route('home')">
                                    <v-icon icon="mdi-home" class="mx-1"/>
                                    Home
                                </NavLink>
                                <NavLink
                                    v-if="$page.props.auth.user.roles[0].name === 'admin'"
                                    :href="route('dashboard')"
                                         :active="route().current('dashboard')">
                                    Dashboard
                                </NavLink>

                            </div>

                        </div>

                        <div class="flex items-center justify-center space-x-2">
                            <div>
                                <v-btn
                                    class="md:hidden"
                                    @click.stop="drawer = !drawer"
                                >
                                    Toggle
                                </v-btn>
                            </div>

                            <div>
                                <v-btn size="small" v-if="isDark" @click="toggleDark()"
                                       class="text-orange-500 bg-slate-700"
                                       icon="mdi-weather-sunny">
                                </v-btn>
                                <v-btn size="small" v-else @click="toggleDark()" class="text-blue-500"
                                       icon="mdi-weather-night"></v-btn>
                            </div>


                            <div class="hidden sm:flex sm:items-center sm:ml-6">
                                <!-- Settings Dropdown -->
                                <div class="ml-3 relative">
                                    <Dropdown align="right" width="48">
                                        <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                <img v-if="$page.props.auth.user.profile_pic"
                                                     class="w-8 h-10 rounded-full"
                                                     :src="'/pics/' + $page.props.auth.user.profile_pic"
                                                     alt="profile pic"/>

                                                <span v-else>{{ $page.props.auth.user.first_name }}</span>
                                                <svg
                                                    class="ml-2 -mr-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                        </template>

                                        <template #content>
                                            <DropdownLink :href="route('profile')"
                                                          :active="$page.component === 'Profile/Edit'">
                                                <v-icon icon="mdi-account" /> Profile
                                            </DropdownLink>
                                            <DropdownLink :href="route('profile.edit')"
                                                          :active="$page.component === 'Profile/Edit'">
                                                <v-icon icon="mdi-cog" /> Settings
                                            </DropdownLink>
                                            <DropdownLink :href="route('logout')" method="post" as="button">
                                                <v-icon icon="mdi-logout" /> Log Out
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                </div>
                            </div>
                            <!-- Hamburger -->
                            <div class="-mr-2 flex items-center sm:hidden">
                                <button
                                    @click="showingNavigationDropdown = !showingNavigationDropdown"
                                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
                                >
                                    <svg class="h-6 w-6" stroke="currentColor" fill="none"
                                         viewBox="0 0 24 24">
                                        <path
                                            :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h16"
                                        />
                                        <path
                                            :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('dashboard')"
                                           :active="route().current('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>

                        <ResponsiveNavLink :href="route('home')">
                            Home
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                                <img v-if="$page.props.auth.user.profile_pic" class="w-8 h-10 rounded-full"
                                     :src="'/pics/' + $page.props.auth.user.profile_pic"
                                     alt="profile pic">
                                {{ $page.props.auth.user.first_name }}
                                {{ $page.props.auth.user.last_name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile')">
                                <v-icon icon="mdi-account" /> Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('profile.edit')"
                                               :active="$page.component === 'Profile/Edit'">
                                <v-icon icon="mdi-cog" /> Settings
                            </ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                <v-icon icon="mdi-logout" /> Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <slot/>
        </v-main>
    </v-layout>
</template>
