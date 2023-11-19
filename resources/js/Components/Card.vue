<script setup>
defineProps({
    title: String,
    count: Number
})
</script>

<template>
    <div
        class="flex flex-col sm:flex-row justify-evenly rounded-lg p-5 gap-5 items-center border-gray-200 bg-white dark:bg-gray-800 bg-clip-border shadow-lg">
        <div class="rounded-full dark:bg-gray-700">
            <span class="flex text-2xl items-center text-gray-500 dark:text-white">
                <slot name="icon"/>
            </span>
        </div>
        <div class="flex w-auto flex-col justify-center items-center">
            <h4 class="w-fit text-xl text-gray-400 dark:text-gray-300 border-b mb-3">{{ title }}</h4>
            <p class="w-fit text-xl font-bold text-gray-600 dark:text-gray-300">{{ count }}</p>
        </div>
    </div>

</template>
