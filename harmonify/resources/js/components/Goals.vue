<template>
    <section class="page flex flex-col items-center mt-4">
        <div class="fixedChart">
            <v-progress-circular
                :model-value="value"
                :size="200"
                :width="30"
                color="#b28666"
                class="relative"
                style="top: -40px"
            >
                <template v-slot:default>
                    <span class="font-bold">{{ value }} % </span></template
                >
            </v-progress-circular>
        </div>
        <p
            class="text-4 font-bold text-[#b28666] relative underline"
            style="top: -60px"
        >
            To-Do-List
        </p>
        <div class="scrollToDo w-full relative" style="top: -30px">
            <ul>
                <li
                    v-for="(task, index) in toDo"
                    :key="index"
                    class="relative mx-5 mt-3"
                >
                    <input
                        type="checkbox"
                        v-model="task.completed"
                        @change="updateProgress"
                        class="text-4 font-bold text-[#b28666] mx-2 relative"
                    />
                    <span :class="{ completed: task.completed }">{{
                        task.name
                    }}</span>
                    <button
                        v-if="isEditing"
                        @click="deleteTask(index)"
                        class="text-red mx-2"
                    >
                        Delete
                    </button>
                </li>
            </ul>
        </div>
        <div class="fixedBottom w-1/4 flex items-center justify-center mt-4">
            <button
                @click="addTask"
                class="bg-[#b28666] text-4 text-white font-bold py-2 px-4 m-2 rounded-3xl hover:bg-[#8c6950]"
            >
                +
            </button>
            <input
                v-model="newTask"
                placeholder="Add a New Task"
                class="bg-white border px-3 py-2 mr-2 rounded"
            />
            <button
                @click="toggleEdit"
                class="bg-[#b28666] text-4 text-white font-bold py-2 px-4 rounded-3xl hover:bg-[#8c6950]"
            >
                {{ isEditing ? "Done" : "Edit" }}
            </button>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            toDo: [],
            newTask: "",
            value: 0,
            isEditing: false,
        };
    },

    methods: {
        updateProgress() {
            if (this.toDo.length === 0) {
                this.value = 0;
            } else {
                const completedTasks = this.addCount();
                this.value = (
                    (completedTasks / this.toDo.length) *
                    100
                ).toFixed(0);
            }
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
        addTask() {
            if (this.newTask) {
                this.toDo.push({ name: this.newTask, completed: false });
                this.newTask = "";
                this.updateProgress();
            }
        },
        deleteTask(index) {
            this.toDo.splice(index, 1);
            this.updateProgress();
        },
        toggleEdit() {
            this.isEditing = !this.isEditing;
        },
    },
};
</script>

<style scoped>
.fixedChart {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    bottom: 1rem;
    z-index: 9;
    padding: 1rem;
}

.fixedBottom {
    position: absolute;
    bottom: 1.2rem;
    padding: 1rem;
    z-index: 9;
    margin-top: 0;
}

.scrollToDo {
    max-height: 220px;
    overflow-y: auto;
    width: 110%;
    padding: 1rem 1rem 0.5rem;
    box-sizing: border-box;
}

.completed {
    text-decoration: line-through;
    color: gray;
}

.v-progress-circular {
    margin: 2rem;
}
</style>
