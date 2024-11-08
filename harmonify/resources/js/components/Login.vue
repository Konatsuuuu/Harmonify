<template>
    <div class="backgroundImg grid items-center justify-center min-h-screen">
        <div
            class="grid p-4 glassmorphism rounded-lg justify-center items-center divide-y-2 space-y-4"
        >
            <div class="grid items-center justify-center p-4 space-y-4">
                <div class="mb-4 text-2xl font-bold text-primary-milktea">
                    Login
                </div>
                <div class="flex justify-between w-full m-2">
                    <label for="email" class="text-lg text-primary-milktea"
                        >Email</label
                    >
                    <input id="email" type="text" class="border ml-4 rounded" />
                </div>
                <div class="flex justify-between w-full m-2">
                    <label for="password" class="text-lg text-primary-milktea"
                        >Password</label
                    >
                    <input
                        id="password"
                        type="password"
                        class="border ml-4 rounded"
                    />
                </div>
                <div class="flex justify-end items-center space-x-2">
                    <button
                        type="submit"
                        onclick="loginUser()"
                        class="m-1 px-4 py-2 bg-primary-milktea text-white rounded-lg"
                    >
                        Login
                    </button>
                </div>
            </div>
            <div class="grid p-4 justify-center items-center">
                <div class="flex m-2">
                    <span class="text-xl p-2 text-primary-milktea">Or...</span>
                    <span>
                        <GoogleLoginButton />
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="module">
import GoogleLoginButton from "./GoogleLoginButton.vue";

export default {
    name: "Login",
    components: {
        GoogleLoginButton,
    },
};
// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/11.0.1/firebase-app.js";
import {
    getAuth,
    signInWithEmailAndPassword,
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
const auth = getAuth();

window.loginUser = function () {
    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    signInWithEmailAndPassword(auth, email, password)
        .then((userCredential) => {
            // Signed in
            const user = userCredential.user;
            alert("Login successful!");
            window.location.href = "/";
            // ...
        })
        .catch((error) => {
            const errorCode = error.code;
            const errorMessage = error.message;
            alert(`Login failed: ${error.message}`);
        });
};
</script>
