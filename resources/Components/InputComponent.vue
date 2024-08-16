<template>
    <div class="mb-3">
        <label
            :for="id"
            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
            >{{ label }}</label
        >
        <input
            :type="type"
            :id="id"
            :class="
                error
                    ? 'bg-gray-50 border border-red-500 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'
                    : 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'
            "
            :placeholder="placeholder"
            v-model="model"
        />
        <div class="text-red-600">{{ error }}</div>
    </div>
</template>

<script setup>
defineProps({
    type: {
        type: String,
        default: "text",
    },
    id: String,
    label: String,
    placeholder: String,
    error: String,
});

const model = defineModel({
    type: null,
    required: true,
});
</script>
