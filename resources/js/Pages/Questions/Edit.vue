<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, router, useForm, usePage} from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import {useDark} from "@vueuse/core";
import {ref} from "vue";

defineOptions({
    layout: AuthenticatedLayout,
})

defineProps({
    question: Object,
    types: Array,
    lessons: Array,
})

const form = useForm({
    type: usePage().props.question.type.title,
    title: usePage().props.question.title,
    answer: usePage().props.question.answer?.title,
    rating: usePage().props.question.rating.toString(),
    lesson: usePage().props.question.lesson.title,
    image: usePage().props.question.lesson.image,
})

if (form.type === 'mcq') {
    form.answer = usePage().props.question.choices.map((choice) => {
        return choice.answer
    })
}

if (form.type === 'complete') {
    form.answer = usePage().props.question.completions.map((completion) => {
        return completion.answer
    })
}

if (form.type === 'correct') {
    form.answer = [usePage().props.question.correct.right, usePage().props.question.correct.wrong]
}

let itemProps = (item) => {
    return {
        title: item.title,
    }
}

const submit = (question) => {
    router.post(route('questions.update', {question: question}), {
        _method: 'put',
        data: form
    })
}

let type = ref(form.type)

</script>

<template>
    <Head title="Edit"/>

    <Header class="mx-3">
        <v-breadcrumbs class="text-sm">
            <template #default>
                <v-breadcrumbs-item>
                    <Link :href="route('questions.index')">Questions</Link>
                </v-breadcrumbs-item>
                <v-breadcrumbs-divider>
                    <v-icon icon="mdi-chevron-right"></v-icon>
                </v-breadcrumbs-divider>
                <v-breadcrumbs-item>
                    <Link :href="route('questions.show', [question])">{{ question.id }}</Link>
                </v-breadcrumbs-item>
                <v-breadcrumbs-divider>
                    <v-icon icon="mdi-chevron-right"></v-icon>
                </v-breadcrumbs-divider>
                <v-breadcrumbs-item disabled>
                    Update
                </v-breadcrumbs-item>
            </template>
        </v-breadcrumbs>
    </Header>

    <div class="w-full md:w-2/3 lg:w-1/2 mx-auto my-5 md:my-12 p-5 bg-white dark:bg-gray-700 shadow-lg rounded-lg">
        <v-form @submit.prevent="submit(question.id)">

            <div class="mt-3">
                <v-textarea
                    label="Question"
                    variant="outlined"
                    id="title"
                    type="text"
                    class="dark:text-gray-400 dark:bg-gray-800 font-bold rounded-lg"
                    v-model="form.title"
                    required
                    placeholder="Enter your question"
                    autocomplete="title"
                ></v-textarea>

                <InputError class="mt-2" :message="form.errors.title"/>
            </div>

            <div class="mt-3">
                <v-file-input
                    @input="form.image = $event.target.files[0]"
                    label="Question Image"
                    density="compact"
                    name="image"
                    class="dark:text-gray-200 dark:bg-gray-800 font-bold rounded-lg"
                ></v-file-input>
                <InputError class="mt-2" :message="form.errors.image"/>
            </div>

            <div class="mt-3">
                <v-select
                    class="dark:text-white dark:bg-gray-800 font-bold rounded-lg"
                    :closable-chips="true"
                    :chips="true"
                    label="Type"
                    :items="types"
                    :item-props="itemProps"
                    v-model="form.type"
                    variant="outlined"
                    @update:modelValue="type = form.type"
                ></v-select>
                <InputError class="mt-2" :message="form.errors.type"/>
            </div>

            <div v-if="type !== 'check' && type !== 'complete' && type !== 'mcq' && type !== 'correct'" class="mt-3">
                <v-textarea
                    label="Answer"
                    variant="outlined"
                    id="answer"
                    type="text"
                    class="dark:text-gray-400 dark:bg-gray-800 font-bold rounded-lg"
                    v-model="form.answer"
                    required
                    placeholder="Enter Answer"
                    autocomplete="answer"
                ></v-textarea>

                <InputError class="mt-2" :message="form.errors.answer"/>
            </div>

            <div v-else-if="type === 'complete'" class="mt-3">
                <v-combobox
                    v-model="form.answer"
                    clearable
                    chips
                    multiple
                    class="dark:text-gray-400 dark:bg-gray-800 font-bold rounded-lg"
                    label="completions"
                ></v-combobox>
            </div>

            <div v-else-if="type === 'mcq'" class="mt-3">
                <v-combobox
                    v-model="form.answer"
                    clearable
                    chips
                    multiple
                    class="dark:text-gray-400 dark:bg-gray-800 font-bold rounded-lg"
                    label="choices"
                ></v-combobox>
            </div>

            <div v-else-if="type === 'correct'" class="mt-3">
                <v-combobox
                    v-model="form.answer"
                    clearable
                    chips
                    multiple
                    class="dark:text-gray-400 dark:bg-gray-800 font-bold rounded-lg"
                    label="Correction"
                    hint="Correct first, then wrong"
                ></v-combobox>
            </div>

            <div v-else class="flex items-center justify-start gap-5">
                <p class="text-gray-700 dark:text-gray-300 text-lg font-bold">Answer:</p>
                <label for="male" class="text-gray-700 dark:text-gray-300 space-x-2 flex items-center">
                    <input type="radio" name="check" id="true" :value="true" v-model="form.answer" class="border border-gray-500">
                    <span>True</span>
                </label>

                <label for="female" class="text-gray-700 dark:text-gray-300 space-x-2 flex items-center">
                    <input type="radio" name="check" id="false" :value="false" v-model="form.answer" class="border border-gray-500">
                    <span>False</span>
                </label>
            </div>

            <div class="mt-3" v-if="type === 'generic' || type === 'mcq'">
                <v-file-input
                    multiple
                    @input="form.answerImages = $event.target.files"
                    label="Answer Images"
                    density="compact"
                    name="answer_images"
                    class="dark:text-gray-400 dark:bg-gray-800 font-bold rounded-lg"
                ></v-file-input>
                <InputError class="mt-2" :message="form.errors.answerImages"/>
            </div>

            <div>
                <InputLabel for="rating" value="Rating"/>

                <TextInput
                    id="rating"
                    type="number"
                    min="1"
                    max="5"
                    class="mt-1 block w-full placeholder-slate-400 placeholder:text-sm"
                    placeholder="Enter the hardness of the question"
                    v-model="form.rating"
                    required
                />

                <InputError class="mt-2" :message="form.errors.rating"/>
            </div>

            <div class="mt-3">
                <v-select
                    class="dark:text-white dark:bg-gray-800 font-bold rounded-lg"
                    :closable-chips="true"
                    :chips="true"
                    label="Lesson"
                    v-model="form.lesson"
                    variant="outlined"
                ></v-select>
                <InputError class="mt-2" :message="form.errors.lesson"/>
            </div>

            <div class="mt-3">
                <button
                    type="submit"
                    class="px-3 py-2 text-white bg-blue-500 dark:bg-blue-500/80 rounded w-full"
                >Update
                </button>
            </div>
        </v-form>
    </div>
</template>
