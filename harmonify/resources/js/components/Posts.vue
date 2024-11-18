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
                                    v-for="emotion in dropdownList"
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
                    <p class="text-gray-700 text-md mb-4 line-clamp">
                        {{ post.content }}
                    </p>
                    <div class="rounded-lg overflow-hidden">
                        <img :src="post.image" class="w-full object-cover" />
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
                            @click.stop="animatePopupEmotion(emotion)"
                            :class="{
                                'font-bold':
                                    popupSelectedEmotion?.name === emotion.name,
                            }"
                        >
                            <img
                                :src="emotion.icon"
                                :alt="emotion.name"
                                :ref="'emotion-' + emotion.name"
                                class="popup-emotion w-full h-full rounded-full"
                            />
                            <div>{{ emotion.name }}</div>
                        </div>
                    </div>
                    <input
                        type="text"
                        v-model="newPost.title"
                        class="w-full p-2 mb-4 border rounded"
                    />
                    <quill-editor
                        v-model="newPost.content"
                        class="h-40 mb-4 border"
                    ></quill-editor>
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
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import anime from "animejs/lib/anime.es.js";

import BackButton from "./BackButton.vue";

export default {
    components: {
        BackButton,
        QuillEditor,
    },
    data() {
        return {
            newPost: {
                title: "",
                content: "",
                //TODO: Add img & emotion
            },
            isPopupVisible: false,
            isDropdownVisible: false,
            selectedEmotion: null,
            popupSelectedEmotion: null,
            posts: [
                {
                    id: 1,
                    emotion: {
                        name: "Happy",
                        icon: "/svg/happy_bubble.svg",
                    },
                    title: "Lorem ipsum odor amet",
                    content:
                        "Lorem ipsum odor amet, consectetuer adipiscing elit. Aliquam viverra turpis sem justo nibh senectus amet. Taciti senectus pretium mauris rhoncus tristique duis tempus lacus? Eu aliquet maecenas at feugiat penatibus leo. Tincidunt sodales libero odio ante lacinia nascetur molestie donec. Eget a curabitur metus taciti risus iaculis dui scelerisque. Lacinia sociosqu elementum congue suspendisse est litora at; phasellus fringilla. Interdum blandit sit tempor imperdiet vivamus phasellus.",
                    image: "/images/test1.jpeg",
                },
                {
                    id: 2,
                    emotion: {
                        name: "Calm",
                        icon: "/svg/calm_bubble.svg",
                    },
                    title: "Lorem ipsum odor amet",
                    content:
                        "Lorem ipsum odor amet, consectetuer adipiscing elit. Aliquam viverra turpis sem justo nibh senectus amet. Taciti senectus pretium mauris rhoncus tristique duis tempus lacus? Eu aliquet maecenas at feugiat penatibus leo. Tincidunt sodales libero odio ante lacinia nascetur molestie donec. Eget a curabitur metus taciti risus iaculis dui scelerisque. Lacinia sociosqu elementum congue suspendisse est litora at; phasellus fringilla. Interdum blandit sit tempor imperdiet vivamus phasellus.",
                    image: "/images/test2.jpeg",
                },
                {
                    id: 3,
                    emotion: {
                        name: "Sad",
                        icon: "/svg/sad_bubble.svg",
                    },
                    title: "Lorem ipsum odor amet",
                    content:
                        "Lorem ipsum odor amet, consectetuer adipiscing elit. Aliquam viverra turpis sem justo nibh senectus amet. Taciti senectus pretium mauris rhoncus tristique duis tempus lacus? Eu aliquet maecenas at feugiat penatibus leo. Tincidunt sodales libero odio ante lacinia nascetur molestie donec. Eget a curabitur metus taciti risus iaculis dui scelerisque. Lacinia sociosqu elementum congue suspendisse est litora at; phasellus fringilla. Interdum blandit sit tempor imperdiet vivamus phasellus.",
                    image: "/images/test3.jpeg",
                },
                {
                    id: 4,
                    emotion: {
                        name: "Happy",
                        icon: "/svg/happy_bubble.svg",
                    },
                    title: "Lorem ipsum odor amet",
                    content:
                        "Lorem ipsum odor amet, consectetuer adipiscing elit. Aliquam viverra turpis sem justo nibh senectus amet. Taciti senectus pretium mauris rhoncus tristique duis tempus lacus? Eu aliquet maecenas at feugiat penatibus leo. Tincidunt sodales libero odio ante lacinia nascetur molestie donec. Eget a curabitur metus taciti risus iaculis dui scelerisque. Lacinia sociosqu elementum congue suspendisse est litora at; phasellus fringilla. Interdum blandit sit tempor imperdiet vivamus phasellus.",
                    image: "/images/test4.jpeg",
                },
                {
                    id: 7,
                    emotion: {
                        name: "Angry",
                        icon: "/svg/angry_bubble.svg",
                    },
                    title: "Lorem ipsum odor amet",
                    content:
                        "Lorem ipsum odor amet, consectetuer adipiscing elit. Aliquam viverra turpis sem justo nibh senectus amet. Taciti senectus pretium mauris rhoncus tristique duis tempus lacus? Eu aliquet maecenas at feugiat penatibus leo. Tincidunt sodales libero odio ante lacinia nascetur molestie donec. Eget a curabitur metus taciti risus iaculis dui scelerisque. Lacinia sociosqu elementum congue suspendisse est litora at; phasellus fringilla. Interdum blandit sit tempor imperdiet vivamus phasellus.",
                    image: "",
                },
                {
                    id: 5,
                    emotion: {
                        name: "Calm",
                        icon: "/svg/calm_bubble.svg",
                    },
                    title: "Lorem ipsum odor amet",
                    content:
                        "Lorem ipsum odor amet, consectetuer adipiscing elit. Aliquam viverra turpis sem justo nibh senectus amet. Taciti senectus pretium mauris rhoncus tristique duis tempus lacus? Eu aliquet maecenas at feugiat penatibus leo. Tincidunt sodales libero odio ante lacinia nascetur molestie donec. Eget a curabitur metus taciti risus iaculis dui scelerisque. Lacinia sociosqu elementum congue suspendisse est litora at; phasellus fringilla. Interdum blandit sit tempor imperdiet vivamus phasellus.",
                    image: "/images/test5.jpeg",
                },
                {
                    id: 6,
                    emotion: {
                        name: "Sad",
                        icon: "/svg/sad_bubble.svg",
                    },
                    title: "Lorem ipsum odor amet",
                    content:
                        "Lorem ipsum odor amet, consectetuer adipiscing elit. Aliquam viverra turpis sem justo nibh senectus amet. Taciti senectus pretium mauris rhoncus tristique duis tempus lacus? Eu aliquet maecenas at feugiat penatibus leo. Tincidunt sodales libero odio ante lacinia nascetur molestie donec. Eget a curabitur metus taciti risus iaculis dui scelerisque. Lacinia sociosqu elementum congue suspendisse est litora at; phasellus fringilla. Interdum blandit sit tempor imperdiet vivamus phasellus.",
                    image: "/images/test6.jpeg",
                },
                // Add more posts here
            ],
            dropdownList: [
                { name: "Happy", icon: "/svg/happy_bubble.svg" },
                { name: "Calm", icon: "/svg/calm_bubble.svg" },
                { name: "Sad", icon: "/svg/sad_bubble.svg" },
                { name: "Angry", icon: "/svg/angry_bubble.svg" },
            ],
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
                (post) => post.emotion.name === this.selectedEmotion.name
            );
        },
    },
    methods: {
        submitPost() {
            // TODO: complete the function
        },
        togglePopup() {
            this.isPopupVisible = !this.isPopupVisible;
            this.popupSelectedEmotion = null;
        },
        toggleDropdown() {
            this.isDropdownVisible = !this.isDropdownVisible;
        },
        selectEmotion(emotionName) {
            this.selectedEmotion =
                this.emotions.find((emotion) => emotion.name === emotionName) ||
                null;
        },
        animatePopupEmotion(emotion) {
            this.popupSelectedEmotion = emotion;
            const element = this.$refs["emotion-" + emotion.name];
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
