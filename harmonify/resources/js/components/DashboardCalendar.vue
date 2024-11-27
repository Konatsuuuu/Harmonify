<template>
    <div class="flex flex-1 mb-4">
        <div class="grid grid-rows-3 grid-cols-3 gap-2 w-full h-full px-2 mb-2">
            <!-- sun to tues -->
            <div v-for="(day, index) in daysInWeek.slice(0, 3)" :key="index"
                class="flex-1 flex flex-col items-center justify-center bg-white/50 mr-1 ml-2 mb-2 rounded-xl">
                <div class="font-bold text-lg text-[#b28666]">{{ day && day.day }}</div>
                <div class="w-28 h-28 flex items-center justify-center">
                    <img v-if="day && day.emotion" :src="day.emotion.icon" class="bubble" />
                </div>
            </div>

            <!-- wed to fri -->
            <div v-for="(day, index) in daysInWeek.slice(3, 6)" :key="index"
                class="flex-1 flex flex-col items-center justify-center bg-white/50 mr-1 ml-2 mb-2 rounded-xl">
                <div class="font-bold text-lg text-[#b28666]">{{ day && day.day }}</div>
                <div class="w-28 h-28 flex items-center justify-center">
                    <img v-if="day && day.emotion" :src="day.emotion.icon" class="bubble" />
                </div>
            </div>

            <div></div>
            <!-- sat -->
            <div class="flex-1 flex flex-col items-center justify-center bg-white/50 mx-1 rounded-xl">
                <div class="font-bold text-lg text-[#b28666]">{{ daysInWeek[6] && daysInWeek[6].day }}</div>
                <div class="w-28 h-28 flex items-center justify-center">
                    <img v-if="daysInWeek[6] && daysInWeek[6].emotion" :src="daysInWeek[6].emotion.icon"
                        class="bubble" />
                </div>
            </div>
            <div class="flex items-end justify-end mb-4">
                <ExpandCalendar />
            </div>
        </div>
    </div>
</template>

<script>
import ExpandCalendar from "./ExpandCalendar.vue";
import {
    db,
    auth,
    collection,
    getDocs,
} from "@/firebaseConfig";
import { onAuthStateChanged } from "firebase/auth";
import anime from "animejs/lib/anime.es.js";

export default {
    components: {
        ExpandCalendar,
    },
    data() {
        return {
            daysInWeek: [],
            emotions: [
                { name: "Happy", icon: "/svg/happy_bubble.svg" },
                { name: "Calm", icon: "/svg/calm_bubble.svg" },
                { name: "Sad", icon: "/svg/sad_bubble.svg" },
                { name: "Angry", icon: "/svg/angry_bubble.svg" },
            ],
            userId: null,
            weekdays: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
        };
    },
    methods: {
        getStartOfWeek(date) {
            const dayOfWeek = date.getDay();
            const startOfWeek = new Date(date);
            startOfWeek.setDate(date.getDate() - dayOfWeek);
            return startOfWeek;
        },
        async fetchWeeklyEmotionData() {
            try {
                const today = new Date();
                const startOfWeek = this.getStartOfWeek(today);
                const userDocRef = collection(
                    db,
                    "users",
                    this.userId,
                    "emotions"
                );
                const emotionSnapshot = await getDocs(userDocRef);

                const weeklyData = {};
                emotionSnapshot.forEach((doc) => {
                    const data = doc.data();
                    const date = data.date;
                    weeklyData[date] = data.emotion;
                });

                this.daysInWeek = [];

                for (let index = 0; index < 7; index++) {
                    const dayDate = new Date(startOfWeek);
                    dayDate.setDate(startOfWeek.getDate() + index);

                    const formattedDate = dayDate.toISOString().substring(0, 10);

                    this.daysInWeek.push({
                        day: this.weekdays[dayDate.getDay() % 7],
                        date: formattedDate,
                        emotion: this.emotions.find((emotion) => emotion.name === weeklyData[formattedDate])
                    });
                }
                console.log("Days in Week:", this.daysInWeek);
            }
            catch (error) {
                console.error("Error fetching weekly emotions:", error);
            }
            this.$nextTick(() => {
                anime({
                    targets: ".bubble",
                    translateY: [10, -20],
                    direction: "alternate",
                    easing: "easeInOutSine",
                    duration: 3000,
                    loop: true,
                });
            });
        },
    },
    mounted() {
        onAuthStateChanged(auth, (user) => {
            if (user) {
                // User is signed in, see docs for a list of available properties
                // https://firebase.google.com/docs/reference/js/auth.user
                this.userId = user.uid;
                console.log("User ID:", this.userId);
                this.fetchWeeklyEmotionData();
            } else {
                // User is signed out
                console.warn("User is signed out");
            }
        });
    },
};
</script>
