<template>
    <main>
        <div
            v-show="$page.props.message"
            class="bg-green-500 z-50 fixed top-0 right-0 left-0 ps-16 py-3 font-medium"
        >
            {{ $page.props.message }} !!!
        </div>
        <header>
            <Head :title="title"></Head>
            <SidebarDashboard></SidebarDashboard>
        </header>
        <article class="sm:ml-72 sm:mt-3 ml-3 mt-5 me-7">
            <div class="flex justify-between mb-5">
                <h2>{{ subtitle }}</h2>
                <div class="mr-5 md:mr-5">
                    <span>Ferdinand | Role</span>
                </div>
            </div>
            <slot> </slot>
        </article>
    </main>
</template>
<script setup>
import { Head } from "@inertiajs/vue3";
import SidebarDashboard from "../Components/SidebarDashboard.vue";
defineProps({ title: String, subtitle: String });
</script>
