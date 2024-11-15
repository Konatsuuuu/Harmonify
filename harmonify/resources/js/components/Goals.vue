<template>
    <section class="page flex flex-col items-center mt-4">
        <div class="fixedChart">
            <v-progress-circular :model-value="value" :size="200" :width="30" color="#b28666" class="relative"
                style="top: -40px">
                <template v-slot:default>
                    <span class="font-bold">{{ value }} % </span></template>
            </v-progress-circular>
        </div>
        <p class="text-4 font-bold text-[#b28666] relative underline" style="top: -80px">
            To-Do-List
        </p>
        <div class="scrollToDo w-full relative" style="top: -70px">
            <ul>
                <li v-for="(task, index) in toDo" :key="index" class="relative mx-2 mt-3">
                    <input type="checkbox" v-model="task.completed" @change="updateProgress"
                        class="text-4 font-bold text-[#b28666] mx-2 relative" />
                    <span :class="{ completed: task.completed }">{{
                        task.name
                        }}</span>
                    <button v-if="isEditing" @click="deleteTask(index)" class="text-red mx-2">
                        <svg viewBox="0 0 24 24" fill="none" class="w-6 h-6" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.5001 6H3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            <path
                                d="M18.8332 8.5L18.3732 15.3991C18.1962 18.054 18.1077 19.3815 17.2427 20.1907C16.3777 21 15.0473 21 12.3865 21H11.6132C8.95235 21 7.62195 21 6.75694 20.1907C5.89194 19.3815 5.80344 18.054 5.62644 15.3991L5.1665 8.5"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M9.5 11L10 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            <path d="M14.5 11L14 16" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            <path
                                d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6"
                                stroke="currentColor" stroke-width="1.5" />
                        </svg>
                    </button>
                </li>
            </ul>
        </div>
        <div class="fixedBottom w-1/4 flex items-center justify-center mt-4 scale-95">
            <button @click="addTask"
                class="bg-[#b28666] text-4 text-white font-bold py-2 px-4 m-2 rounded-3xl hover:bg-[#8c6950]">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class=" w-6 h-6">

                    <line fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" x1="12" x2="12" y1="19" y2="5" />

                    <line fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" x1="5" x2="19" y1="12" y2="12" />
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
                <div v-else>
                    Done
                </div>
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
.fixedChart,
.fixedBottom {
    display: flex;
    align-items: center;
    position: relative;
    padding: 1rem;
    z-index: 9;
}

.fixedChart {
    flex-direction: column;
    bottom: 1rem;
}

.fixedBottom {
    position: absolute;
    bottom: 1.2rem;
    margin-top: 0;
}

.scrollToDo {
    max-height: 270px;
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

.scrollToDo input[type="checkbox"] {
    appearance: none;
    width: 20px;
    height: 20px;
    border: 2px solid #d0b29f;
    border-radius: 4px;
    background-color: white;
    transition: all 0.3s ease;
    cursor: pointer;
}

.scrollToDo ul li button {
    position: relative;
    top: 0;
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
