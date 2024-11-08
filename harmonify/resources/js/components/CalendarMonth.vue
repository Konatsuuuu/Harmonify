<template>
    <div class="flex flex-col items-center">
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

        <div class="grid grid-cols-7 gap-6 w-full">
            <div
                v-for="(day, index) in daysInMonth"
                :key="index"
                :class="[
                    'w-20 h-20 border-4 border-dashed border-[#b28666] text-[#b28666] bg-white/50 flex items-center justify-center rounded-full',
                    { 'border-none bg-transparent': day.emotion },
                ]"
                @click="selectDay(day)"
            >
                <div v-if="!day.emotion" class="text-lg font-bold">
                    {{ day.date }}
                </div>
                <img
                    v-else
                    :src="day.emotion.icon"
                    class="w-[120%] h-[120%] object-cover rounded-full scale-110"
                />
            </div>
        </div>

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
                        class="w-20 h-20 rounded-full flex-col items-center justify-center cursor-pointer"
                        @click="recordEmotion(emotion)"
                    >
                        <img
                            :src="emotion.icon"
                            class="w-full h-full rounded-full"
                        />
                        <div>{{ emotion.name }}</div>
                    </div>
                </div>
                <textarea
                    v-model="diary"
                    class="mt-10 w-full p-2 border rounded"
                ></textarea>
                <button @click="closePopup" class="mt-4 text-[#b28666]">
                    Close
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { db, auth, setDoc, collection, getDocs, doc } from "@/firebaseConfig";
import { onAuthStateChanged } from "firebase/auth";

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
            emotions: [
                { name: "Happy", icon: "/svg/happy_bubble.svg" },
                { name: "Calm", icon: "/svg/calm_bubble.svg" },
                { name: "Sad", icon: "/svg/sad_bubble.svg" },
                { name: "Angry", icon: "/svg/angry_bubble.svg" },
            ],
            diary: "",
            userId: null,
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
            if (!this.userId) {
                console.error("User ID not available");
                return;
            }
            try {
                const userDocRef = collection(
                    db,
                    "users",
                    this.userId,
                    "emotions"
                );
                const emotionSnapshot = await getDocs(userDocRef);
                const emotionData = emotionSnapshot.docs.map((doc) =>
                    doc.data()
                );

                this.daysInMonth.forEach((day) => {
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
            if (!this.userId) {
                console.error("User ID not available, cannot save data.");
                return;
            }
            try {
                const dateId = `${this.currentYear}-${this.currentMonth + 1}-${
                    day.date
                }`;
                const userDocRef = doc(
                    db,
                    "users",
                    this.userId,
                    "emotions",
                    dateId
                );
                await setDoc(userDocRef, {
                    date: dateId,
                    emotion: emotion.name,
                    diary: diary,
                });
                console.log("Data saved successfully!");
            } catch (error) {
                console.error("Error saving data:", error);
            }
        },
        recordEmotion(emotion) {
            this.daysInMonth[this.selectedDayIndex].emotion = emotion;
            this.daysInMonth[this.selectedDayIndex].diary = this.diary;
            this.saveEmotionData(
                this.daysInMonth[this.selectedDayIndex],
                emotion,
                this.diary
            );
            this.diary = "";
            this.showPopup = false;
        },
        calculateDaysInMonth() {
            const days = new Date(
                this.currentYear,
                this.currentMonth + 1,
                0
            ).getDate();
            this.daysInMonth = Array.from({ length: days }, (_, i) => ({
                date: i + 1,
                emotion: null,
            }));
        },
        prevMonth() {
            if (this.currentMonth === 0) {
                this.currentMonth = 11;
                this.currentYear--;
            } else {
                this.currentMonth--;
            }
            this.calculateDaysInMonth();
            this.fetchEmotionData();
        },
        nextMonth() {
            if (this.currentMonth === 11) {
                this.currentMonth = 0;
                this.currentYear++;
            } else {
                this.currentMonth++;
            }
            this.calculateDaysInMonth();
            this.fetchEmotionData();
        },
        selectDay(day) {
            this.selectedDayIndex = day.date - 1;
            this.showPopup = true;
        },
        closePopup() {
            this.showPopup = false;
        },
    },
    mounted() {
        this.calculateDaysInMonth();
        onAuthStateChanged(auth, (user) => {
            if (user) {
                this.userId = user.uid;
                console.log("User ID:", this.userId);
                this.fetchEmotionData();
            } else {
                console.warn("No user is signed in.");
            }
        });
    },
};
</script>
