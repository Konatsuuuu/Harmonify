<template>
    <div
        class="backgroundImg flex items-center justify-center min-h-screen bg-cover overflow-hidden"
    >
        <div
            class="glassmorphism w-[93%] h-[88vh] p-5 flex flex-col text-primary-milktea"
        >
            <div
                class="flex justify-between ml-4 space-x-3 text-primary-milktea"
            >
                <div
                    class="flex items-center mb-3 ml-4 space-x-3 text-primary-milktea"
                >
                    <BackButton />
                    <p class="text-3xl font-bold">Posts</p>
                </div>
                <div class="flex space-x-4 text-primary-milktea pr-5">
                    <div>
                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-8 h-8 cursor-pointer"
                            @click="toggleDropdown"
                        >
                            <path
                                d="M21 6H19M21 12H16M21 18H16M7 20V13.5612C7 13.3532 7 13.2492 6.97958 13.1497C6.96147 13.0615 6.93151 12.9761 6.89052 12.8958C6.84431 12.8054 6.77934 12.7242 6.64939 12.5617L3.35061 8.43826C3.22066 8.27583 3.15569 8.19461 3.10948 8.10417C3.06849 8.02393 3.03853 7.93852 3.02042 7.85026C3 7.75078 3 7.64677 3 7.43875V5.6C3 5.03995 3 4.75992 3.10899 4.54601C3.20487 4.35785 3.35785 4.20487 3.54601 4.10899C3.75992 4 4.03995 4 4.6 4H13.4C13.9601 4 14.2401 4 14.454 4.10899C14.6422 4.20487 14.7951 4.35785 14.891 4.54601C15 4.75992 15 5.03995 15 5.6V7.43875C15 7.64677 15 7.75078 14.9796 7.85026C14.9615 7.93852 14.9315 8.02393 14.8905 8.10417C14.8443 8.19461 14.7793 8.27583 14.6494 8.43826L11.3506 12.5617C11.2207 12.7242 11.1557 12.8054 11.1095 12.8958C11.0685 12.9761 11.0385 13.0615 11.0204 13.1497C11 13.2492 11 13.3532 11 13.5612V17L7 20Z"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            />
                        </svg>
                        <div
                            v-if="isDropdownVisible"
                            class="absolute mt-2 w-28 bg-white rounded-lg shadow-lg z-10"
                        >
                            <ul class="py-2">
                                <li
                                    @click="selectEmotion('')"
                                    class="px-4 py-2 cursor-pointer hover:bg-gray-100 text-primary-milktea"
                                >
                                    All
                                </li>
                                <li
                                    v-for="emotion in emotions"
                                    :key="emotion.name"
                                    @click="selectEmotion(emotion.name)"
                                    class="px-4 py-2 cursor-pointer hover:bg-gray-100 text-primary-milktea"
                                >
                                    {{ emotion.name }}
                                </li>
                            </ul>
                        </div>
                    </div>
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        class="w-7 h-7 cursor-pointer"
                        xmlns="http://www.w3.org/2000/svg"
                        @click="togglePopup"
                    >
                        <path
                            d="M1 22C1 21.4477 1.44772 21 2 21H22C22.5523 21 23 21.4477 23 22C23 22.5523 22.5523 23 22 23H2C1.44772 23 1 22.5523 1 22Z"
                            fill="currentColor"
                        />
                        <path
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M18.3056 1.87868C17.1341 0.707107 15.2346 0.707107 14.063 1.87868L3.38904 12.5526C2.9856 12.9561 2.70557 13.4662 2.5818 14.0232L2.04903 16.4206C1.73147 17.8496 3.00627 19.1244 4.43526 18.8069L6.83272 18.2741C7.38969 18.1503 7.89981 17.8703 8.30325 17.4669L18.9772 6.79289C20.1488 5.62132 20.1488 3.72183 18.9772 2.55025L18.3056 1.87868ZM15.4772 3.29289C15.8677 2.90237 16.5009 2.90237 16.8914 3.29289L17.563 3.96447C17.9535 4.35499 17.9535 4.98816 17.563 5.37868L15.6414 7.30026L13.5556 5.21448L15.4772 3.29289ZM12.1414 6.62869L4.80325 13.9669C4.66877 14.1013 4.57543 14.2714 4.53417 14.457L4.0014 16.8545L6.39886 16.3217C6.58452 16.2805 6.75456 16.1871 6.88904 16.0526L14.2272 8.71448L12.1414 6.62869Z"
                            fill="currentColor"
                        />
                    </svg>
                </div>
            </div>
            <!-- Posts Grid -->
            <div class="columns-3 gap-4 p-4 overflow-y-auto">
                <div
                    v-for="post in filteredPosts"
                    :key="post.id"
                    class="bg-white shadow-lg rounded-xl mb-4 p-4 break-inside-avoid"
                    @click="directToPostDetailPage(post.id)"
                >
                    <div class="flex items-center mb-4">
                        <img
                            :src="post.emotion.icon"
                            :alt="post.emotion.name"
                            class="w-20 h-20 rounded-full"
                        />
                        <p class="px-4 text-xl font-bold text-primary-milktea">
                            {{ post.title }}
                        </p>
                    </div>
                    <p class="text-md mb-4 line-clamp">
                        {{ post.content }}
                    </p>
                    <div class="rounded-lg overflow-hidden">
                        <img
                            v-if="post.images && post.images.length > 0"
                            :src="post.images[0]"
                            class="w-full object-cover"
                        />
                    </div>
                </div>
            </div>
            <!-- Pop up for writing a post -->
            <div
                v-if="isPopupVisible"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-20"
            >
                <div class="bg-white p-8 rounded-lg max-w-md">
                    <h2 class="text-2xl font-bold mb-4">Create a Post</h2>
                    <div class="flex space-x-4 mb-8">
                        <div
                            v-for="emotion in emotions"
                            :key="emotion.name"
                            class="w-20 h-20 rounded-full flex flex-col items-center justify-center cursor-pointer"
                            @click="animatePopupEmotion(emotion)"
                            :class="{
                                'font-bold':
                                    popupSelectedEmotion &&
                                    popupSelectedEmotion.name === emotion.name,
                            }"
                        >
                            <img
                                :src="emotion.icon"
                                :alt="emotion.name"
                                :ref="emotion.name"
                                class="popup-emotion w-full h-full rounded-full"
                            />
                            <div>{{ emotion.name }}</div>
                        </div>
                    </div>
                    <input
                        type="text"
                        v-model="newPost.title"
                        class="w-full p-2 mb-4 border rounded"
                        placeholder="Title"
                    />
                    <textarea
                        v-model="newPost.content"
                        class="w-full mb-4 h-40"
                        placeholder="Content"
                    ></textarea>
                    <div class="w-full items-center justify-center">
                        <v-file-input
                            label="Upload Images"
                            accept="image/*"
                            show-size
                            multiple
                            @change="uploadImage"
                        ></v-file-input>
                    </div>
                    <div class="flex justify-end">
                        <button
                            @click="togglePopup"
                            class="m-1 px-4 py-2 bg-[#b28666a0] text-white rounded"
                        >
                            Cancel
                        </button>
                        <button
                            @click="submitPost"
                            class="m-1 px-4 py-2 bg-primary-milktea text-white rounded"
                        >
                            Post
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import anime from "animejs/lib/anime.es.js";
import {
    db,
    auth,
    setDoc,
    collection,
    getDocs,
    getDoc,
    doc,
    getStorage,
    ref,
    uploadBytes,
    getDownloadURL,
    storage,
    addDoc,
    query,
    orderBy,
    limit,
} from "@/firebaseConfig";
import { onAuthStateChanged } from "firebase/auth";

import BackButton from "./BackButton.vue";

export default {
    components: {
        BackButton,
    },
    data() {
        return {
            newPost: {
                title: "",
                content: "",
                image: "",
            },
            isPopupVisible: false,
            isDropdownVisible: false,
            selectedEmotion: null,
            popupSelectedEmotion: null,
            isUploadingImages: false,
            posts: [],
            emotions: [
                { name: "Happy", icon: "/svg/happy_bubble.svg" },
                { name: "Calm", icon: "/svg/calm_bubble.svg" },
                { name: "Sad", icon: "/svg/sad_bubble.svg" },
                { name: "Angry", icon: "/svg/angry_bubble.svg" },
            ],
        };
    },
    computed: {
        filteredPosts() {
            if (!this.selectedEmotion) {
                return this.posts;
            }
            return this.posts.filter(
                // https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/filter
                (post) => post.emotion.name === this.selectedEmotion.name
            );
        },
    },
    methods: {
        async fetchPosts() {
            try {
                const postSnapshot = await getDocs(
                    query(collection(db, "posts"), orderBy("date", "desc"))
                );
                const fetchedPosts = [];
                postSnapshot.forEach((doc) => {
                    const postData = doc.data();
                    const Post = {
                        id: doc.id,
                        userId: postData.userId,
                        username: postData.username,
                        title: postData.title,
                        content: postData.content,
                        images: Array.isArray(postData.images)
                            ? postData.images
                            : [],
                        emotion: {
                            name: postData.emotion,
                            icon: this.getEmotionIcon(postData.emotion),
                        },
                        date: postData.date,
                    };

                    fetchedPosts.push(Post);
                });
                this.posts = fetchedPosts;
                console.log("Posts fetched successfully:", fetchedPosts);
            } catch (error) {
                console.error("Error fetching posts:", error);
                alert("Failed to fetch posts");
            }
        },
        getEmotionIcon(emotionName) {
            const emotion = this.emotions.find((e) => e.name === emotionName);
            return emotion.icon;
        },
        directToPostDetailPage(id) {
            window.location.href = `/posts/${id}`;
        },
        // https://zenn.dev/tentel/books/a96e4a64d3a672911f25/viewer/58bd63
        async uploadImage(event) {
            const files = event.target.files;
            this.newPost.image = [];
            this.isUploadingImages = true;

            const uploadPromises = Array.from(files).map((file) => {
                const storageRef = ref(storage, "images/" + file.name);
                return uploadBytes(storageRef, file)
                    .then((snapshot) => getDownloadURL(snapshot.ref))
                    .then((downloadURL) => {
                        this.newPost.image.push(downloadURL);
                    })
                    .catch((error) => {
                        console.error("Error uploading image:", error);
                    });
            });

            try {
                await Promise.all(uploadPromises);
                console.log(
                    "Images uploaded successfully:",
                    this.newPost.image
                );
            } catch (error) {
                console.error("Error during image upload:", error);
            } finally {
                this.isUploadingImages = false;
            }
        },
        // https://www.koderhq.com/tutorial/vue/firestore-database/#how-it-works
        async submitPost() {
            if (
                !this.newPost.title ||
                !this.newPost.content ||
                !this.popupSelectedEmotion
            ) {
                alert("Please fill all the fields!");
                return;
            }

            if (this.isUploadingImages) {
                alert("Please wait for images to finish uploading!");
                return;
            }

            const user = auth.currentUser;
            const colRef = collection(db, "posts");

            const postData = {
                userId: user.uid,
                username: await this.getUserName(user.uid),
                title: this.newPost.title,
                content: this.newPost.content,
                images: this.newPost.image || [],
                emotion: this.popupSelectedEmotion.name,
                date: new Date(),
            };

            try {
                const docRef = await addDoc(colRef, postData);
                console.log("Document was created with ID:", docRef.id);
                this.togglePopup();
                this.newPost = { title: "", content: "", image: [] };
                this.fetchPosts();
            } catch (error) {
                console.error("Error adding document:", error);
            }
        },
        async getUserName(userId) {
            try {
                const userSnapshot = await getDoc(doc(db, "users", userId));
                return userSnapshot.data().username;
            } catch (error) {
                console.error("Error fetching username:", error);
                return;
            }
        },
        togglePopup() {
            this.isPopupVisible = !this.isPopupVisible;
            this.popupSelectedEmotion = null;
        },
        toggleDropdown() {
            this.isDropdownVisible = !this.isDropdownVisible;
        },
        selectEmotion(emotionName) {
            this.selectedEmotion = this.emotions.find(
                (emotion) => emotion.name === emotionName
            );
        },
        animatePopupEmotion(emotion) {
            this.popupSelectedEmotion = emotion;
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
    },
    mounted() {
        onAuthStateChanged(auth, (user) => {
            if (user) {
                // User is signed in, see docs for a list of available properties
                // https://firebase.google.com/docs/reference/js/auth.user
                this.userId = user.uid;
                console.log("User ID:", this.userId);
                this.fetchPosts();
            } else {
                // User is signed out
                console.warn("User is signed out");
            }
        });
    },
};
</script>

<style scoped>
/* from https://css-tricks.com/almanac/properties/l/line-clamp/ */
.line-clamp {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
