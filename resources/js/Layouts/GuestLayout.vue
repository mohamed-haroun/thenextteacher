<script setup>
import NavBar from "@/Components/NavBar.vue";
import Footer from "@/Components/Footer.vue";
import {useDark, useToggle} from "@vueuse/core";

const isDark = useDark();
const toggleDark = useToggle(isDark);
</script>

<template>
    <div class="bg-dots-darker min-h-screen dark:bg-dots-lighter bg-gray-100 dark:bg-gray-900">

        <header v-if="!(
            $page.url.startsWith('/login') ||
            $page.url.startsWith('/register') ||
            $page.url.startsWith('/forgot-password') ||
            $page.url.startsWith('/verify-email')
            )"
                class="z-50 sticky top-1 sm:top-2 md:top-3 mx-2 sm:mx-3 md:mx-4 shadow rounded-full">
            <NavBar />
        </header>

        <main>
            <slot />
        </main>
        <Footer
            v-if="!(
            $page.url.startsWith('/login') ||
            $page.url.startsWith('/register') ||
            $page.url.startsWith('/forgot-password') ||
            $page.url.startsWith('/verify-email')
            )"
        />
    </div>
</template>

<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>
