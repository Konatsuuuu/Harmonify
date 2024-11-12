<template>
    <div
        class="backgroundImg flex items-center justify-center min-h-screen bg-cover overflow-hidden"
    >
        <div
            class="glassmorphism w-[93%] h-[88vh] p-5 flex flex-col text-[#b28666]"
        >
            <div class="flex items-center mb-3 ml-4 space-x-3 text-[#b28666]">
                <BackButton />
                <p class="text-3xl font-bold">Calendar</p>
            </div>
            <div class="flex w-full h-full items-center justify-center">
                <CalendarMonth />
            </div>
        </div>
    </div>
</template>

<script>
import BackButton from "./BackButton.vue";
import CalendarMonth from "./CalendarMonth.vue";

export default {
    components: {
        BackButton,
        CalendarMonth,
    },
};
</script>
