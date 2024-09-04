<template>
    <main>
        <div
            v-show="$page.props.message"
            class="bg-green-300 z-50 fixed top-0 right-0 left-0 ps-16 py-3 font-medium"
        >
            <svg
                class="flex-shrink-0 inline w-4 h-4 me-3"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                viewBox="0 0 20 20"
            >
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"
                />
            </svg>
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
                    <span
                        >{{ $page.props.auth?.user?.name }} |
                        {{ $page.props.auth?.user?.role }}</span
                    >
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
