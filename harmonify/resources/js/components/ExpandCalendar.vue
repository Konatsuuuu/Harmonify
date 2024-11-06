<template>
    <!-- logout icon with popup confirmation -->
    <div>
        <svg
            @click="directToCalendarPage"
            fill="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
            class="mr-4 justify-self-end text-[#38686e] w-8 h-8 cursor-pointer"
        >
            <path
                d="M3,20V12a1,1,0,0,1,2,0v5.585L17.586,5H12a1,1,0,0,1,0-2h8a1,1,0,0,1,1,1v8a1,1,0,0,1-2,0V6.414L6.414,19H12a1,1,0,0,1,0,2H4A1,1,0,0,1,3,20Z"
            />
        </svg>
        <div
            v-if="showPopUp"
            class="absolute right-5 mt-2 p-4 bg-white rounded-lg shadow-sm text-center"
        >
            <div class="text-xl text-[#50858B]">Logout?</div>
            <div class="mt-1 flex justify-center">
                <button
                    @click="logout"
                    class="m-1 px-4 py-2 bg-[#50858B] text-white rounded-lg"
                >
                    Yes
                </button>
                <button
                    @click="togglePopUp"
                    class="m-1 px-4 py-2 bg-[#A1D2CE] text-[#50858B] rounded-lg"
                >
                    Cancel
                </button>
            </div>
        </div>
    </div>
</template>

<script type="module">
// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/11.0.1/firebase-app.js";
import {
    getAuth,
    signOut,
} from "https://www.gstatic.com/firebasejs/11.0.1/firebase-auth.js";
import { getAnalytics } from "https://www.gstatic.com/firebasejs/11.0.1/firebase-analytics.js";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
    apiKey: "AIzaSyDOcUz9FFkzTGWT-7GOT5rGZK_SVmmtxfg",
    authDomain: "harmonify-af9f4.firebaseapp.com",
    projectId: "harmonify-af9f4",
    storageBucket: "harmonify-af9f4.firebasestorage.app",
    messagingSenderId: "536611376141",
    appId: "1:536611376141:web:bb3cf2960825757b3e5944",
    measurementId: "G-DGEF2BKFH9",
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const analytics = getAnalytics(app);

// Initialize Firebase Authentication and get a reference to the service
const auth = getAuth(app);

export default {
    methods: {
        directToCalendarPage() {
            window.location.href = "/calendar";
        },
    },
};
</script>
