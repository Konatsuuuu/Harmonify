<template>
    <div
        class="backgroundImg flex items-center justify-center min-h-screen bg-cover overflow-hidden"
    >
        <div
            class="glassmorphism w-[93%] h-[88vh] p-5 flex flex-col text-[#b28666]"
        >
            <div class="flex items-center mb-1 ml-4 space-x-3 text-[#b28666]">
                <BackButton />
                <p class="text-3xl font-bold">Sleep Graph</p>
            </div>
            <div class="flex w-full h-full">
                <div class="chart-container">
                    <Bar
                        ref="chart"
                        :data="chartData"
                        :options="chartOptions"
                        class="w-30% h-full pr-20 pt-2"
                    />
                </div>

                <div class="w-1/2">
                    <button
                        @click="showModal = true"
                        class="w-[85%] text-white bg-[#B28666] hover:bg-[#8c6950] focus:outline-none font-medium text-xl rounded-full px-10 py-2.5 text-center me-2 mb-2 dark:bg-[#B28666] dark:hover:bg-[#8c6950]"
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
                            class="mt-1 right-0"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>

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
import { db, auth, setDoc, collection, getDoc, doc } from "@/firebaseConfig";
import { onAuthStateChanged } from "firebase/auth";
import Timepicker from "./Timepicker.vue";
import Datepicker from "./Datepicker.vue";
import BackButton from "./BackButton.vue";
import { Bar } from "vue-chartjs";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
} from "chart.js";

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

    // https://www.chartjs.org/docs/latest/charts/bar.html (bar chart)
    data() {
        return {
            showModal: false,
            isDatepickerVisible: "start",
            isTimePickerOpen: null,
            chartData: {
                datasets: [
                    {
                        label: "Sleep Duration (hrs)",
                        data: [0, 0, 0, 0, 0, 0, 0],
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
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: "Dates",
                        },
                    },
                    y: {
                        title: {
                            display: true,
                            text: "Hours",
                        },
                    },
                },
            },
            selectedOutsideDate: "",
            selectedModalDate: "",
            startSleep: "",
            endSleep: "",
            sleepDuration: "",
            userId: null,
        };
    },

    methods: {
        //function to save the information in the firebase database
        async submitSleepForm() {
            const startTime = new Date(
                `${this.selectedModalDate} ${this.startSleep}`
            );
            const endTime = new Date(
                `${this.selectedModalDate} ${this.endSleep}`
            );

            if (endTime < startTime) {
                endTime.setDate(endTime.getDate() + 1);
            }

            // calculate the sleep duration from the given time by the users
            this.sleepDuration = (endTime - startTime) / 3600000;

            // saves the data inputed in the "sleep" database (firebase)
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
                await this.fetchWeeklySleepData(
                    new Date(this.selectedModalDate)
                );
            }
        },

        setDateModal(date) {
            this.selectedModalDate = date;
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
            const date = new Date(selectedDate);

            const dayOfWeek = date.getDay();

            const startOfWeek = new Date(date);
            startOfWeek.setDate(date.getDate() - dayOfWeek);

            const endOfWeek = new Date(startOfWeek);
            endOfWeek.setDate(startOfWeek.getDate() + 6);

            return { startOfWeek, endOfWeek };
        },

        //fetch from the databse to show/update the bar chart
        async fetchWeeklySleepData(selectedDate) {
            try {
                selectedDate = selectedDate || new Date();

                const { startOfWeek, endOfWeek } =
                    this.getWeekStartEndDates(selectedDate);
                console.log("Week Start:", startOfWeek, "Week End:", endOfWeek);

                if (!this.userId) {
                    console.error(
                        "User ID not available. Ensure user is authenticated."
                    );
                    return;
                }

                const sleepDurations = [];
                const weekDates = [];
                let currentDay = new Date(startOfWeek);

                //https://stackoverflow.com/questions/25159330/how-to-convert-an-iso-date-to-the-date-format-yyyy-mm-dd
                while (currentDay <= endOfWeek) {
                    const formattedDate = currentDay
                        .toISOString()
                        .substring(0, 10);
                    weekDates.push(formattedDate);

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

                    currentDay = new Date(currentDay);
                    currentDay.setDate(currentDay.getDate() + 1);
                }

                console.log("Sleep Durations for the Week:", sleepDurations);
                this.updateChartData(sleepDurations, weekDates);
            } catch (error) {
                console.error("Error fetching sleep data:", error);
            }
        },

        updateChartData(sleepDurations, weekDates) {
            this.chartData = {
                labels: weekDates,
                datasets: [
                    {
                        // https://www.chartjs.org/docs/latest/samples/area/line-datasets.html
                        label: "Sleep Duration (Hours)",
                        backgroundColor: "#b28666",
                        borderRadius: 10,
                        data: sleepDurations,
                    },
                ],
            };

            const chartInstance = this.$refs.chart.chart;
            if (chartInstance) {
                chartInstance.update();
            } else {
                console.error("Chart instance not found.");
            }
        },

        setDateOutside(date) {
            this.selectedOutsideDate = date;
            console.log(
                "Selected Date (outside modal):",
                this.selectedOutsideDate
            );
            this.fetchWeeklySleepData(this.selectedOutsideDate);
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
    height: 80%;
}
</style>
