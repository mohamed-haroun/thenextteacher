<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Header from "@/Components/Header.vue";
import {Link, useForm} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import {Head} from "@inertiajs/vue3";

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    user: Object,
    grades: Array,
    subjects: Array
})

const form = useForm({
    grade: null
});


const teacherForm = useForm({
    subject: null
});


let itemProps = (item) => {
    return {
        title: item.title,
        subtitle: item.school,
    }
}

const submit = (user) => {
    form.patch(route('users.add_grade', {user: user}))
}

const teacherSubmit = (user) => {
    teacherForm.patch(route('users.add_subject', {user: user}))
}
</script>

<template>

    <Head :title="user.first_name + ' ' + user.last_name" />

    <Header class="sm:mx-3">
        <div class="flex justify-between items-center">
            <v-breadcrumbs class="text-sm" active-color="error">
                <template #default>
                    <v-breadcrumbs-item>
                        <Link :href="route('users.index')">Users</Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider>
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>
                    <v-breadcrumbs-item disabled>
                        {{ $page.props.auth.user.first_name }}
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>
        </div>

    </Header>

    <div class="flex flex-col md:flex-row md:gap-5 md:m-8">
        <!--        Profile info-->
        <div class="lg:basis-1/3">
            <div class="flex flex-col md:flex-row justify-center items-center md:items-end space-x-6 border-b p-5 bg-white dark:bg-gray-800">
                <div>
                    <img v-if="user.profile_pic" class="w-24 h-24 md:w-36 md:h-36 rounded-full"
                         :src="'/pics/' + user.profile_pic"
                         alt="profile pic">


                </div>

                <div class="space-y-1">
                    <p class="text-blue-500 font-bold">{{ user.first_name + ' ' + user.last_name }}</p>
                    <p class="text-gray-500 text-sm capitalize">{{ user.type }}</p>
                </div>
            </div>
            <div class="my-3 p-2 md:p-5 bg-white dark:bg-gray-800 dark:text-gray-200">
                <h2>Profile Details</h2>
                <dl class="divide-y divide-gray-300 dark:divide-gray-500">
                    <div class="px-4 py-4 sm:grid grid-cols-1 sm:grid-cols-4 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Email:</dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-3 sm:mt-0 overflow-x-hidden text-ellipsis">
                            {{
                                user.email
                            }}
                        </dd>
                    </div>
                    <div class="px-4 py-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Phone:</dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-3 sm:mt-0">
                            {{
                                user.phone_number
                            }}
                        </dd>
                    </div>
                    <div class="px-4 py-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Type:</dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-3 sm:mt-0">
                            {{
                                user.type
                            }}
                        </dd>
                    </div>

                    <div v-if="user.type === 'teacher'">
                        <div v-if="user.teacher" class="px-4 py-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Subject:</dt>
                            <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-3 sm:mt-0">
                                {{
                                    user.teacher.subject.title
                                }}
                            </dd>
                        </div>

                        <div v-else class="px-4 py-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Subject:</dt>
                            <dd class="text-sm text-gray-700 dark:text-gray-100 sm:col-span-3 sm:mt-0">

                                <v-dialog width="500">
                                    <template v-slot:activator="{ props }">
                                        <v-btn v-bind="props" class="animate-pulse bg-blue-500 text-white text-xs sm:text-sm md:text-md xl:text-base"
                                               size="small"  prepend-icon="mdi-plus-thick" text="Subject"></v-btn>
                                    </template>

                                    <template v-slot:default="{ isActive }">
                                        <v-card title="Add Teacher Subject" class="dark:bg-gray-700 dark:text-blue-500">
                                            <v-card-text>
                                                <v-form @submit.prevent="teacherSubmit(user)">
                                                    <div class="mt-3">
                                                        <v-select
                                                            class="bg-white text-black font-bold rounded-lg"
                                                            :closable-chips="true"
                                                            :chips="true"
                                                            label="Subject"
                                                            :items="subjects"
                                                            :item-props="itemProps"
                                                            v-model="teacherForm.subject"
                                                        ></v-select>
                                                        <InputError class="mt-2" :message="teacherForm.errors.subject"/>
                                                    </div>

                                                    <div class="mt-3">
                                                        <button
                                                            @click="isActive.value = false"
                                                            type="submit"
                                                            class="px-3 py-2 text-white bg-blue-500 rounded w-full"
                                                        >Add
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

                            </dd>
                        </div>
                    </div>

                    <div v-else>
                        <div v-if="user.student" class="px-4 py-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Subject:</dt>
                            <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-3 sm:mt-0">
                                {{
                                    user.student.grade.title
                                }}
                            </dd>
                        </div>

                        <div v-else class="px-4 py-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Subject:</dt>
                            <dd class="text-sm text-gray-700 dark:text-gray-100 sm:col-span-3 sm:mt-0">
                                <v-dialog width="500">
                                    <template v-slot:activator="{ props }">
                                        <v-btn v-bind="props" class="animate-pulse bg-blue-500 text-white text-xs sm:text-sm md:text-md xl:text-base"
                                             size="small"  prepend-icon="mdi-plus-thick" text="Grade"></v-btn>
                                    </template>

                                    <template v-slot:default="{ isActive }">
                                        <v-card title="Add New Grade" class="dark:bg-gray-700 dark:text-blue-500">
                                            <v-card-text>
                                                <v-form @submit.prevent="submit(user)">
                                                    <div class="mt-3">
                                                        <v-select
                                                            class="bg-white text-black font-bold rounded-lg"
                                                            :closable-chips="true"
                                                            :chips="true"
                                                            label="Grade"
                                                            :items="grades"
                                                            :item-props="itemProps"
                                                            v-model="form.grade"
                                                        ></v-select>
                                                        <InputError class="mt-2" :message="form.errors.grade"/>
                                                    </div>

                                                    <div class="mt-3">
                                                        <button
                                                            @click="isActive.value = false"
                                                            type="submit"
                                                            class="px-3 py-2 text-white bg-blue-500 rounded w-full"
                                                        >Add
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
                             </dd>
                        </div>
                    </div>
                </dl>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 md:basis-2/3">
            {{  user }}
        </div>
    </div>

</template>
