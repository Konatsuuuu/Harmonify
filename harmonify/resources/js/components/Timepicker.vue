<template>
    <div
        v-if="isOpen"
        class="absolute z-10 bg-white border border-gray-300 rounded-md shadow-lg mt-2 w-72 max-h-96 overflow-hidden"
    >
        <div class="flex justify-between items-center p-3">
            <div class="text-lg font-semibold">Select Time</div>
        </div>

        <div class="overflow-y-auto max-h-60 p-3">
            <div class="flex justify-between items-center mb-4 px-10">
                <div class="flex flex-col items-center">
                    <label for="hours" class="text-sm text-gray-600"
                        >Hour</label
                    >
                    <select
                        id="hours"
                        v-model="selectedHour"
                        class="border w-20 border-gray-500 rounded-md p-1 text-sm"
                    >
                        <option v-for="n in 24" :key="n" :value="n">
                            {{ n < 10 ? "0" + n : n }}
                        </option>
                    </select>
                </div>

                <div class="flex flex-col items-center">
                    <label for="minutes" class="text-sm text-gray-600"
                        >Minutes</label
                    >
                    <select
                        id="minutes"
                        v-model="selectedMinute"
                        class="border w-20 border-gray-300 rounded-md p-1 text-sm"
                    >
                        <option
                            v-for="n in 60"
                            :key="n"
                            :value="n < 10 ? '0' + n : n"
                        >
                            {{ n < 10 ? "0" + n : n }}
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between items-center p-3">
            <!-- Cancel Button -->
            <button
                @click="cancelSelection"
                class="w-20 h-10 text-sm font-semibold text-gray-600 hover:underline"
            >
                Cancel
            </button>

            <!-- OK Button -->
            <button
                @click="confirmSelection"
                class="w-20 h-10 text-white bg-[#B28666] hover:bg-[#8c6950] focus:outline-none font-medium text-sm rounded-full text-center me-2 mb-2 dark:bg-[#B28666] dark:hover:bg-[#8c6950] hover:underline"
            >
                Done
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        isOpen: Boolean,
        initialTime: String, // Optional: initial time to prefill the fields
    },
    data() {
        const now = new Date();
        // Initialize to 00:00 if no initial time is provided
        const initialHour = this.initialTime
            ? new Date(this.initialTime).getHours()
            : 0; // Default to 00 (midnight) if no initial time
        const initialMinute = this.initialTime
            ? new Date(this.initialTime).getMinutes()
            : 0; // Default to 00 minutes if no initial time

        return {
            selectedHour: initialHour,
            selectedMinute:
                initialMinute < 10 ? "0" + initialMinute : initialMinute, // Ensure two-digit format for minutes
        };
    },
    methods: {
        // Confirm the selection and emit it to the parent component
        confirmSelection() {
            const timeString = `${this.selectedHour}:${this.selectedMinute}`;
            this.$emit("time-selected", timeString);
        },

        // Cancel the selection and close the time picker
        cancelSelection() {
            this.$emit("cancel-selection");
        },
    },
};
</script>
