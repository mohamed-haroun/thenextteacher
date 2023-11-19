<script setup>
import {vMaska} from "maska"
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import {useGovernorateStore} from "@/Stores/UseGovernorates.js";
import {useCitiesStore} from "@/Stores/useCities.js";
import {ref, watch} from "vue";

const governorateStore = useGovernorateStore()
const cityStore = useCitiesStore()

const form = useForm({
    first_name: '',
    last_name: '',
    email: '',
    governorate: '',
    city: '',
    gender: 'male',
    birth_date: '',
    phone_number: '',
    type: 'teacher',
    password: '',
    password_confirmation: '',
});

let itemProps = (item) => {
    return {
        title: item.governorate_name_en,
        subtitle: item.governorate_name_ar,
    }
}

let citiesProps = (item) => {
    return {
        title: item.city_name_en,
        subtitle: item.city_name_ar,
    }
}

let govern = ref()

let cities = ref([])

watch(govern, (newVal) => {
    cities = cityStore.cities.filter((city) => {
        if (city.governorate_id === govern.value.id) {
             return city
        }
    })

})


const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register"/>
        <div class="flex flex-col justify-center items-center min-h-screen">

            <div>
                <Link href="/">
                    <ApplicationLogo class="w-16 h-16"/>
                </Link>
            </div>


            <div
                class="w-full sm:max-w-md lg:max-w-4xl mt-6 px-6 py-8 bg-white dark:bg-gray-800 dark:text-gray-200 shadow-md overflow-hidden sm:rounded-lg"
            >
                <form @submit.prevent="submit">

                    <div class="flex justify-between items-start gap-12">
                        <div class="basis-1/2">
                            <h4 class="mb-4 text-lg font-bold">Personal Info:</h4>
                            <div class="flex space-x-3">
                                <div>
                                    <InputLabel for="first_name" value="First Name"/>

                                    <TextInput
                                        id="first_name"
                                        type="text"
                                        class="mt-1 block w-full placeholder-slate-400 placeholder:text-sm"
                                        v-model="form.first_name"
                                        required
                                        autofocus
                                        placeholder="Jone"
                                        autocomplete="first_name"
                                    />

                                    <InputError class="mt-2" :message="form.errors.first_name"/>
                                </div>

                                <div>
                                    <InputLabel for="last_name" value="Last Name"/>

                                    <TextInput
                                        id="last_name"
                                        type="text"
                                        class="mt-1 block w-full placeholder-slate-400 placeholder:text-sm"
                                        v-model="form.last_name"
                                        required
                                        placeholder="Doe"
                                        autocomplete="last_name"
                                    />

                                    <InputError class="mt-2" :message="form.errors.last_name"/>
                                </div>
                            </div>


                            <div class="flex flex-col justify-between items-center mt-6">
                                <div class="w-full">
                                    <v-select
                                        class="bg-white text-black font-bold rounded-lg dark:bg-gray-800 dark:text-gray-300"
                                        placeholder="select a governorate"
                                        :items="governorateStore.governorates"
                                        :item-props="itemProps"
                                        label="Governorate"
                                        v-model="form.governorate"
                                        variant="outlined"
                                        @update:modelValue="govern = form.governorate"
                                    ></v-select>
                                    <InputError class="mt-2" :message="form.errors.governorate"/>
                                </div>

                                <div class="w-full">
                                    <v-select
                                        class="bg-white text-black dark:bg-gray-800 dark:text-gray-300 font-bold rounded-lg"
                                        :items="cities"
                                        :item-props="citiesProps"
                                        label="City"
                                        v-model="form.city"
                                        variant="outlined"
                                    ></v-select>
                                    <InputError class="mt-2" :message="form.errors.city"/>
                                </div>
                            </div>

                            <div >
                                <InputLabel for="birth_date" value="Birth Date"/>

                                <TextInput
                                    id="birth_date"
                                    type="date"
                                    class="mt-1 block w-full placeholder-slate-400 placeholder:text-sm"
                                    v-model="form.birth_date"
                                    required
                                    placeholder="e.g. Cairo"
                                    autocomplete="birth_date"
                                />

                                <InputError class="mt-2" :message="form.errors.birth_date"/>
                            </div>

                            <div class="mt-3 flex items-center justify-start gap-5">
                                <p class="text-gray-700 dark:text-gray-300 text-lg font-bold">Gender:</p>
                                <label for="male" class="text-gray-700 dark:text-gray-300 space-x-2 flex items-center">
                                    <input type="radio" name="gender" id="male" value="male" v-model="form.gender">
                                    <span>Male</span>
                                </label>

                                <label for="female" class="text-gray-700 dark:text-gray-300 space-x-2 flex items-center">
                                    <input type="radio" name="gender" id="female" value="female" v-model="form.gender">
                                    <span>Female</span>
                                </label>
                            </div>
                        </div>

                        <div class="basis-1/2">
                            <h4 class="mb-4 text-lg font-bold">User Info:</h4>

                            <div class="mt-4">
                                <InputLabel for="type" value="User Type"/>
                                <select v-model="form.type" name="type" id="type" class="w-full block border dark:text-gray-400 rounded mt-1 bg-white dark:bg-gray-900">
                                    <option value="teacher" class="text-gray-600 dark:text-gray-400 " selected="selected">Teacher</option>
                                    <option value="student" class="text-gray-600 dark:text-gray-400 ">Student</option>
                                    <option value="parent" class="text-gray-600 dark:text-gray-400 ">Parent</option>
                                </select>

                                <InputError class="mt-2" :message="form.errors.phone_number"/>
                            </div>

                            <div class="mt-4">
                                <InputLabel for="email" value="Email"/>

                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full placeholder-slate-400 placeholder:text-sm"
                                    v-model="form.email"
                                    required
                                    placeholder="jonedoe@example.com"
                                    autocomplete="username"
                                />

                                <InputError class="mt-2" :message="form.errors.email"/>
                            </div>

                            <div class="mt-4">
                                <InputLabel for="password" value="Password"/>

                                <TextInput
                                    id="password"
                                    type="password"
                                    class="mt-1 block w-full placeholder-slate-400 placeholder:text-sm"
                                    v-model="form.password"
                                    required
                                    placeholder="Password must be at least 8 characters"
                                    autocomplete="new-password"
                                />

                                <InputError class="mt-2" :message="form.errors.password"/>
                            </div>

                            <div class="mt-4">
                                <InputLabel for="password_confirmation" value="Confirm Password"/>

                                <TextInput
                                    id="password_confirmation"
                                    type="password"
                                    class="mt-1 block w-full placeholder-slate-400 placeholder:text-sm"
                                    v-model="form.password_confirmation"
                                    required
                                    placeholder="Repeat the exact password"
                                    autocomplete="new-password"
                                />

                                <InputError class="mt-2" :message="form.errors.password_confirmation"/>
                            </div>

                            <div class="mt-4">
                                <InputLabel for="phone_number" value="Phone Number"/>

                                <TextInput
                                    id="phone_number"
                                    type="text"
                                    class="mt-1 block w-full placeholder-slate-400 placeholder:text-sm"
                                    v-model="form.phone_number"
                                    v-maska
                                    data-maska="(###) ###-###-##" placeholder="(012) 345-678-91"
                                    required
                                    autocomplete="phone"
                                />

                                <InputError class="mt-2" :message="form.errors.phone_number"/>
                            </div>

                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <Link
                            :href="route('login')"
                            class="underline text-sm text-blue-600 dark:text-blue-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        >
                            Already registered?
                        </Link>

                        <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                       :disabled="form.processing">
                            Register
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>

        {{ cities.value }}

    </GuestLayout>
</template>
