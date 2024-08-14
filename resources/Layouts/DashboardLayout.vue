<template>
    <main>
        <header>
            <Head :title="title"></Head>
            <SidebarDashboard></SidebarDashboard>
        </header>
        <article class="sm:ml-72 sm:mt-3 ml-3 mt-3">
            <h2>{{ subtitle }}</h2>
            <slot> </slot>
        </article>
    </main>
</template>
<script setup>
import { Head } from "@inertiajs/vue3";
import SidebarDashboard from "../Components/SidebarDashboard.vue";
defineProps({ title: String, subtitle: String });
</script>
