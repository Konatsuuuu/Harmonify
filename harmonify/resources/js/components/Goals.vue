<template>
    <div class="flex flex-col items-center mt-4">
        <v-progress-circular
            :model-value="value"
            :size="200"
            :width="30"
            color="teal"
            class="relative"
            style="top: -40px"
        >
            <template v-slot:default> {{ value }} % </template>
        </v-progress-circular>

        <p
            class="text-4 font-bold text-[#282e2f] relative underline"
            style="top: -40px"
        >
            To-Do-List
        </p>
        <ul>
            <li
                v-for="(task, index) in toDo"
                :key="index"
                class="relative mx-5 mt-3"
                style="top: -40px"
            >
                <input
                    type="checkbox"
                    v-model="task.completed"
                    @change="updateProgress"
                    class="text-4 font-bold text-[#282e2f] mx-2 relative"
                />
                <span :class="{ completed: task.completed }">{{
                    task.name
                }}</span>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            toDo: [
                { name: "Task 1", completed: false },
                { name: "Task 2", completed: false },
                { name: "Task 3", completed: false },
            ],
            value: 0,
        };
    },

    methods: {
        updateProgress() {
            const completedTasks = this.addCount();
            this.value = ((completedTasks / this.toDo.length) * 100).toFixed(1);
        },
        addCount() {
            let count = 0;
            for (const task of this.toDo) {
                if (task.completed) {
                    count++;
                }
            }
            return count;
        },
    },
};
</script>

<style scoped>
.completed {
    text-decoration: line-through;
    color: gray;
}

.v-progress-circular {
    margin: 2rem;
}
</style>
