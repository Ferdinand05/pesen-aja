<template>
    <div>
        <FwbButton id="pay-button" @click="pay">Pay!</FwbButton>
        <pre><div id="result-json">JSON result will appear here after payment:<br></div></pre>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { usePage, useForm } from "@inertiajs/vue3";
import { FwbButton } from "flowbite-vue";
const page = usePage({});

// Load Snap.js script dynamically
const loadSnapScript = () => {
    const script = document.createElement("script");
    script.src = `https://app.sandbox.midtrans.com/snap/snap.js`;
    script.setAttribute("data-client-key", page.props.payment.clientKey);
    document.body.appendChild(script);
};

// Function to handle payment process
const pay = () => {
    loadSnapScript();
    window.snap.pay(page.props.payment.snapToken, {
        onSuccess: function (result) {
            document.getElementById("result-json").innerHTML += JSON.stringify(
                result,
                null,
                2
            );
        },
        onPending: function (result) {
            document.getElementById("result-json").innerHTML += JSON.stringify(
                result,
                null,
                2
            );
        },
        onError: function (result) {
            document.getElementById("result-json").innerHTML += JSON.stringify(
                result,
                null,
                2
            );
        },
    });
};
</script>
