<template>
    <div class="backgroundImg flex items-center justify-center min-h-screen bg-cover overflow-hidden">
        <div class="glassmorphism w-[93%] h-[88vh] p-5 flex flex-col text-[#b28666]">
            <div class="flex items-center mb-3 ml-4 space-x-3 text-[#b28666]">
                <BackButton />
                <p class="text-3xl font-bold">Sleep Graph</p>
            </div>
            <div class="flex w-full h-[76vh]">
                <div class="chart-container">
                    <Bar ref="chart" :data="chartData" :options="chartOptions" class="w-30% h-12 pl-10 pt-5" />
                </div>

                <div class="w-1/2">
                    <button @click="showModal = true"
                        class="text-white bg-[#B28666] hover:bg-[#8c6950] focus:outline-none font-medium text-xl rounded-full px-10 py-2.5 text-center me-2 mb-2 dark:bg-[#B28666] dark:hover:bg-[#8c6950]">
                        + Add Sleep Time
                    </button>

                    <div class="py-5 ml-10">
                        <label for="date" class="block text-sm font-medium">
                            Select Date
                        </label>
                        <Datepicker v-if="isDatepickerVisible === 'start'" :isOpen="isDatepickerVisible === 'start'"
                            :selected-date="selectedOutsideDate" v-model="selectedOutsideDate"
                            @date-selected="setDateOutside" class="mt-2" />
                    </div>
                    <button @click="updateChartData"
                        class="mt-[85%] text-white bg-[#B28666] hover:bg-[#8c6950] focus:outline-none font-medium text-xl rounded-full px-10 py-2.5 text-center me-2 mb-2 dark:bg-[#B28666] dark:hover:bg-[#8c6950]">
                        Update
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
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
                        <Datepicker v-if="isDatepickerVisible === 'start'" :isOpen="isDatepickerVisible === 'start'"
                            :selected-date="selectedModalDate" v-model="selectedModalDate" @date-selected="setDateModal"
                            class="mt-2" />
                    </div>

                    <!-- Time Pickers (Start Time and End Time) -->
                    <div class="w-1/2 py-10">
                        <div class="mb-4">
                            <label for="startSleep" class="block text-sm font-medium">Start Time</label>
                            <div class="relative">
                                <input v-model="startSleep" type="text" id="startSleep"
                                    class="w-full p-2 border border-gray-300 rounded mt-1"
                                    @focus="showTimePicker('start')" placeholder="Select Start Time" />
                                <Timepicker v-if="isTimePickerOpen === 'start'" :isOpen="isTimePickerOpen === 'start'"
                                    :initialTime="startSleep" @time-selected="handleStartTimeSelected"
                                    @cancel-selection="handleCancelSelection" />
                            </div>
                        </div>

                        <div class="mb-4 pt-10">
                            <label for="endSleep" class="block text-sm font-medium">End Time</label>
                            <div class="relative">
                                <input v-model="endSleep" type="text" id="endSleep"
                                    class="w-full p-2 border border-gray-300 rounded mt-1"
                                    @focus="showTimePicker('end')" placeholder="Select End Time" />
                                <Timepicker v-if="isTimePickerOpen === 'end'" :isOpen="isTimePickerOpen === 'end'"
                                    :initialTime="endSleep" @time-selected="handleEndTimeSelected"
                                    @cancel-selection="handleCancelSelection" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end mt-4 pt-4">
                    <button type="button" @click="showModal = false" class="text-red-500 pr-[20%]">
                        Cancel
                    </button>
                    <button type="submit" class="bg-[#B28666] text-white px-4 py-2 rounded-full hover:bg-[#8c6950]">
                        Add Sleep
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { db, auth, setDoc, collection, getDoc, doc } from "@/firebaseConfig"; // Firebase imports
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
                        data: [0, 0, 0, 0, 0, 0, 0], // Placeholder data for sleep durations
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

                this.showModal = false;
                this.updateChartData(); // Refresh the chart after adding new sleep data
            }
        },

        // updateChart() {
        //     this.fetchSleepData(); // Refresh data when "Update" button is clicked
        // },

        // setDateOutside(date) {
        //     this.selectedOutsideDate = date; // Update the outside Datepicker date
        // },

        setDateModal(date) {
            this.selectedModalDate = date; // Update the modal Datepicker date
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
        getWeekStartEndDates(selectedDate) {
            // Validate the selected date
            const date = new Date(selectedDate);
            if (isNaN(date)) {
                console.error("Invalid date provided:", selectedDate);
                throw new Error("Invalid date value. Please provide a valid date.");
            }

            // Get the day of the week (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
            const dayOfWeek = date.getDay();

            // Calculate the start of the week (Sunday)
            const startOfWeek = new Date(date);
            startOfWeek.setDate(date.getDate() - dayOfWeek); // Adjust to Sunday of the selected week

            // Calculate the end of the week (Saturday)
            const endOfWeek = new Date(startOfWeek);
            endOfWeek.setDate(startOfWeek.getDate() + 6); // Saturday of the same week

            console.log("Raw Start of the Week:", startOfWeek);
            console.log("Raw End of the Week:", endOfWeek);

            return { startOfWeek, endOfWeek };
        },

        // Method to fetch the sleep durations for the entire week
        async fetchWeeklySleepData(selectedDate) {
            try {
                selectedDate = selectedDate || new Date(); // Use today's date if none is provided

                const { startOfWeek, endOfWeek } = this.getWeekStartEndDates(selectedDate);
                console.log("Week Start:", startOfWeek, "Week End:", endOfWeek);

                if (!this.userId) {
                    console.error("User ID not available. Ensure user is authenticated.");
                    return;
                }

                const sleepDurations = [];
                const weekDates = [];
                let currentDay = new Date(startOfWeek);

                while (currentDay <= endOfWeek) {
                    const formattedDate = currentDay.toISOString().substring(0, 10);
                    weekDates.push(formattedDate);

                    // Fetch data from Firestore
                    const sleepDocRef = doc(
                        db,
                        "users",
                        this.userId,
                        "sleep",
                        formattedDate
                    );
                    const docSnap = await getDoc(sleepDocRef);

                    if (docSnap.exists()) {
                        const sleepData = docSnap.data();
                        console.log(
                            `Fetched data for ${formattedDate}: Sleep Duration = ${sleepData.sleepDuration} hrs`
                        );
                        sleepDurations.push(sleepData.sleepDuration);
                    } else {
                        console.warn(
                            `No sleep data found for ${formattedDate}, defaulting to 0 hours.`
                        );
                        sleepDurations.push(0);
                    }

                    // Move to the next day safely
                    currentDay = new Date(currentDay);
                    currentDay.setDate(currentDay.getDate() + 1);
                }

                console.log("Sleep Durations for the Week:", sleepDurations);

                // Update the chart
                this.updateChartData(sleepDurations, weekDates);
            } catch (error) {
                console.error("Error fetching sleep data:", error);
            }
        },

        // Method to update the chart data
        updateChartData(sleepDurations, weekDates) {
            this.chartData = {
                labels: weekDates, // Set the week dates on the x-axis
                datasets: [
                    { // https://www.chartjs.org/docs/latest/samples/area/line-datasets.html
                        label: "Sleep Duration (Hours)", // Label for the dataset
                        backgroundColor: "#b28666",
                        borderColor: "#b28666",
                        borderWidth: 1, // Width of the bar borders
                        data: sleepDurations, // Set the sleep durations as the data for the y-axis
                    },
                ],
            };

            // Access the Chart.js instance and refresh the chart
            const chartInstance = this.$refs.chart.chart;
            if (chartInstance) {
                chartInstance.update();
            } else {
                console.error("Chart instance not found.");
            }
        },

        // Called when a date is selected outside the modal
        setDateOutside(date) {
            this.selectedOutsideDate = date; // Update the selected date outside the modal
            console.log(
                "Selected Date (outside modal):",
                this.selectedOutsideDate
            ); // Log the selected date
            this.fetchWeeklySleepData(this.selectedOutsideDate); // Fetch sleep data for the entire week
        },
    },

    mounted() {
        onAuthStateChanged(auth, (user) => {
            if (user) {
                this.userId = user.uid;
                console.log("User ID:", this.userId);
                this.fetchWeeklySleepData();
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
