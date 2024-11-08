<template>
    <div
        v-if="showModal"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-80"
    >
        <div class="bg-white p-6 rounded-lg w-96">
            <h2 class="text-xl font-semibold mb-4">Sleep Time</h2>

            <div class="mb-4">
                <label
                    for="date"
                    class="block text-sm font-medium text-gray-700"
                    >Select Date</label
                >
                <VueDatePicker
                    v-model="selectedDate"
                    placeholder="Select date"
                    :input-class="'mt-1 block w-full  border rounded-lg'"
                >
                </VueDatePicker>
            </div>

            <!-- Time Picker -->
            <div class="mb-4">
                <label
                    for="time"
                    class="block text-sm font-medium text-gray-700"
                    >Select Sleep Time</label
                >
                <input
                    type="time"
                    v-model="sleepTime"
                    class="mt-1 block w-full p-2 border rounded-lg"
                />
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button
                    @click="submitSleepTime"
                    class="bg-green-800 text-white py-2 px-4 rounded-lg hover:bg-green-700"
                >
                    Submit
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

export default {
    props: {
        showModal: {
            type: Boolean,
            default: false,
        },
        closeModal: {
            type: Function,
            required: true,
        },
    },
};
</script>

<script setup>
import { ref } from "vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

const selectedDate = ref();
const sleepTime = ref("");

const submitSleepTime = () => {
    if (selectedDate.value && sleepTime.value) {
        // Here you can handle the logic to save the sleep data
        // For now, we are just logging the selected date and time
        console.log(
            `Date: ${selectedDate.value}, Sleep Time: ${sleepTime.value}`
        );

        // Close the modal after submitting
        closeModal();
    } else {
        alert("Please select both date and time.");
    }
};
</script>

<style scoped>
/* Style for the modal */
.bg-opacity-50 {
    background-color: rgba(0, 0, 0, 0.5);
}

.bg-white {
    background-color: #ffffff;
}

button:focus {
    outline: none;
}
</style>
