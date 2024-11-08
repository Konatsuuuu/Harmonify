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
                            :selectedDate="date"
                            @date-selected="setDate"
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
                            :selectedDate="date"
                            @date-selected="setDate"
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
            isDatepickerVisible: "start",
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
            date: "", // Selected date from Datepicker
            startSleep: "", // Start time
            endSleep: "", // End time
            sleepDuration: "", // Duration of sleep (calculated)
            userId: null, // Firebase user ID
        };
    },

    methods: {
        async submitSleepForm() {
            // Calculate the sleep duration in hours
            const startTime = new Date(`${this.date} ${this.startSleep}`);
            const endTime = new Date(`${this.date} ${this.endSleep}`);

            if (endTime < startTime) {
                // Handle overnight sleep by adjusting the end time to the next day
                endTime.setDate(endTime.getDate() + 1);
            }

            this.sleepDuration = (endTime - startTime) / 3600000; // Duration in hours

            console.log("Sleep Start Date:", this.date);
            console.log("Start Time:", this.startSleep);
            console.log("End Time:", this.endSleep);
            console.log("Sleep Duration:", this.sleepDuration);

            // Save the sleep data to Firestore
            if (this.userId) {
                try {
                    const sleepDocRef = doc(
                        db,
                        "users",
                        this.userId,
                        "sleep", // Subcollection 'sleep' under the user
                        `${this.date}` // Use the selected date as the document ID
                    );
                    await setDoc(sleepDocRef, {
                        date: this.date,
                        startSleep: this.startSleep,
                        endSleep: this.endSleep,
                        sleepDuration: this.sleepDuration,
                        userId: this.userId,
                    });
                    console.log("Sleep data saved successfully!");

                    this.showModal = false;
                    this.fetchSleepData(); // Refresh the sleep data for the graph
                } catch (error) {
                    console.error("Error saving sleep data:", error);
                }
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

                // Update chart data with fetched sleep durations
                const weekData = ["S", "M", "T", "W", "T", "F", "S"];
                const sleepDurations = weekData.map((day) => {
                    const dayData = sleepData.find(
                        (sleep) => sleep.date === day
                    );
                    return dayData ? dayData.sleepDuration : 0;
                });

                // Update chart with sleep data
                this.chartData.datasets[0].data = sleepDurations;
            } catch (error) {
                console.error("Error fetching sleep data:", error);
            }
        },

        setDate(date) {
            this.date = date; // Set the selected date from the Datepicker
        },

        showTimePicker(type) {
            this.isTimePickerOpen = type; // Show the timepicker for 'start' or 'end'
        },

        handleStartTimeSelected(time) {
            this.startSleep = time;
            this.isTimePickerOpen = null; // Close the timepicker after selecting a time
        },

        handleEndTimeSelected(time) {
            this.endSleep = time;
            this.isTimePickerOpen = null; // Close the timepicker after selecting a time
        },

        handleCancelSelection() {
            this.isTimePickerOpen = null; // Close the timepicker without saving the time
        },
    },

    mounted() {
        onAuthStateChanged(auth, (user) => {
            if (user) {
                this.userId = user.uid;
                console.log("User ID:", this.userId);
                this.fetchSleepData(); // Fetch existing sleep data for the graph
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
