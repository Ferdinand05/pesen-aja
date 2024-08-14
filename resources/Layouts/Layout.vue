<template>
    <Head :title="title"></Head>
    <main>
        <header>
            <Navbar></Navbar>
        </header>
        <article class="px-3 md:px-10 mt-5">
            <slot />
        </article>
    </main>
</template>

<script setup>
import { Head } from "@inertiajs/vue3";
import Navbar from "../Components/Navbar.vue";
defineProps({ title: String });
</script>
