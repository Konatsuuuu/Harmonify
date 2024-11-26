<template>
    <div class="backgroundImg grid items-center justify-center min-h-screen">
        <div
            class="grid p-4 glassmorphism rounded-lg justify-center items-center divide-y-2 space-y-4"
        >
            <div class="grid items-center justify-center p-4 space-y-4">
                <div class="mb-4 text-2xl font-bold text-primary-milktea">
                    Registration
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
                    <label for="username" class="text-lg text-primary-milktea"
                        >Username</label
                    >
                    <input
                        v-model="username"
                        id="username"
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
                <div class="flex justify-between w-full m-2">
                    <label
                        for="password_confirmation"
                        class="text-lg text-primary-milktea"
                        >Confirm Password</label
                    >
                    <input
                        v-model="confirmPassword"
                        id="confirmPassword"
                        type="password"
                        class="border ml-4 rounded"
                    />
                </div>

                <div class="flex justify-end items-center space-x-2">
                    <button
                        type="submit"
                        @click="createUser"
                        class="m-1 px-4 py-2 bg-primary-milktea text-white rounded-lg"
                    >
                        Register
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="module">
import GoogleLoginButton from "./GoogleLoginButton.vue";
import {
    db,
    setDoc,
    collection,
    getDocs,
    getDoc,
    doc,
    auth,
    createUserWithEmailAndPassword,
} from "@/firebaseConfig";

export default {
    name: "Register",
    components: {
        GoogleLoginButton,
    },
    data() {
        return {
            email: "",
            password: "",
            username: "",
            confirmPassword: "",
        };
    },
    methods: {
        async createUser() {
            if (this.password !== this.confirmPassword) {
                alert("Passwords do not match!");
                return;
            }
            try {
                const userCredential = await createUserWithEmailAndPassword(
                    auth,
                    this.email,
                    this.password
                );
                const userId = userCredential.user.uid;
                await setDoc(doc(db, "users", userId), {
                    username: this.username,
                });
                window.location.href = "/";
            } catch (error) {
                const errorCode = error.code;
                const errorMessage = error.message;
                // ..
                console.log(`Error: ${errorMessage}`);
            }
        },
    },
};
</script>
