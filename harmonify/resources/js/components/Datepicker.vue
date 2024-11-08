<template>
    <div
        v-if="isOpen"
        class="absolute z-10 bg-white border border-gray-300 rounded-md shadow-lg mt-1 w-[28%]"
    >
        <div class="flex justify-between items-center p-2">
            <button
                @click="changeMonth(-1)"
                class="w-8 h-8 text-lg font-bold text-[#B28666] focus:outline-none rounded-full text-center me-2 mb-2"
            >
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M15 7L10 12L15 17"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </button>

            <div class="text-lg font-bold">
                {{ currentMonth }} {{ currentYear }}
            </div>

            <button
                @click="changeMonth(+1)"
                class="w-8 h-8 text-lg font-bold text-[#B28666] focus:outline-none rounded-full text-center me-2 mb-2"
            >
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M10 7L15 12L10 17"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </button>
        </div>

        <div
            class="grid grid-cols-7 gap-1 p-1 text-center font-semibold text-sm text-gray-600"
        >
            <div v-for="day in weekdays" :key="day" class="py-1">{{ day }}</div>
        </div>

        <div class="grid grid-cols-7 gap-1 p-1">
            <div
                v-for="(date, index) in dates"
                :key="index"
                @click="selectDate(date)"
                class="text-center py-1 cursor-pointer hover:bg-[#b28666] hover:text-white rounded-md text-sm"
                :class="{
                    'text-gray-300': !date,
                    'text-black': date,
                    'bg-[#b28666] text-white':
                        selectedDate === formatDate(date),
                    'bg-[#ffffff]': selectedDate !== formatDate(date) && date,
                }"
            >
                {{ date }}
            </div>
        </div>

        <div class="flex justify-center items-center p-3">
            <button
                @click="selectToday($event)"
                class="w-20 h-10 text-white bg-[#B28666] hover:bg-[#8c6950] focus:outline-none font-medium text-sm rounded-full text-center me-2 mb-2 dark:bg-[#B28666] dark:hover:bg-[#8c6950]"
            >
                Today
            </button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        isOpen: Boolean,
        selectedDate: String,
    },
    data() {
        return {
            currentYear: new Date().getFullYear(),
            currentMonthIndex: new Date().getMonth(),
            currentMonth: new Date().toLocaleString("default", {
                month: "long",
            }),
            weekdays: ["S", "M", "T", "W", "T", "F", "S"],
            dates: [],
        };
    },
    watch: {
        currentMonthIndex() {
            this.generateDates();
        },
    },
    methods: {
        generateDates() {
            const dates = [];
            const currentDate = new Date(
                this.currentYear,
                this.currentMonthIndex,
                1
            );

            const firstDay = currentDate.getDay();
            const daysInMonth = new Date(
                this.currentYear,
                this.currentMonthIndex + 1,
                0
            ).getDate();

            for (let i = 0; i < firstDay; i++) {
                dates.push("");
            }

            for (let i = 1; i <= daysInMonth; i++) {
                dates.push(i);
            }

            this.dates = dates;
        },

        selectDate(date) {
            if (date) {
                this.$emit(
                    "date-selected",
                    `${this.currentYear}-${this.formatMonth(
                        this.currentMonthIndex + 1
                    )}-${this.formatDay(date)}`
                );
            }
        },

        selectToday(event) {
            // https://www.w3schools.com/jsref/event_preventdefault.asp
            event.preventDefault();
            const today = new Date();
            const formattedToday = `${today.getFullYear()}-${this.formatMonth(
                today.getMonth() + 1
            )}-${this.formatDay(today.getDate())}`;
            this.$emit("date-selected", formattedToday);
        },

        formatMonth(month) {
            if (month < 10) {
                return `0${month}`;
            } else {
                return month;
            }
        },

        formatDay(day) {
            if (day < 10) {
                return `0${day}`;
            } else {
                return day;
            }
        },

        formatDate(date) {
            return `${this.currentYear}-${this.formatMonth(
                this.currentMonthIndex + 1
            )}-${this.formatDay(date)}`;
        },

        changeMonth(direction) {
            const newMonthIndex = this.currentMonthIndex + direction;
            if (newMonthIndex < 0) {
                this.currentMonthIndex = 11;
                this.currentYear -= 1;
            } else if (newMonthIndex > 11) {
                this.currentMonthIndex = 0;
                this.currentYear += 1;
            } else {
                this.currentMonthIndex = newMonthIndex;
            }

            this.updateCurrentMonthText();
            this.generateDates();
        },

        updateCurrentMonthText() {
            // https://www.w3schools.com/jsref/event_preventdefault.asp
            event.preventDefault();
            this.currentMonth = new Date(
                this.currentYear,
                this.currentMonthIndex
            ).toLocaleString("default", { month: "long" });
        },
    },

    mounted() {
        this.generateDates();
    },
};
</script>
