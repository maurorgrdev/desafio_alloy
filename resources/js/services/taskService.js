import axios from 'axios';

const API_BASE_URL = '/api';

export const taskService = {
    async fetchTasks() {
        const response = await axios.get(`${API_BASE_URL}/tasks`);
        return response.data;
    },

    async fetchTask(id) {
        const response = await axios.get(`${API_BASE_URL}/tasks/${id}`);
        return response.data;
    },

    async createTask(task) {
        const response = await axios.post(`${API_BASE_URL}/tasks`, task);
        return response.data;
    },

    async updateTask(id, task) {
        const response = await axios.put(`${API_BASE_URL}/tasks/${id}`, task);
        return response.data;
    },

    async deleteTask(id) {
        const response = await axios.delete(`${API_BASE_URL}/tasks/${id}`);
        return response.data;
    },

    async toggleTask(id) {
        const response = await axios.patch(`${API_BASE_URL}/tasks/${id}/toggle`);
        return response.data;
    }
}; 