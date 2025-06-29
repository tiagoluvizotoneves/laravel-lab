// resources/js/stores/taskStore.js
import { defineStore } from 'pinia';
import taskService from '../services/taskService';

export const useTaskStore = defineStore('tasks', {
    state: () => ({
        tasks: [],
        loading: false,
    }),

    actions: {
        async fetchTasks() {
            this.loading = true;
            try {
                const response = await taskService.getAll();
                this.tasks = response.data;
                this.sortTasks();
            } finally {
                this.loading = false;
            }
        },

        async createTask(payload) {
            const response = await taskService.create(payload);
            const newTask = response.data.data;

            this.tasks.push(newTask);

            this.sortTasks();
        },

        async updateTask(id, payload) {
            const response = await taskService.update(id, payload);
            const index = this.tasks.findIndex(t => t.id === id);
            if (index !== -1) {
                this.tasks[index] = response.data.data;
                this.sortTasks();
            }
        },

        async deleteTask(id) {
            await taskService.remove(id);
            this.tasks = this.tasks.filter(t => t.id !== id);
        },

        async toggleTask(id) {
            const response = await taskService.toggle(id);
            const index = this.tasks.findIndex(t => t.id === id);
            if (index !== -1) {
                this.tasks[index] = response.data.data;
                this.sortTasks();
            }
        },

        sortTasks() {
            this.tasks.sort((a, b) => {
                const dateA = a.data_limite || a.created_at;
                const dateB = b.data_limite || b.created_at;
                return new Date(dateA) - new Date(dateB);
            });
        }
    }
});
