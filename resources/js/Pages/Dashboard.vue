<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, usePage} from '@inertiajs/vue3';
import {computed} from "vue";

defineProps({
    users: Array,
    students: Number,
    teachers: Number
})

const studentsPercentage = computed(() => {
    return Math.floor((usePage().props.students / usePage().props.users) * 100)
});

const teachersPercentage = computed(() => {
    return Math.floor((usePage().props.teachers / usePage().props.users) * 100)
});

const page = usePage()

const user = computed(() => page.props.auth.user)

const getRoles = () => {
    return user.value.roles.map(role => {
        return role.name
    })
}

</script>

<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>

        <div class="m-12 dark:text-gray-300">
            <pre>
                {{ getRoles() }}
            </pre>
        </div>
    </AuthenticatedLayout>
</template>
