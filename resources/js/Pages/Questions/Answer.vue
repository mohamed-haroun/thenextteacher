<script setup>
import {usePage} from "@inertiajs/vue3";
import {ref} from "vue";

let props = defineProps({
    type: String,
    answer: String,
    form: Object
})

const answer = ref(props.answer)

let jsonAnswer = JSON.parse(answer.value)

</script>

<template>
    <div>
        <v-combobox
            multiple
            persistent-hint
            small-chips
            v-model="form.correctedAnswer"
            hide-selected
            :closable-chips="true"
            :chips="true"
            label="Choices"
            id="choices"
            :items="jsonAnswer.choices"
        >
        </v-combobox>
        <v-text-field label="Correct Answer" id="correct" v-model="form.correct"/>
    </div>
</template>
