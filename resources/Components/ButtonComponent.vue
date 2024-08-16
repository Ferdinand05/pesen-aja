<template>
    <div>
        <button
            type="button"
            class="text-white bg-green-600 hover:bg-green-800 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-full text-sm px-5 py-2 text-center me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
        >
            <slot></slot>
        </button>
    </div>
</template>

<script setup>
defineProps({
    type: {
        type: String,
        default: "button",
    },
});
</script>
