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
                        <option v-for="n in 24" :key="n - 1" :value="n - 1">
                            {{ formatNumber(n - 1) }}
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
                        <option v-for="n in 60" :key="n" :value="n - 1">
                            {{ formatNumber(n - 1) }}
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex justify-between items-center p-3">
            <button
                @click="cancelSelection"
                class="w-20 h-10 text-sm font-semibold text-gray-600 hover:underline"
            >
                Cancel
            </button>

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
        initialTime: String,
    },
    data() {
        const now = new Date();
        let initialHour, initialMinute, selectedMinute;

        if (this.initialTime) {
            initialHour = new Date(this.initialTime).getHours();
        } else {
            initialHour = 0;
        }

        if (this.initialTime) {
            initialHour = new Date(this.initialTime).getMinutes();
        } else {
            initialHour = 0;
        }

        if (initialMinute < 10) {
            selectedMinute = "0" + initialMinute;
        } else {
            selectedMinute = initialMinute;
        }

        return {
            selectedHour: initialHour,
            selectedMinute: selectedMinute,
        };
    },
    methods: {
        formatNumber(n) {
            if (n < 10) {
                return `0${n}`;
            } else {
                return n;
            }
        },

        confirmSelection() {
            let formattedMinute;
            if (this.selectedMinute < 10) {
                formattedMinute = "0" + this.selectedMinute;
            } else {
                formattedMinute = this.selectedMinute;
            }

            let formattedHour;
            if (this.selectedHour < 10) {
                formattedHour = "0" + this.selectedHour;
            } else {
                formattedHour = this.selectedHour;
            }

            const timeString = `${formattedHour}:${formattedMinute}`;
            this.$emit("time-selected", timeString);
        },

        cancelSelection() {
            this.$emit("cancel-selection");
        },
    },
};
</script>
