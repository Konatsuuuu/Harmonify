<template>
    <div
        class="flex flex-col items-center origin-top"
        :style="{
            transform: `scale(${scale})`,
        }"
    >
        <!-- Title -->
        <div class="flex items-center justify-between w-full p-4">
            <button @click="prevMonth" class="text-[#b28666] w-10 h-10">
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M15 7L10 12L15 17"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </button>
            <div class="text-2xl font-bold">
                {{ currentYear }} - {{ currentMonthStr }}
            </div>
            <button @click="nextMonth" class="text-[#b28666] w-10 h-10">
                <svg
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M10 7L15 12L10 17"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </button>
        </div>

        <!-- Display the days of the week -->
        <div class="grid grid-cols-7 gap-6 w-full text-[#b28666] text-lg">
            <div
                v-for="day in weekdays"
                :key="day"
                class="text-center font-bold"
            >
                {{ day }}
            </div>
        </div>

        <!-- Actual calendar area -->
        <div class="grid grid-cols-7 gap-6 w-full">
            <div
                v-for="(day, index) in daysInMonth"
                :key="index"
                class="w-20 h-20 border-4 border-dashed border-[#b28666] text-[#b28666] bg-white/50 flex items-center justify-center rounded-full"
                :class="{ 'border-none bg-transparent': day && day.emotion }"
                @click="day && selectDay(day)"
            >
                <div v-if="!day" class="text-lg font-bold"></div>
                <div v-else-if="!day.emotion" class="text-lg font-bold">
                    {{ day.date }}
                </div>
                <img
                    v-else
                    :src="day.emotion.icon"
                    class="w-[120%] h-[120%] object-cover rounded-full scale-110"
                />
            </div>
        </div>

        <!-- Pop up for diary -->
        <div
            v-if="showPopup"
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
        >
            <div class="bg-white p-6 rounded-lg text-center">
                <p class="text-xl font-bold mb-4">Select Emotion</p>
                <div class="flex space-x-4">
                    <div
                        v-for="emotion in emotions"
                        :key="emotion.name"
                        class="w-20 h-20 rounded-full flex flex-col items-center justify-center cursor-pointer"
                        @click="animatePopupEmotion(emotion, $event)"
                        :class="{
                            'font-bold':
                                selectedEmotion &&
                                selectedEmotion.name === emotion.name,
                        }"
                    >
                        <img
                            :src="emotion.icon"
                            :ref="emotion.name"
                            class="w-full h-full rounded-full"
                        />
                        <div>{{ emotion.name }}</div>
                    </div>
                </div>
                <textarea
                    v-model="diary"
                    class="mt-10 w-full p-2 border rounded"
                ></textarea>
                <button
                    @click="saveDiary"
                    class="mt-4 mr-4 px-4 py-2 bg-[#b28666] text-white rounded"
                >
                    Save
                </button>
                <button @click="closePopup" class="mt-4 text-[#b28666]">
                    Close
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import {
    db,
    auth,
    setDoc,
    collection,
    getDocs,
    getDoc,
    doc,
} from "@/firebaseConfig";
import { onAuthStateChanged } from "firebase/auth";
import anime from "animejs";

export default {
    data() {
        const today = new Date();
        return {
            currentYear: today.getFullYear(),
            currentMonth: today.getMonth(),
            todayDate: today.getDate(),
            daysInMonth: [],
            showPopup: false,
            selectedDayIndex: null,
            selectedEmotion: null,
            emotions: [
                { name: "Happy", icon: "/svg/happy_bubble.svg" },
                { name: "Calm", icon: "/svg/calm_bubble.svg" },
                { name: "Sad", icon: "/svg/sad_bubble.svg" },
                { name: "Angry", icon: "/svg/angry_bubble.svg" },
            ],
            diary: "",
            userId: null,
            weekdays: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
            scale: 1, // change the scale value if needed
        };
    },
    computed: {
        currentMonthStr() {
            return new Date(this.currentYear, this.currentMonth).toLocaleString(
                "en-US",
                { month: "long" }
            );
        },
    },
    methods: {
        async fetchEmotionData() {
            try {
                const emotionSnapshot = await getDocs(
                    collection(db, "users", this.userId, "emotions")
                );
                const emotionData = emotionSnapshot.docs.map((doc) =>
                    doc.data()
                );

                this.daysInMonth.forEach((day) => {
                    if (!day) {
                        return;
                    }
                    const dayData = emotionData.find(
                        (emotion) =>
                            emotion.date ===
                            `${this.currentYear}-${this.currentMonth + 1}-${
                                day.date
                            }`
                    );
                    if (dayData) {
                        day.emotion = this.emotions.find(
                            (emotion) => emotion.name === dayData.emotion
                        );
                        day.diary = dayData.diary;
                    }
                });
                console.log("Data fetched successfully!");
            } catch (error) {
                console.error("Error fetching data:", error);
            }
        },
        async saveEmotionData(day, emotion, diary) {
            try {
                const dateId = `${this.currentYear}-${this.currentMonth + 1}-${
                    day.date
                }`;
                await setDoc(
                    doc(db, "users", this.userId, "emotions", dateId),
                    {
                        date: dateId,
                        emotion: emotion.name,
                        diary: diary,
                    }
                );
                console.log("Data saved successfully!");
            } catch (error) {
                console.error("Error saving data:", error);
            }
        },
        async fetchDiary(day) {
            try {
                const dateId = `${this.currentYear}-${this.currentMonth + 1}-${
                    day.date
                }`;
                const diarySnapShot = await getDoc(
                    doc(db, "users", this.userId, "emotions", dateId)
                );

                if (diarySnapShot.exists()) {
                    const data = diarySnapShot.data();
                    this.diary = data.diary || "";
                } else {
                    this.diary = "";
                }
            } catch (error) {
                console.error("Error fetching diary:", error);
            }
        },
        // the scale animation if clicked
        animatePopupEmotion(emotion) {
            this.selectedEmotion = emotion;
            const element = this.$refs[emotion.name];
            if (element) {
                anime({
                    targets: element,
                    scale: [1.2, 1],
                    easing: "easeOutElastic(1, .4)",
                    duration: 2000,
                });
            }
        },
        saveDiary() {
            if (this.selectedDayIndex !== null) {
                const day = this.daysInMonth[this.selectedDayIndex];
                day.emotion = this.selectedEmotion;
                day.diary = this.diary;
                this.saveEmotionData(day, this.selectedEmotion, this.diary);
            }
            this.closePopup();
        },
        recordEmotion(emotion) {
            if (
                this.selectedDayIndex !== null &&
                this.daysInMonth[this.selectedDayIndex]
            ) {
                this.daysInMonth[this.selectedDayIndex].emotion = emotion;
                this.daysInMonth[this.selectedDayIndex].diary = this.diary;
                this.saveEmotionData(
                    this.daysInMonth[this.selectedDayIndex],
                    emotion,
                    this.diary
                );
            }
            this.diary = "";
            this.showPopup = false;
        },
        calculateDaysInMonthArr() {
            // https://segmentfault.com/a/1190000042417306
            const days = new Date(
                this.currentYear,
                this.currentMonth + 1,
                0
            ).getDate();

            // get the day of the first day of the month
            const firstDayOfMonth = new Date(
                this.currentYear,
                this.currentMonth,
                1
            ).getDay();

            //fill the day array with null to display empty bubble
            this.daysInMonth = [];
            for (let i = 0; i < firstDayOfMonth; i++) {
                this.daysInMonth.push(null);
            }

            // then with the actual date
            for (let i = 1; i <= days; i++) {
                this.daysInMonth.push({
                    date: i,
                    emotion: null,
                });
            }

            // scale the calendar if the row count exceeds 5
            const rowCount = Math.ceil(this.daysInMonth.length / 7);
            this.scale = rowCount > 5 ? 0.9 : 1;
        },
        prevMonth() {
            if (this.currentMonth === 0) {
                this.currentMonth = 11;
                this.currentYear--;
            } else {
                this.currentMonth--;
            }
            this.calculateDaysInMonthArr();
            this.fetchEmotionData();
        },
        nextMonth() {
            if (this.currentMonth === 11) {
                this.currentMonth = 0;
                this.currentYear++;
            } else {
                this.currentMonth++;
            }
            this.calculateDaysInMonthArr();
            this.fetchEmotionData();
        },
        async selectDay(day) {
            const dayIndex = this.daysInMonth.findIndex(
                (d) => d && d.date === day.date
            );
            if (dayIndex !== -1) {
                this.selectedDayIndex = dayIndex;
                if (day.emotion) {
                    this.selectedEmotion = this.emotions.find(
                        (emotion) => emotion.name === day.emotion.name
                    );
                } else {
                    this.selectedEmotion = null;
                }

                await this.fetchDiary(day);
                this.showPopup = true;
            }
        },
        closePopup() {
            this.showPopup = false;
        },
    },
    mounted() {
        this.calculateDaysInMonthArr();
        onAuthStateChanged(auth, (user) => {
            if (user) {
                // User is signed in, see docs for a list of available properties
                // https://firebase.google.com/docs/reference/js/auth.user
                this.userId = user.uid;
                console.log("User ID:", this.userId);
                this.fetchEmotionData();
            } else {
                // User is signed out
                console.warn("User is signed out");
            }
        });
    },
};
</script>
