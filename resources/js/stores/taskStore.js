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
      } finally {
        this.loading = false;
      }
    },

    async createTask(payload) {
      const response = await taskService.create(payload);
      this.tasks.unshift(response.data.data);
    },

    async updateTask(id, payload) {
      const response = await taskService.update(id, payload);
      const index = this.tasks.findIndex(t => t.id === id);
      if (index !== -1) this.tasks[index] = response.data.data;
    },

    async deleteTask(id) {
      await taskService.remove(id);
      this.tasks = this.tasks.filter(t => t.id !== id);
    },

    async toggleTask(id) {
      const response = await taskService.toggle(id);
      const index = this.tasks.findIndex(t => t.id === id);
      if (index !== -1) this.tasks[index] = response.data.data;
    }
  }
});
