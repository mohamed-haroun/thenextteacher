<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, Link, useForm, usePage} from "@inertiajs/vue3";
import Header from "@/Components/Header.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import {ref, watch} from "vue";


defineOptions({
    layout: AuthenticatedLayout,
})

defineProps({
    types: Array,
    lesson: Object
})

const form = useForm({
    type:   '',
    title:  '',
    answer: null,
    rating: "3",
    lesson: usePage().props.lesson.title,
    image: '',
    answerImages: []
})

let itemProps = (item) => {
    return {
        title: item.title,
    }
}

const submit = () => {
    form.post(route('questions.store'))
    form.reset()
}

let type = ref('')

let snackbar = ref(true)
</script>

<template>
    <Head title="Create Question"/>

    <Header class="mx-3">
        <v-breadcrumbs class="text-sm" active-color="error">
            <template v-slot:divider>
                <v-icon icon="mdi-chevron-right"></v-icon>
            </template>

            <template #default>
                <v-breadcrumbs-item>
                    <Link :href="route('lessons.index')">Lessons</Link>
                </v-breadcrumbs-item>
                <v-breadcrumbs-divider>
                    <v-icon icon="mdi-chevron-right"></v-icon>
                </v-breadcrumbs-divider>
                <v-breadcrumbs-item>
                    <Link :href="route('lessons.show', [lesson])">{{ lesson.title }}</Link>
                </v-breadcrumbs-item>
                <v-breadcrumbs-divider>
                    <v-icon icon="mdi-chevron-right"></v-icon>
                </v-breadcrumbs-divider>
                <v-breadcrumbs-item disabled>
                    Create Question
                </v-breadcrumbs-item>
            </template>
        </v-breadcrumbs>

        <div v-if="$page.props.flash.message">
            <v-snackbar
                v-model="snackbar"
                location="top"
                color="success"
                variant="tonal"
            >
                <template #default>
                    <p class="font-bold ">
                        <v-icon icon="mdi-check" />
                        {{ $page.props.flash.message }}
                    </p>
                </template>
            </v-snackbar>
        </div>
    </Header>

    <div class="w-full md:w-2/3 lg:w-1/2 mx-auto my-5 md:my-12 p-5 bg-white dark:bg-gray-800 shadow-lg rounded-lg">
        <v-form @submit.prevent="submit">

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
                    class="dark:text-gray-400 dark:bg-gray-800 font-bold rounded-lg"
                ></v-file-input>
                <InputError class="mt-2" :message="form.errors.image"/>
            </div>

            <div class="mt-6">
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
                    hint="Start with the correct choice"
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

            <div class="my-3">
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
                    :disabled="true"
                ></v-select>
                <InputError class="mt-2" :message="form.errors.lesson"/>
            </div>

            <div class="mt-3 flex gap-5">
                <button
                    type="submit"
                    class="px-3 py-2 text-white bg-blue-500 dark:bg-blue-500/80 rounded w-full"
                >Create
                </button>
            </div>
        </v-form>
    </div>

</template>
