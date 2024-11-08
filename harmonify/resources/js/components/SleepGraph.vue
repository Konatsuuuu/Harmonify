<template>
    <div
        class="backgroundImg flex items-center justify-center min-h-screen bg-cover overflow-hidden"
    >
        <div
            class="glassmorphism w-[93%] h-[88vh] p-5 flex flex-col text-[#b28666]"
        >
            <div class="flex items-center mb-3 ml-4 space-x-3 text-[#b28666]">
                <BackButton />
                <p class="text-3xl font-bold">Sleep Graph</p>
            </div>
            <div class="flex w-full h-[76vh]">
                <div class="chart-container">
                    <Bar
                        :data="chartData"
                        :options="chartOptions"
                        class="w-30% h-12 pl-10 pt-5"
                    />
                </div>

                <div class="w-1/2">
                    <button
                        @click="showModal = true"
                        class="text-white bg-[#B28666] hover:bg-[#8c6950] focus:outline-none font-medium text-xl rounded-full px-10 py-2.5 text-center me-2 mb-2 dark:bg-[#B28666] dark:hover:bg-[#8c6950]"
                    >
                        + Add Sleep Time
                    </button>

                    <div class="py-5">
                        <label for="date" class="block text-sm font-medium">
                            Select Date
                        </label>
                        <Datepicker
                            v-if="isDatepickerVisible === 'start'"
                            :isOpen="isDatepickerVisible === 'start'"
                            :selected-date="selectedOutsideDate"
                            v-model="selectedOutsideDate"
                            @date-selected="setDateOutside"
                            class="mt-2"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div
        v-if="showModal"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
        <div class="bg-white p-6 rounded-2xl w-[60%] h-[60%]">
            <h2 class="text-xl font-extrabold text-[#b28666] mb-4">
                Enter Sleep Details
            </h2>

            <form @submit.prevent="submitSleepForm">
                <div class="flex space-x-6">
                    <div class="w-[60%]">
                        <label for="date" class="block text-sm font-medium">
                            Select Date
                        </label>
                        <Datepicker
                            v-if="isDatepickerVisible === 'start'"
                            :isOpen="isDatepickerVisible === 'start'"
                            :selected-date="selectedModalDate"
                            v-model="selectedModalDate"
                            @date-selected="setDateModal"
                            class="mt-2"
                        />
                    </div>

                    <!-- Time Pickers (Start Time and End Time) -->
                    <div class="w-1/2 py-10">
                        <div class="mb-4">
                            <label
                                for="startSleep"
                                class="block text-sm font-medium"
                                >Start Time</label
                            >
                            <div class="relative">
                                <input
                                    v-model="startSleep"
                                    type="text"
                                    id="startSleep"
                                    class="w-full p-2 border border-gray-300 rounded mt-1"
                                    @focus="showTimePicker('start')"
                                    placeholder="Select Start Time"
                                />
                                <Timepicker
                                    v-if="isTimePickerOpen === 'start'"
                                    :isOpen="isTimePickerOpen === 'start'"
                                    :initialTime="startSleep"
                                    @time-selected="handleStartTimeSelected"
                                    @cancel-selection="handleCancelSelection"
                                />
                            </div>
                        </div>

                        <div class="mb-4 pt-10">
                            <label
                                for="endSleep"
                                class="block text-sm font-medium"
                                >End Time</label
                            >
                            <div class="relative">
                                <input
                                    v-model="endSleep"
                                    type="text"
                                    id="endSleep"
                                    class="w-full p-2 border border-gray-300 rounded mt-1"
                                    @focus="showTimePicker('end')"
                                    placeholder="Select End Time"
                                />
                                <Timepicker
                                    v-if="isTimePickerOpen === 'end'"
                                    :isOpen="isTimePickerOpen === 'end'"
                                    :initialTime="endSleep"
                                    @time-selected="handleEndTimeSelected"
                                    @cancel-selection="handleCancelSelection"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-4 pt-4">
                    <button
                        type="button"
                        @click="showModal = false"
                        class="text-red-500 pr-[20%]"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="bg-[#B28666] text-white px-4 py-2 rounded-full hover:bg-[#8c6950]"
                    >
                        Add Sleep
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { db, auth, setDoc, collection, getDocs, doc } from "@/firebaseConfig"; // Firebase imports
import { onAuthStateChanged } from "firebase/auth"; // Firebase auth listener
import Timepicker from "./Timepicker.vue"; // Timepicker component
import Datepicker from "./Datepicker.vue"; // Datepicker component
import { ref } from "vue";
import { Bar } from "vue-chartjs"; // Chart.js component
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
} from "chart.js"; // Chart.js setup
import BackButton from "./BackButton.vue"; // BackButton component
import { VueElement } from "vue";

// Registering chart.js components globally
ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
);

export default {
    components: {
        BackButton,
        Bar,
        Datepicker,
        Timepicker,
    },

    data() {
        return {
            showModal: false,
            isDatepickerVisible: "start", // This controls the visibility of the date picker
            isTimePickerOpen: null,
            chartData: {
                labels: ["S", "M", "T", "W", "T", "F", "S"], // Placeholder for day labels
                datasets: [
                    {
                        label: "Sleep Duration (hrs)",
                        data: [6, 7, 5, 8, 6, 7, 9], // Placeholder data for sleep durations
                        backgroundColor: "#b28666",
                        borderColor: "#b28666",
                        borderWidth: 0,
                        borderRadius: 10,
                    },
                ],
            },
            chartOptions: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: "Sleep Duration Per Day (Week)",
                    },
                },
            },
            selectedOutsideDate: "", // Selected date from Datepicker (outside modal)
            selectedModalDate: "", // Selected date inside the modal
            startSleep: "", // Start time
            endSleep: "", // End time
            sleepDuration: "", // Duration of sleep (calculated)
            userId: null, // Firebase user ID
        };
    },

    methods: {
        async submitSleepForm() {
            const startTime = new Date(
                `${this.selectedModalDate} ${this.startSleep}`
            );
            const endTime = new Date(
                `${this.selectedModalDate} ${this.endSleep}`
            );

            if (endTime < startTime) {
                endTime.setDate(endTime.getDate() + 1); // Handle overnight sleep
            }

            this.sleepDuration = (endTime - startTime) / 3600000; // Duration in hours

            if (this.userId) {
                const sleepDocRef = doc(
                    db,
                    "users",
                    this.userId,
                    "sleep",
                    `${this.selectedModalDate}`
                );
                await setDoc(sleepDocRef, {
                    selectedDate: this.selectedModalDate,
                    startSleep: this.startSleep,
                    endSleep: this.endSleep,
                    sleepDuration: this.sleepDuration,
                    userId: this.userId,
                });

                this.showModal = false; // Close the modal
                this.fetchSleepData(); // Refresh the chart with updated data
            }
        },

        async fetchSleepData() {
            if (!this.userId) {
                console.error("User ID not available");
                return;
            }
            try {
                const userDocRef = collection(
                    db,
                    "users",
                    this.userId,
                    "sleep"
                );
                const sleepSnapshot = await getDocs(userDocRef);
                const sleepData = sleepSnapshot.docs.map((doc) => doc.data());

                const weekData = ["S", "M", "T", "W", "T", "F", "S"];
                const sleepDurations = weekData.map((day) => {
                    const dayData = sleepData.find(
                        (sleep) => sleep.date === day
                    );
                    return dayData ? dayData.sleepDuration : 0;
                });

                this.chartData.datasets[0].data = sleepDurations;
            } catch (error) {
                console.error("Error fetching sleep data:", error);
            }
        },

        setDateOutside(date) {
            this.selectedOutsideDate = date; // Update the outside Datepicker date
            this.updateChartData();
        },

        setDateModal(date) {
            this.selectedModalDate = date; // Update the modal Datepicker date
            this.updateChartData();
        },

        updateChartData() {
            // This method updates the chart immediately after the date is selected
            console.log(
                "Updated selected date:",
                this.selectedModalDate || this.selectedOutsideDate
            );
            // Optionally, you can fetch or process new data for the chart based on the selected date
        },

        showTimePicker(type) {
            this.isTimePickerOpen = type;
        },

        handleStartTimeSelected(time) {
            this.startSleep = time;
            this.isTimePickerOpen = null;
        },

        handleEndTimeSelected(time) {
            this.endSleep = time;
            this.isTimePickerOpen = null;
        },

        handleCancelSelection() {
            this.isTimePickerOpen = null;
        },
    },

    mounted() {
        onAuthStateChanged(auth, (user) => {
            if (user) {
                this.userId = user.uid;
                this.fetchSleepData();
            } else {
                console.warn("No user is signed in.");
            }
        });
    },
};
</script>

<style scoped>
.chart-container {
    width: 100%;
    height: 70%;
}
</style>
