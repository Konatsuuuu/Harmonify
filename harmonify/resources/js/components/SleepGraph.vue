<template>
    <div
        class="backgroundImg flex items-center justify-center min-h-screen bg-cover overflow-hidden"
    >
        <div
            class="glassmorphism w-[93%] h-[88vh] p-5 flex flex-col text-[#040505]"
        >
            <div class="flex items-center mb-3 ml-4 space-x-3 text-[#040505]">
                <BackButton />
                <p class="text-3xl font-bold">Sleep Graph</p>
            </div>
            <div class="flex w-full h-[76vh]">
                <div class="chart-container w-1/2">
                    <Bar :data="chartData" :options="chartOptions" />
                </div>

                <div class="w-1/3">
                    <!-- Open modal when button is clicked -->
                    <button
                        @click="openModal"
                        class="text-white bg-green-800 hover:bg-green-900 focus:outline-none font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-green-700 dark:hover:bg-green-800"
                    >
                        + Add Sleep Time
                    </button>

                    <VueDatePicker v-model="date"></VueDatePicker>
                </div>
            </div>
        </div>
    </div>

    <!-- Sleep Add Modal -->
    <SleepAdd :showModal="showModal" :closeModal="closeModal" />
</template>

<script>
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
import BackButton from "./BackButton.vue";
import SleepAdd from "./SleepGraphAdd.vue"; // Import the SleepAdd component

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
        SleepAdd, // Register the SleepAdd component
    },

    data() {
        return {
            showModal: false, // This will control the visibility of the modal
            chartData: {
                labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"], // Example week data
                datasets: [
                    {
                        label: "Sleep Duration (hrs)", // Label for the chart
                        data: [6, 7, 5, 8, 6, 7, 9], // Example data
                        backgroundColor: "396b4a", // Bar color
                        borderColor: "#396b4a", // Border color
                        borderWidth: 1,
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
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return `${tooltipItem.dataset.label}: ${tooltipItem.raw} hrs`;
                            },
                        },
                    },
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: "Days of the Week",
                        },
                        ticks: {
                            padding: 20,
                        },
                    },
                    y: {
                        title: {
                            display: true,
                            text: "Hours",
                        },
                        min: 0,
                        max: 12,
                    },
                },
                elements: {
                    bar: {
                        borderRadius: 5,
                        barThickness: 5,
                    },
                },
            },
        };
    },

    methods: {
        // Method to open the modal
        openModal() {
            this.showModal = true; // Show modal when button is clicked
        },

        // Method to close the modal
        closeModal() {
            this.showModal = false; // Close modal when user submits or closes it
        },
    },
};
</script>

<style scoped>
.chart-container {
    width: 100%;
    height: 400px;
}
</style>
