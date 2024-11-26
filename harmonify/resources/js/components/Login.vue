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
                    <input
                        v-model="email"
                        id="email"
                        type="text"
                        class="border ml-4 rounded"
                    />
                </div>
                <div class="flex justify-between w-full m-2">
                    <label for="password" class="text-lg text-primary-milktea"
                        >Password</label
                    >
                    <input
                        v-model="password"
                        id="password"
                        type="password"
                        class="border ml-4 rounded"
                    />
                </div>
                <div class="flex justify-end items-center space-x-2">
                    <button
                        type="submit"
                        @click="loginUser"
                        class="m-1 px-4 py-2 bg-primary-milktea text-white rounded-lg"
                    >
                        Login
                    </button>
                </div>
            </div>
            <div class="grid p-4 justify-center items-center">
                <div class="text-sm text-center">
                    No account?
                    <a
                        href="/register"
                        class="ml-1 underline text-primary-milktea cursor-pointer hover:text-[#de973a]"
                        >Register</a
                    >
                </div>
            </div>
        </div>
    </div>
</template>

<script type="module">
import GoogleLoginButton from "./GoogleLoginButton.vue";
import { auth, signInWithEmailAndPassword } from "@/firebaseConfig";

export default {
    name: "Login",
    components: {
        GoogleLoginButton,
    },
    data() {
        return {
            email: "",
            password: "",
        };
    },
    methods: {
        loginUser() {
            signInWithEmailAndPassword(auth, this.email, this.password)
                .then((userCredential) => {
                    // Signed in
                    const user = userCredential.user;
                    window.location.href = "/";
                    // ...
                })
                .catch((error) => {
                    const errorCode = error.code;
                    const errorMessage = error.message;
                    alert(`Login failed: ${error.message}`);
                });
        },
    },
};
</script>
