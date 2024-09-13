<template>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div
            class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0"
        >
            <a
                href="/"
                class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white"
            >
                <h2 class="text-green-600">PesenAja</h2>
            </a>
            <div
                class="w-full p-6 bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md dark:bg-gray-800 dark:border-gray-700 sm:p-8"
            >
                <h2
                    class="mb-1 text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
                >
                    Change Password
                </h2>
                <form
                    class="mt-4 space-y-4 lg:mt-5 md:space-y-5"
                    action="#"
                    method="post"
                    @submit.prevent="updatePassword()"
                >
                    <div>
                        <label
                            for="password"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >New Password</label
                        >
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="••••••••"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-600 focus:border-green-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            v-model="formUpdatePassword.password"
                        />
                        <small class="text-red-500">{{
                            formUpdatePassword.errors.password
                        }}</small>
                    </div>
                    <div>
                        <label
                            for="confirm-password"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Confirm password</label
                        >
                        <input
                            type="password"
                            name="confirm-password"
                            id="confirm-password"
                            placeholder="••••••••"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-600 focus:border-green-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            v-model="formUpdatePassword.password_confirmation"
                        />
                        <small class="text-red-500">{{
                            formUpdatePassword.errors.password_confirmation
                        }}</small>
                    </div>

                    <button
                        type="submit"
                        class="w-full text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                    >
                        Change password
                    </button>
                    <div class="text-red-500">
                        {{ formUpdatePassword.errors.token }}
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>

<script setup>
import { usePage, useForm } from "@inertiajs/vue3";
const page = usePage({});
const formUpdatePassword = useForm({
    password: null,
    password_confirmation: null,
    token: page.props.token,
});

function updatePassword() {
    formUpdatePassword.post(route("update.password"), {
        onError: () => {
            formUpdatePassword.password_confirmation = null;
        },
    });
}
</script>
