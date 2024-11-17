<template>
    <section class="page flex flex-col items-center mt-4">
        <div class="fixedChart">
            <v-progress-circular :model-value="value" :size="200" :width="30" color="#b28666" class="relative"
                style="top: -40px">
                <template #default>
                    <span class="font-bold">{{ value }} %</span>
                </template>
            </v-progress-circular>
        </div>
        <p class="text-4 font-bold text-[#b28666] relative underline" style="top: -80px">To-Do-List</p>
        <div class="scrollToDo w-full relative" style="top: -70px">
            <ul>
                <li v-for="(task, index) in toDo" :key="index" class="relative mx-2 mt-3">
                    <input type="checkbox" v-model="task.completed" @change="updateProgress"
                        class="text-4 font-bold text-[#b28666] mx-2 relative" />
                    <span :class="{ completed: task.completed }">{{ task.name }}</span>
                    <button v-if="isEditing" @click="deleteTask(index)" class="text-red mx-2">
                        <svg viewBox="0 0 24 24" fill="none" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.5 6H3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            <path
                                d="M18.83 8.5l-.46 6.9c-.18 2.65-.27 3.98-1.14 4.79-.86.81-2.2.81-4.86.81h-1.77c-2.66 0-3.99 0-4.86-.81-.86-.81-.95-2.14-1.12-4.79L5.17 8.5"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M9.5 11L10 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M14.5 11L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            <path
                                d="M6.5 6c.06 0 .09 0 .11-.001C7.43 5.978 8.16 5.455 8.44 4.68c.01-.024.02-.05.04-.103l.1-.292c.08-.25.12-.375.17-.48.22-.42.63-.71 1.1-.79.12-.02.25-.02.51-.02h3.29c.26 0 .39 0 .51.02.47.08.87.37 1.09.79.05.105.09.23.17.48l.1.292c.01.024.02.05.04.103.28.775 1.01 1.298 1.83 1.319.03 0 .06 0 .12 0"
                                stroke="currentColor" stroke-width="1.5" />
                        </svg>
                    </button>
                </li>
            </ul>
        </div>
        <div class="fixedBottom w-1/4 flex items-center justify-center mt-4 scale-95">
            <button @click="addTask"
                class="bg-[#b28666] text-4 text-white font-bold py-2 px-4 m-2 rounded-3xl hover:bg-[#8c6950]">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6">
                    <line stroke="currentColor" stroke-width="2" x1="12" x2="12" y1="19" y2="5" />
                    <line stroke="currentColor" stroke-width="2" x1="5" x2="19" y1="12" y2="12" />
                </svg>
            </button>
            <input v-model="newTask" placeholder="Add a New Task" class="bg-white border px-2 py-2 mr-2 rounded" />
            <button @click="toggleEdit"
                class="bg-[#b28666] text-4 text-white font-bold py-2 px-4 rounded-3xl hover:bg-[#8c6950]">
                <div v-if="!isEditing" class="w-6 h-6">
                    <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M21.1213 2.70705C19.9497 1.53548 18.0503 1.53547 16.8787 2.70705L15.1989 4.38685L7.29289 12.2928C7.16473 12.421 7.07382 12.5816 7.02986 12.7574L6.02986 16.7574C5.94466 17.0982 6.04451 17.4587 6.29289 17.707C6.54127 17.9554 6.90176 18.0553 7.24254 17.9701L11.2425 16.9701C11.4184 16.9261 11.5789 16.8352 11.7071 16.707L19.5556 8.85857L21.2929 7.12126C22.4645 5.94969 22.4645 4.05019 21.2929 2.87862L21.1213 2.70705ZM18.2929 4.12126C18.6834 3.73074 19.3166 3.73074 19.7071 4.12126L19.8787 4.29283C20.2692 4.68336 20.2692 5.31653 19.8787 5.70705L18.8622 6.72357L17.3068 5.10738L18.2929 4.12126ZM15.8923 6.52185L17.4477 8.13804L10.4888 15.097L8.37437 15.6256L8.90296 13.5112L15.8923 6.52185ZM4 7.99994C4 7.44766 4.44772 6.99994 5 6.99994H10C10.5523 6.99994 11 6.55223 11 5.99994C11 5.44766 10.5523 4.99994 10 4.99994H5C3.34315 4.99994 2 6.34309 2 7.99994V18.9999C2 20.6568 3.34315 21.9999 5 21.9999H16C17.6569 21.9999 19 20.6568 19 18.9999V13.9999C19 13.4477 18.5523 12.9999 18 12.9999C17.4477 12.9999 17 13.4477 17 13.9999V18.9999C17 19.5522 16.5523 19.9999 16 19.9999H5C4.44772 19.9999 4 19.5522 4 18.9999V7.99994Z"
                            fill="currentColor" />
                    </svg>
                </div>
                <div v-else>Done</div>
            </button>
        </div>
    </section>
</template>

<script>
export default {
    data: () => ({
        toDo: [],
        newTask: "",
        value: 0,
        isEditing: false,
    }),
    methods: {
        updateProgress() {
            this.value = this.toDo.length ? ((this.addCount() / this.toDo.length) * 100).toFixed(0) : 0;
        },
        addCount() {
            return this.toDo.filter(task => task.completed).length;
        },
        addTask() {
            if (this.newTask) this.toDo.push({ name: this.newTask, completed: false }), this.newTask = "", this.updateProgress();
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
    align-items: center;
    padding: 1rem;
    z-index: 9;
    flex-direction: column;
    bottom: 1rem;
    margin-bottom: 2rem;
}

.fixedBottom {
    display: flex;
    align-items: center;
    padding: 1rem;
    z-index: 9;
    position: absolute;
    bottom: 1.2rem;
}

.scrollToDo {
    max-height: 270px;
    overflow-y: auto;
    width: 110%;
    padding: 1rem 1rem 0.5rem;
}

.completed {
    text-decoration: line-through;
    color: gray;
}

.v-progress-circular {
    margin: 2rem auto;
}

.scrollToDo input[type="checkbox"] {
    appearance: none;
    width: 20px;
    height: 20px;
    border: 2px solid #d0b29f;
    border-radius: 4px;
    transition: 0.3s ease;
    cursor: pointer;
}

.scrollToDo ul li button {
    vertical-align: middle;
    margin-left: 8px;
}

.scrollToDo input[type="checkbox"]:focus {
    outline: 2px solid #b28666;
    box-shadow: 0 0 5px rgba(178, 134, 102, 0.3);
}

.scrollToDo input[type="checkbox"]:checked {
    background-color: #d0b29f;
    border-color: #d0b29f;
}
</style>
