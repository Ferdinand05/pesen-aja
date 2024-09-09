<template>
    <fwb-button
        @click="showModal"
        :size="$page.url == '/dashboard/payments' ? 'xs' : 'sm'"
    >
        {{ buttonType }}
    </fwb-button>

    <fwb-modal v-if="isShowModal" @close="closeModal">
        <template #header>
            <slot name="header"> </slot>
        </template>
        <template #body>
            <slot name="body"> body </slot>
        </template>
        <template #footer>
            <slot name="footer">
                <div class="flex justify-between">
                    <fwb-button @click="closeModal" color="alternative">
                        Cancel
                    </fwb-button>
                    <!-- <fwb-button @click="closeModal" color="green">
                        I accept
                    </fwb-button> -->
                </div>
            </slot>
        </template>
    </fwb-modal>
</template>

<script setup>
import { ref } from "vue";
import { FwbButton, FwbModal } from "flowbite-vue";

const isShowModal = ref(false);

function closeModal() {
    isShowModal.value = false;
}
function showModal() {
    isShowModal.value = true;
}
defineProps({
    buttonType: {
        type: String,
        default: "Create",
    },
});
defineExpose({ closeModal, showModal });
</script>
