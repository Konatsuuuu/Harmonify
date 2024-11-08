<template>
    <div
        class="backgroundImg flex items-center justify-center min-h-screen bg-cover overflow-hidden"
    >
        <div class="glassmorphism w-[93%] h-[88vh] p-5 flex flex-col">
            <div class="flex justify-between w-full">
                <p class="text-3xl font-bold mb-3 ml-4 text-[#50858B]">
                    Harmonify
                </p>
                <div class="flex space-x-4 text-[#38686e]">
                    <svg
                        class="w-8 h-8 cursor-pointer"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M12.5 2V5.25154C12.5 5.66576 12.8358 6.00154 13.25 6.00154C13.6642 6.00154 14 5.66576 14 5.25154V2H15V6.25112C15 6.66534 15.3358 7.00112 15.75 7.00112C16.1642 7.00112 16.5 6.66534 16.5 6.25112V2H18.2502C18.6645 2 19.0002 2.33579 19.0002 2.75V11H5.00024V2.75C5.00024 2.33579 5.33603 2 5.75024 2H12.5Z"
                            fill="currentColor"
                        />
                        <path
                            d="M5.00024 12.5V14.2521C5.00024 15.4947 6.0076 16.5021 7.25024 16.5021H9.99991V20C9.99991 21.1046 10.8953 22 11.9999 22C13.1045 22 13.9999 21.1046 13.9999 20V16.5021H16.7502C17.9929 16.5021 19.0002 15.4947 19.0002 14.2521V12.5H5.00024Z"
                            fill="currentColor"
                        />
                    </svg>
                    <svg
                        class="w-8 h-8 cursor-pointer"
                        viewBox="0 0 24 24"
                        fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M20.1 9.2214C18.29 9.2214 17.55 7.9414 18.45 6.3714C18.97 5.4614 18.66 4.3014 17.75 3.7814L16.02 2.7914C15.23 2.3214 14.21 2.6014 13.74 3.3914L13.63 3.5814C12.73 5.1514 11.25 5.1514 10.34 3.5814L10.23 3.3914C9.78 2.6014 8.76 2.3214 7.97 2.7914L6.24 3.7814C5.33 4.3014 5.02 5.4714 5.54 6.3814C6.45 7.9414 5.71 9.2214 3.9 9.2214C2.86 9.2214 2 10.0714 2 11.1214V12.8814C2 13.9214 2.85 14.7814 3.9 14.7814C5.71 14.7814 6.45 16.0614 5.54 17.6314C5.02 18.5414 5.33 19.7014 6.24 20.2214L7.97 21.2114C8.76 21.6814 9.78 21.4014 10.25 20.6114L10.36 20.4214C11.26 18.8514 12.74 18.8514 13.65 20.4214L13.76 20.6114C14.23 21.4014 15.25 21.6814 16.04 21.2114L17.77 20.2214C18.68 19.7014 18.99 18.5314 18.47 17.6314C17.56 16.0614 18.3 14.7814 20.11 14.7814C21.15 14.7814 22.01 13.9314 22.01 12.8814V11.1214C22 10.0814 21.15 9.2214 20.1 9.2214ZM12 15.2514C10.21 15.2514 8.75 13.7914 8.75 12.0014C8.75 10.2114 10.21 8.7514 12 8.7514C13.79 8.7514 15.25 10.2114 15.25 12.0014C15.25 13.7914 13.79 15.2514 12 15.2514Z"
                            fill="currentColor"
                        />
                    </svg>
                    <Logout />
                </div>
            </div>
            <div class="flex w-full h-[76vh]">
                <div
                    class="w-1/2 bg-white/30 mr-5 rounded-xl flex flex-col h-full"
                >
                    <p class="text-2xl font-bold m-3 ml-6 text-[#50858B]">
                        Calendar
                    </p>
                    <div
                        class="flex flex-col h-full w-full rounded-lg overflow-hidden text-1xl text-[#50858B]"
                    >
                        <div class="flex flex-1 mb-4">
                            <div
                                class="flex-1 flex flex-col items-center justify-center bg-white/30 mr-2 ml-4 rounded-xl"
                            >
                                Monday
                                <div
                                    class="w-28 h-28 item-center justify-center mb-6"
                                >
                                    <button
                                        type="button"
                                        class="flex h-full w-full justify-center"
                                    >
                                        <img
                                            src="/public/svg/happy_bubble.svg"
                                            alt="Happy Bubble"
                                            class="bubble"
                                        />
                                    </button>
                                </div>
                            </div>
                            <div
                                class="flex-1 flex flex-col items-center justify-center bg-white/30 mx-2 rounded-xl"
                            >
                                Tuesday
                                <div
                                    class="w-28 h-28 item-center justify-center mb-6"
                                >
                                    <button
                                        type="button"
                                        class="flex h-full w-full justify-center"
                                    >
                                        <img
                                            src="/public/svg/smiling_bubble.svg"
                                            alt="Smiling Bubble"
                                            class="bubble"
                                        />
                                    </button>
                                </div>
                            </div>
                            <div
                                class="flex-1 flex flex-col items-center justify-center bg-white/30 mr-4 ml-2 rounded-xl"
                            >
                                Wednesday
                                <div
                                    class="w-28 h-28 item-center justify-center mb-6"
                                >
                                    <button
                                        type="button"
                                        class="flex h-full w-full justify-center"
                                    >
                                        <img
                                            src="/public/svg/sad_bubble.svg"
                                            alt="Sad Bubble"
                                            class="bubble"
                                        />
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-1 mb-4">
                            <div
                                class="flex-1 flex flex-col items-center justify-center bg-white/30 mr-2 ml-4 rounded-xl"
                            >
                                Thursday
                                <div
                                    class="w-28 h-28 item-center justify-center mb-6"
                                >
                                    <button
                                        type="button"
                                        class="flex h-full w-full justify-center"
                                    >
                                        <img
                                            src="/public/svg/angry_bubble.svg"
                                            alt="Angry Bubble"
                                            class="bubble"
                                        />
                                    </button>
                                </div>
                            </div>
                            <div
                                class="flex-1 flex flex-col items-center justify-center bg-white/30 mx-2 rounded-xl"
                            >
                                Friday
                                <div
                                    class="w-28 h-28 item-center justify-center mb-6"
                                >
                                    <button
                                        type="button"
                                        class="flex h-full w-full justify-center"
                                    >
                                        <img
                                            src="/public/svg/sad_bubble.svg"
                                            alt="Sad Bubble"
                                            class="bubble"
                                        />
                                    </button>
                                </div>
                            </div>
                            <div
                                class="flex-1 flex flex-col items-center justify-center bg-white/30 mr-4 ml-2 rounded-xl"
                            >
                                Saturday
                                <div
                                    class="w-28 h-28 item-center justify-center mb-6"
                                >
                                    <button
                                        type="button"
                                        class="flex h-full w-full justify-center"
                                    >
                                        <img
                                            src="/public/svg/happy_bubble.svg"
                                            alt="Happy Bubble"
                                            class="bubble"
                                        />
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-1 mb-4">
                            <div
                                class="flex-1 flex flex-col items-start justify-center mr-2 ml-4"
                            ></div>
                            <div
                                class="flex-1 flex flex-col items-center justify-center bg-white/30 mx-2 rounded-xl"
                            >
                                Sunday
                                <div
                                    class="w-28 h-28 item-center justify-center mb-6"
                                >
                                    <button
                                        type="button"
                                        class="flex h-full w-full justify-center"
                                    >
                                        <img
                                            src="/public/svg/happy_bubble.svg"
                                            alt="Happy Bubble"
                                            class="bubble"
                                        />
                                    </button>
                                </div>
                            </div>
                            <div
                                class="flex-1 flex items-end justify-end mr-4 ml-2 mb-4"
                            >
                                <ExpandCalendar />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-1/4 rounded-xl flex flex-col">
                    <div
                        class="relative h-1/2 bg-white/30 mr-5 mb-5 rounded-xl"
                    >
                        <p class="text-2xl font-bold m-3 ml-6 text-[#50858B]">
                            Posts
                        </p>
                        <div
                            class="absolute flex-1 flex items-end justify-end ml-2 right-0 bottom-4"
                        >
                            <ExpandPosts />
                        </div>
                    </div>
                    <div class="relative h-1/2 bg-white/30 mr-5 rounded-xl">
                        <p class="text-2xl font-bold m-3 ml-6 text-[#50858B]">
                            Sleep Graph
                        </p>
                        <div
                            class="absolute flex-1 flex items-end justify-end ml-2 right-0 bottom-4"
                        >
                            <ExpandSleepGraph />
                        </div>
                    </div>
                </div>

                <div class="w-1/4 rounded-xl flex flex-col">
                    <div class="h-1/2 bg-white/30 mr-5 mb-5 rounded-xl">
                        <p class="text-2xl font-bold m-3 ml-6 text-[#50858B]">
                            Goals
                        </p>
                    </div>
                    <div class="h-1/2 bg-white/30 mr-5 rounded-xl">
                        <p class="text-2xl font-bold m-3 ml-6 text-[#50858B]">
                            Advice
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ExpandCalendar from "./ExpandCalendar.vue";
import Logout from "./Logout.vue";
import ExpandSleepGraph from "./ExpandSleepGraph.vue";
import ExpandPosts from "./ExpandPosts.vue";

export default {
    components: {
        Logout,
        ExpandCalendar,
        ExpandSleepGraph,
        ExpandPosts,
    },
};
</script>
