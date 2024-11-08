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
                        class="text-white bg-green-800 hover:bg-green-900 focus:outline-none font-medium text-xl rounded-full px-10 py-2.5 text-center me-2 mb-2 dark:bg-green-700 dark:hover:bg-green-800"
                    >
                        + Add Sleep Time
                    </button>

                    <div class="relative max-w-sm">
                        <div
                            class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none"
                        >
                            <svg
                                class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"
                                />
                            </svg>
                        </div>
                        <input
                            id="datepicker-actions"
                            datepicker
                            datepicker-buttons
                            datepicker-autoselect-today
                            type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Select date"
                        />
                    </div>
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

import { onMounted } from "vue";

onMounted(() => {
    const datepickerElement = document.getElementById("default-datepicker");
    if (datepickerElement) {
        new Flowbite.Datepicker(datepickerElement); // Initialize the datepicker on the element
    }
});

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
