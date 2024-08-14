<template>
    <nav class="bg-primary md:px-5 border-gray-200 dark:bg-gray-900">
        <div
            class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4"
        >
            <Link
                href="https://flowbite.com/"
                class="flex items-center space-x-3 rtl:space-x-reverse"
            >
                <span
                    class="self-center text-white text-2xl md:text-3xl font-semibold whitespace-nowrap dark:text-white"
                    >PesenAja</span
                >
            </Link>
            <button
                data-collapse-toggle="navbar-default"
                type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                aria-controls="navbar-default"
                aria-expanded="false"
            >
                <span class="sr-only">Open main menu</span>
                <svg
                    class="w-5 h-5"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 17 14"
                >
                    <path
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15"
                    />
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto" id="navbar-default">
                <ul
                    class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:bg-transparent md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700"
                >
                    <li>
                        <Link
                            :href="route('home')"
                            class="block py-2 px-3 rounded hover:text-gray-100 md:bg-transparent md:p-0 dark:text-white md:dark:text-blue-500"
                            aria-current="page"
                            >Order</Link
                        >
                    </li>
                    <li>
                        <Link
                            :href="route('dashboard')"
                            class="block py-2 px-3 text-gray-900 rounded hover:text-gray-100 md:hover:bg-transparent md:border-0 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent"
                            >Dashboard</Link
                        >
                    </li>
                    <li>
                        <Link
                            href=""
                            class="block py-2 px-3 text-gray-900 rounded hover:text-gray-100 md:hover:bg-transparent md:border-0 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent"
                            >Login</Link
                        >
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref } from "vue";
</script>
