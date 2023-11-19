<script setup>
import {Head, usePage} from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {computed, onMounted, ref} from "vue";
import Header from "@/Components/Header.vue";
import Card from "@/Components/Card.vue";
import Chart from 'chart.js/auto';
import {getRelativePosition} from 'chart.js/helpers';

defineOptions({
    layout: AuthenticatedLayout
})

defineProps({
    users: Array,
    teachers: Number,
    parents: Number,
    students: Number
})

let teachers = computed(() => usePage().props.teachers)
let students = computed(() => usePage().props.students)
let parents = computed(() => usePage().props.parents)


let males = computed(() => {
    let users = usePage().props.users
    return users.filter((user) => {
        if (user.gender === 'male') {
            return user
        }
    })
})

let females = computed(() => {
    let users = usePage().props.users
    return users.filter((user) => {
        if (user.gender === 'female') {
            return user
        }
    })
})


const usersGraph = ref()
const genderGraph = ref()

onMounted(() => {
    // Users charts
    new Chart(usersGraph.value, {
        type: 'bar',
        data: {
            labels: ['Teachers', 'Students', 'Parents'],
            datasets: [{
                label: 'Users',
                data: [teachers.value, students.value, parents.value],
                backgroundColor: [
                    'rgb(54, 162, 235)',
                    'rgb(255, 180, 80)',
                    'rgb(100, 100, 100)',
                ],
                borderColor: '#FFF'
            }]
        },
    });
})

onMounted(() => {
    // Gender graph
    new Chart(genderGraph.value, {
        type: 'doughnut',
        data: {
            labels: ['Males', 'Females'],
            datasets: [{
                label: 'Users',
                data: [males.value.length, females.value.length],
                backgroundColor: [
                    'rgb(54, 162, 235)',
                    'rgb(255, 120, 150)',
                ],
                borderColor: '#FFF'
            }]
        },
    });

})


</script>

<template>
    <Head title="Users"/>

    <Header class="sm:mx-3">
        <div class="flex justify-between items-center">
            <v-breadcrumbs class="text-sm" active-color="error">
                <template #default>
                    <v-breadcrumbs-item disabled>
                        Users
                    </v-breadcrumbs-item>
                </template>
            </v-breadcrumbs>
        </div>

    </Header>

    <div class="sm:mx-2 md:mx-5 lg:mx-10 mb-5">

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mx-2 mb-5">
            <Card title="Users" :count="users.length">
                <template #icon>
                    <v-icon icon="mdi-account-group" color="green" class="bg-green-300/30 p-8 rounded-full"/>
                </template>
            </Card>

            <Card title="Teachers" :count="teachers">
                <template #icon>
                    <v-icon icon="mdi-human-male-board" color="blue" class="bg-blue-300/30 p-8 rounded-full"/>
                </template>
            </Card>

            <Card title="Students" :count="students">
                <template #icon>
                    <v-icon icon="mdi-human-male-female" color="orange" class="bg-orange-300/30 p-8 rounded-full"/>
                </template>
            </Card>

            <Card title="Parents" :count="parents">
                <template #icon>
                    <v-icon icon="mdi-human-male-child" color="rose" class="bg-gray-300/30 p-8 rounded-full"/>
                </template>
            </Card>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 mx-2 sm:gap-2 space-y-2 md:gap-4">
            <div class="col-span-2 bg-white dark:bg-gray-800 dark:text-gray-300 p-5 shadow-lg rounded-lg">
                <canvas class="text-white" ref="usersGraph"></canvas>
            </div>

            <div class="bg-white dark:bg-gray-800 dark:text-gray-300 p-5 shadow-lg rounded-lg">
                <canvas class="w-fit mx-auto text-white" ref="genderGraph"></canvas>
            </div>
        </div>
    </div>
</template>

