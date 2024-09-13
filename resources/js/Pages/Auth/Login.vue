<template>
    <Layout title="Login">
        <section class="bg-gray-50 dark:bg-gray-900">
            <div
                class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0"
            >
                <a
                    href="#"
                    class="flex hover:text-green-600 items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white"
                >
                    <span
                        class="text-primary hover:text-green-600 transition-all text-4xl"
                        >PesenAja</span
                    >
                </a>
                <div
                    class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700"
                >
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1
                            class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
                        >
                            Sign in to your account
                        </h1>
                        <form
                            class="space-y-4 md:space-y-6"
                            method="post"
                            @submit.prevent="login()"
                        >
                            <div>
                                <label
                                    for="email"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Your email</label
                                >
                                <input
                                    type="email"
                                    v-model="form.email"
                                    name="email"
                                    id="email"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-green-600 focus:border-green-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="name@company.com"
                                />
                                <small class="text-red-600">
                                    {{ form.errors.email }}
                                </small>
                            </div>
                            <div>
                                <label
                                    for="password"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                    >Password</label
                                >
                                <input
                                    type="password"
                                    name="password"
                                    v-model="form.password"
                                    id="password"
                                    placeholder="••••••••"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-green-600 focus:border-green-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                />
                                <small class="text-red-600">{{
                                    form.errors.password
                                }}</small>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input
                                            id="remember"
                                            aria-describedby="remember"
                                            v-model="form.remember_me"
                                            type="checkbox"
                                            class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-green-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-green-600 dark:ring-offset-gray-800"
                                        />
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label
                                            for="remember"
                                            class="text-gray-500 dark:text-gray-300"
                                            >Remember me</label
                                        >
                                    </div>
                                </div>
                                <Link
                                    :href="route('forgot.password')"
                                    class="text-sm font-medium text-green-600 hover:underline dark:text-green-500"
                                    >Forgot password?</Link
                                >
                            </div>
                            <button
                                type="submit"
                                class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                            >
                                Sign in
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </Layout>
</template>

<script setup>
import Layout from "../../../Layouts/Layout.vue";
import { useForm } from "@inertiajs/vue3";
const form = useForm({
    email: null,
    password: null,
    remember_me: false,
});

function login() {
    form.post(route("login.store"), {
        preserveScroll: true,
    });
}
</script>
