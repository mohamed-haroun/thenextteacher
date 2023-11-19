<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Header from "@/Components/Header.vue";
import {Link, useForm} from "@inertiajs/vue3";
import {Head} from "@inertiajs/vue3";
import DataTable from "datatables.net-vue3";

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    student: Object,
    grades: Array,
})

const form = useForm({
    grade: null
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

let examStatus = (test) => {
    if (test.student_answers?.length) {
        return 'Completed'
    } else {
        return 'Not completed';
    }
}

let studentDegree = (test) => {
    let degree = 0
    let percentage = 0
    if (test.student_answers?.length) {
        for (let answer of test.student_answers) {
            if (answer.correctness) {
                degree++;
            }
        }

        percentage = Math.ceil((degree / test.student_answers.length) * 100)
    }

    return percentage + ' %';
}

const options = {
    responsive: true,
    select: false,
    scroller: true,
    scrollX: 300,
    pagingType: "full_numbers",
    processing: true,
};

</script>

<template>

    <Head :title="student.user.first_name + ' ' + student.user.last_name"/>

    <Header class="sm:mx-3">
        <div class="flex justify-between items-center">
            <v-breadcrumbs class="text-sm">
                <template #default>
                    <v-breadcrumbs-item>
                        <Link :href="route('users.index')">Users</Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider>
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>

                    <v-breadcrumbs-item>
                        <Link :href="route('students.index')">students</Link>
                    </v-breadcrumbs-item>
                    <v-breadcrumbs-divider>
                        <v-icon icon="mdi-chevron-right"></v-icon>
                    </v-breadcrumbs-divider>

                    <v-breadcrumbs-item disabled>
                        {{ student.user.first_name + ' ' + student.user.last_name }}
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>
        </div>

    </Header>

    <div class="flex flex-col md:flex-row md:gap-5 md:m-8">
        <!--        Profile info-->
        <div class="lg:basis-1/3">
            <div
                class="border-4 border-double border-indigo-100 flex flex-col md:flex-row justify-center items-center md:items-end space-x-6 shadow rounded-lg p-5 bg-white dark:bg-gray-800">
                <div>
                    <img v-if="student.user.profile_pic" class="w-24 h-24 md:w-36 md:h-36 rounded-full"
                         :src="'/pics/' + student.user.profile_pic"
                         alt="profile pic">
                </div>

                <div class="space-y-1">
                    <p class="text-blue-500 font-bold">{{ student.user.first_name + ' ' + student.user.last_name }}</p>
                    <p class="text-gray-500 text-sm capitalize">{{ student.user.type }}</p>
                </div>
            </div>
            <div class="my-3 p-2 md:p-5 bg-white dark:bg-gray-800 dark:text-gray-200 shadow-lg rounded-lg">
                <h2>Profile Details</h2>
                <dl class="divide-y divide-gray-300 dark:divide-gray-500">
                    <div class="px-4 py-4 sm:grid grid-cols-1 sm:grid-cols-4 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Email:</dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-3 sm:mt-0 overflow-x-hidden text-ellipsis">
                            {{
                                student.user.email
                            }}
                        </dd>
                    </div>
                    <div class="px-4 py-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Phone:</dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-3 sm:mt-0">
                            {{
                                student.user.phone_number
                            }}
                        </dd>
                    </div>
                    <div class="px-4 py-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Gender:</dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-3 sm:mt-0">
                            {{
                                student.user.gender
                            }}
                        </dd>
                    </div>

                    <div class="px-4 py-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Birth:</dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 text-start sm:col-span-3 sm:mt-0">
                            {{
                                student.user.birth_date
                            }}
                        </dd>
                    </div>

                    <div class="px-4 py-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-slate-100">Grade:</dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-3 sm:mt-0">
                            {{
                                student.grade.title
                            }}
                        </dd>
                    </div>
                </dl>
            </div>

            <!--Address Details-->
            <div class="my-3 p-2 md:p-5 bg-white dark:bg-gray-800 dark:text-gray-200 shadow-lg rounded-lg">
                <h2>Address Details</h2>
                <dl class="divide-y divide-gray-300 dark:divide-gray-500">
                    <div class="px-4 py-4 sm:grid grid-cols-1 sm:grid-cols-4 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 sm:col-span-2 dark:text-slate-100">
                            Governorate:
                        </dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0 overflow-x-hidden text-ellipsis">
                            {{
                                student.user.governorate
                            }}
                        </dd>
                    </div>
                    <div class="px-4 py-4 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 sm:col-span-2  dark:text-slate-100">
                            City:
                        </dt>
                        <dd class="mt-1 text-sm text-gray-700 dark:text-gray-100 sm:col-span-2 sm:mt-0">
                            {{
                                student.user.city
                            }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="md:basis-2/3 flex flex-col gap-5 my-1">

            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg">
                <h3 class="text-xl rounded-t font-bold text-gray-100 bg-gray-700 dark:text-gray-300 dark:bg-gray-700 text-center py-3 ">
                    Subjects
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 m-3 text-center py-4">
                    <div v-for="subject in student.grade.subjects">
                        <Link
                            :href="route('student.subject', {subject: subject.id})"
                            class="text-lg p-3 block font-semibold text-gray-100 bg-blue-400 hover:bg-blue-500 dark:bg-blue-500/80 dark:text-gray-200 dark:hover:bg-blue-800 transition-all rounded">
                            {{ subject.title }}
                        </Link>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:text-gray-300 dark:bg-gray-800 shadow-lg rounded-lg pb-5">
                <h3 class="text-xl rounded-t font-bold text-gray-100 bg-gray-700 dark:text-gray-300 dark:bg-gray-800/90 text-center py-3 ">
                    Exams & Quizzes Reports
                </h3>

                <div class="gap-5 m-3 text-center">

                    <DataTable v-if="student.user.tests !== []"
                               class="display w-full nowrap bg-white dark:bg-slate-800 dark:text-gray-300"
                               :options="options"
                    >
                        <thead>
                        <tr class="py-5">
                            <th>#</th>
                            <th>Type</th>
                            <th>NO. Question</th>
                            <th>Duration</th>
                            <th>Net Degree</th>
                            <th>Status</th>
                            <th>Report</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="(test, index) in student.user.tests" :key="test.id">
                            <td>{{ index + 1 }}</td>
                            <td>
                                <Link :href="route('students.exam', [test.id])"
                                      class="w-full text-blue-500 dark:text-blue-300 z-50">{{ test.test_type?.title }}
                                </Link>
                            </td>
                            <td>{{ test.questions?.length }}</td>
                            <td>{{ test.duration }} min</td>
                            <td>{{ test.degree }}</td>
                            <td>{{ examStatus(test) }}</td>
                            <td>{{ studentDegree(test) }}</td>
                        </tr>
                        </tbody>
                    </DataTable>
                </div>
            </div>
        </div>
    </div>

</template>
<style>
@import 'datatables.net-dt';
</style>
