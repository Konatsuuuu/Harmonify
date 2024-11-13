<template>
    <div class="flex flex-1 mb-4">
        <div class="flex-1 flex flex-col items-center justify-center text-[#b28666] bg-white/30 mr-2 ml-4 rounded-xl">
            Monday
            <div class="w-28 h-28 item-center justify-center mb-6">
                <button type="button" class="flex h-full w-full justify-center">
                    <img src="/public/svg/happy_bubble.svg" alt="Happy Bubble" class="bubble" />
                </button>
            </div>
        </div>
        <div class="flex-1 flex flex-col items-center justify-center bg-white/30 mx-2 rounded-xl">
            Tuesday
            <div class="w-28 h-28 item-center justify-center mb-6">
                <button type="button" class="flex h-full w-full justify-center">
                    <img src="/public/svg/smiling_bubble.svg" alt="Smiling Bubble" class="bubble" />
                </button>
            </div>
        </div>
        <div class="flex-1 flex flex-col items-center justify-center bg-white/30 mr-4 ml-2 rounded-xl">
            Wednesday
            <div class="w-28 h-28 item-center justify-center mb-6">
                <button type="button" class="flex h-full w-full justify-center">
                    <img src="/public/svg/sad_bubble.svg" alt="Sad Bubble" class="bubble" />
                </button>
            </div>
        </div>
    </div>
    <div class="flex flex-1 mb-4">
        <div class="flex-1 flex flex-col items-center justify-center bg-white/30 mr-2 ml-4 rounded-xl">
            Thursday
            <div class="w-28 h-28 item-center justify-center mb-6">
                <button type="button" class="flex h-full w-full justify-center">
                    <img src="/public/svg/angry_bubble.svg" alt="Angry Bubble" class="bubble" />
                </button>
            </div>
        </div>
        <div class="flex-1 flex flex-col items-center justify-center bg-white/30 mx-2 rounded-xl">
            Friday
            <div class="w-28 h-28 item-center justify-center mb-6">
                <button type="button" class="flex h-full w-full justify-center">
                    <img src="/public/svg/sad_bubble.svg" alt="Sad Bubble" class="bubble" />
                </button>
            </div>
        </div>
        <div class="flex-1 flex flex-col items-center justify-center bg-white/30 mr-4 ml-2 rounded-xl">
            Saturday
            <div class="w-28 h-28 item-center justify-center mb-6">
                <button type="button" class="flex h-full w-full justify-center">
                    <img src="/public/svg/happy_bubble.svg" alt="Happy Bubble" class="bubble" />
                </button>
            </div>
        </div>
    </div>
    <div class="flex flex-1 mb-4">
        <div class="flex-1 flex flex-col items-start justify-center mr-2 ml-4"></div>
        <div class="flex-1 flex flex-col items-center justify-center bg-white/30 mx-2 rounded-xl">
            Sunday
            <div class="w-28 h-28 item-center justify-center mb-6">
                <button type="button" class="flex h-full w-full justify-center">
                    <img src="/public/svg/happy_bubble.svg" alt="Happy Bubble" class="bubble" />
                </button>
            </div>
        </div>
        <div class="flex-1 flex items-end justify-end mr-4 ml-2 mb-4">
            <ExpandCalendar />
        </div>
    </div>
</template>

<script>
import ExpandCalendar from "./ExpandCalendar.vue";

export default {
    components: {
        ExpandCalendar,
    },
};
</script>
