<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Header from "@/Components/Header.vue";
import {Link, useForm, usePage} from "@inertiajs/vue3";
import InputError from "@/Components/InputError.vue";
import {Head} from "@inertiajs/vue3";
import DataTable from "datatables.net-vue3";
import {computed} from "vue";

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    teacher: Object,
    subject: Object
})

const teacherForm = useForm({
    subject: null
});

let itemProps = (item) => {
    return {
        title: item.title,
        subtitle: item.school,
    }
}
const teacherSubmit = (user) => {
    teacherForm.patch(route('users.add_subject', {user: user}))
}

const options = {
    responsive: true,
    select: false,
    scroller: true,
    scrollX: 300,
    pagingType: "full_numbers",
    processing: true,
};


const page = usePage()

const user = computed(() => page.props.auth.user)

const getRoles = () => {
    return user.value.roles.map(role => {
        return role.name
    })
}
</script>

<template>

    <Head :title="teacher.user.first_name + ' ' + teacher.user.last_name"/>

    <Header class="sm:mx-3">
        <div class="flex justify-between items-center">
            <v-breadcrumbs class="text-sm">
                <template #default>
                    <v-breadcrumbs-item
                        v-if="getRoles().includes('admin')"
                    >
                        <Link :href="route('users.index')">Users</Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider
                        v-if="getRoles().includes('admin')"
                    >
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>

                    <v-breadcrumbs-item
                        v-if="getRoles().includes('admin')"
                    >
                        <Link :href="route('teachers.index')">Teachers</Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider
                        v-if="getRoles().includes('admin')"
                    >
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>

                    <v-breadcrumbs-item disabled>
                        Profile
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>
            <div>
                <Link
                    :href="route('teachers.exam')"
                    class="bg-blue-600 text-white text-base px-3 py-2 rounded"
                >
                    Create Exam
                </Link>
            </div>
        </div>

    </Header>

    <div class="flex flex-col md:flex-row md:gap-3 md:mb-8 mx-5">
        <!--        Profile info-->
        <div class="lg:basis-1/3">
            <div
                class="flex flex-col md:flex-row justify-center items-center md:items-end space-x-6 shadow-lg rounded-lg border-b p-5 bg-white dark:bg-gray-800">
                <div>
                    <img v-if="teacher.user.profile_pic" class="w-24 h-24 md:w-36 md:h-36 rounded-full"
                         :src="'/pics/' + teacher.user.profile_pic"
                         alt="profile pic">


                </div>

                <div class="space-y-1">
                    <p class="text-blue-500 font-bold">{{ teacher.user.first_name + ' ' + teacher.user.last_name }}</p>
                    <p class="text-gray-500 text-sm capitalize">{{ teacher.user.type }}</p>
                </div>
            </div>
            <!--            Personal Details-->
            <div class="my-3 p-2 md:p-5 bg-white dark:bg-gray-800 dark:text-gray-200 shadow-lg rounded-lg">
                <h2>Profile Details</h2>
                <dl class="divide-y divide-gray-300 dark:divide-gray-500">
                    <div class="px-4 py-4 sm:grid grid-cols-1 sm:grid-cols-4 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Email:</dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-3 sm:mt-0 overflow-x-hidden text-ellipsis">
                            {{
                                teacher.user.email
                            }}
                        </dd>
                    </div>
                    <div class="px-4 py-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Phone:</dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-3 sm:mt-0">
                            {{
                                teacher.user.phone_number
                            }}
                        </dd>
                    </div>
                    <div class="px-4 py-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Birth:</dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-3 sm:mt-0">
                            {{
                                teacher.user.birth_date
                            }}
                        </dd>
                    </div>
                    <div class="px-4 py-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Gender:</dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-3 sm:mt-0">
                            {{
                                teacher.user.gender
                            }}
                        </dd>
                    </div>

                    <div v-if="teacher.user.type === 'teacher'">
                        <div v-if="teacher" class="px-4 py-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Subject:</dt>
                            <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-3 sm:mt-0">
                                {{
                                    teacher.subject.title
                                }}
                            </dd>
                        </div>

                        <div v-else class="px-4 py-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                            <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Subject:</dt>
                            <dd class="text-sm text-gray-700 dark:text-gray-100 sm:col-span-3 sm:mt-0">

                                <v-dialog width="500">
                                    <template v-slot:activator="{ props }">
                                        <v-btn v-bind="props"
                                               class="animate-pulse bg-blue-500 text-white text-xs sm:text-sm md:text-md xl:text-base"
                                               size="small" prepend-icon="mdi-plus-thick" text="Subject"></v-btn>
                                    </template>

                                    <template v-slot:default="{ isActive }">
                                        <v-card title="Add Teacher Subject" class="dark:bg-gray-700 dark:text-blue-500">
                                            <v-card-text>
                                                <v-form @submit.prevent="teacherSubmit(teacher)">
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
                </dl>
            </div>

            <!--            Address Details-->
            <div class="my-3 p-2 md:p-5 bg-white dark:bg-gray-800 dark:text-gray-200 shadow-lg rounded-lg">
                <h2>Address Details</h2>
                <dl class="divide-y divide-gray-300 dark:divide-gray-500">
                    <div class="px-4 py-4 sm:grid grid-cols-1 sm:grid-cols-4 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 sm:col-span-2 dark:text-slate-100">
                            Governorate:
                        </dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0 overflow-x-hidden text-ellipsis">
                            {{
                                teacher.user.governorate
                            }}
                        </dd>
                    </div>
                    <div class="px-4 py-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 sm:col-span-2  dark:text-slate-100">
                            City:
                        </dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                            {{
                                teacher.user.city
                            }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="basis-2/3 bg-white dark:text-gray-300 dark:bg-gray-800 shadow-lg rounded-lg pb-5">
            <h3 class="text-xl rounded-t font-bold text-gray-100 bg-gray-700 dark:text-gray-300 dark:bg-gray-800/90 text-center py-3 ">
                Exams & Quizzes Reports
            </h3>

            <div class="gap-5 m-3 text-center">

                <DataTable v-if="teacher.user.tests !== []"
                           class="display w-full nowrap bg-white dark:bg-slate-800 dark:text-gray-300"
                           :options="options"
                >
                    <thead>
                    <tr class="py-5">
                        <th>#</th>
                        <th>Type</th>
                        <th>NO. Question</th>
                        <th>Duration</th>
                        <th>Degree</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-for="(test, index) in teacher.user.tests" :key="test.id">
                        <td>{{ index + 1 }}</td>
                        <td>
                            <Link :href="route('tests.display', [test.id])"
                                  class="w-full text-blue-500 dark:text-blue-300 z-50">{{ test.test_type?.title }}
                            </Link>
                        </td>
                        <td>{{ test.questions?.length }}</td>
                        <td>{{ test.duration }} min</td>
                        <td>{{ test.degree }}</td>
                    </tr>
                    </tbody>
                </DataTable>
            </div>
        </div>
    </div>

</template>
<style>
@import 'datatables.net-dt';
</style>
