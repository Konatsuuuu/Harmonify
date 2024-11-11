<template>
    <div class="flex justify-center">
        <v-progress-circular
            :model-value="value"
            :size="200"
            :width="30"
            color="teal"
            @click="onClick"
        >
            <template v-slot:default> {{ value }} % </template>
        </v-progress-circular>
    </div>
</template>

<script>
export default {
    data() {
        return {
            value: 0,
        };
    },
    methods: {
        onClick(event) {
            const rect = event.target.getBoundingClientRect();
            const x = event.clientX - rect.left - rect.width / 2;
            const y = event.clientY - rect.top - rect.height / 2;

            const angle = (Math.atan2(y, x) * (180 / Math.PI) + 90 + 360) % 360;
            this.value = Math.round((angle / 360) * 100);
        },
    },
};
</script>

<style scoped>
.v-progress-circular {
    margin: 2rem;
}
</style>
