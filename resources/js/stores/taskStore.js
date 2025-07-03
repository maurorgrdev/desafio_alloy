import { defineStore } from 'pinia';
import { taskService } from '@/services/taskService';

export const useTaskStore = defineStore('tasks', {
  state: () => ({
    tasks: [],
    loading: false,
    currentTask: null,
  }),
  actions: {
    async fetchTasks() {
      this.loading = true;
      try {
        const response = await taskService.fetchTasks();
        this.tasks = response.data || response;
      } finally {
        this.loading = false;
      }
    },
    async fetchTask(id) {
      this.loading = true;
      try {
        const response = await taskService.fetchTask(id);
        this.currentTask = response.data || response;
        return this.currentTask;
      } finally {
        this.loading = false;
      }
    },
    async createTask(task) {
      await taskService.createTask(task);
    },
    async updateTask(id, task) {
      await taskService.updateTask(id, task);
    },
    async deleteTask(id) {
      await taskService.deleteTask(id);
    },
    async toggleTask(id) {
      await taskService.toggleTask(id);
    },
  },
});