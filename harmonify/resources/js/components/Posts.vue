<template>
    <div
        class="backgroundImg flex items-center justify-center min-h-screen bg-cover overflow-hidden"
    >
        <div
            class="glassmorphism w-[93%] h-[88vh] p-5 flex flex-col text-[#50858B]"
        >
            <div class="flex items-center mb-3 ml-4 space-x-3 text-[#50858B]">
                <BackButton />
                <p class="text-3xl font-bold">Posts</p>
            </div>
        </div>
    </div>
</template>

<script>
import BackButton from "./BackButton.vue";

export default {
    components: {
        BackButton,
    },
};
</script>
