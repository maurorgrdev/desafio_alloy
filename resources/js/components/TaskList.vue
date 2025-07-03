<script setup>
import { ref, onMounted } from 'vue';
import { useTaskStore } from '@/stores/taskStore';
import { storeToRefs } from 'pinia';
import TaskModal from './TaskModal.vue';

const taskStore = useTaskStore();
const { tasks, loading } = storeToRefs(taskStore);

const showModal = ref(false);
const editTask = ref(null);

const handleAddTask = async (taskData) => {
    await taskStore.createTask(taskData);
};

const handleUpdateTask = async (id, taskData) => {
    await taskStore.updateTask(id, taskData);
};

const handleEdit = (task) => {
    editTask.value = task;
    showModal.value = true;
};

const handleAddNew = () => {
    editTask.value = null;
    showModal.value = true;
};

const handleToggleTask = async (id) => {
    await taskStore.toggleTask(id);
    await taskStore.fetchTasks();
};

const handleDeleteTask = async (id) => {
    if (confirm('Tem certeza que deseja excluir esta tarefa?')) {
        await taskStore.deleteTask(id);
        await taskStore.fetchTasks();
    }
};

const handleModalSaved = async () => {
    showModal.value = false;
    editTask.value = null;
    await taskStore.fetchTasks();
};

const handleModalClose = () => {
    showModal.value = false;
    editTask.value = null;
};

onMounted(() => {
    taskStore.fetchTasks();
});
</script>

<template>
    <div class="tasks-container">
        <div class="tasks-header">
            <h2 class="tasks-title">Tasks</h2>
            <button
                class="btn btn-primary"
                @click="handleAddNew"
            >
                + Adicionar Tarefa
            </button>
        </div>

        <TaskModal
            :show="showModal"
            :task="editTask"
            @saved="handleModalSaved"
            @close="handleModalClose"
        />

        <div v-if="loading" class="loading">Carregando...</div>
        <ul v-else class="tasks-list">
            <li v-for="task in tasks" :key="task.id" class="task-item">
                <div class="task-content">
                    <div class="task-header">
                        <strong class="task-name">{{ task.nome }}</strong>
                        <span v-if="task.finalizado" class="task-status task-completed">Finalizada</span>
                    </div>
                    <div v-if="task.descricao" class="task-description">{{ task.descricao }}</div>
                </div>
                <div class="task-actions">
                    <div v-if="task.data_limite" class="task-deadline">Data limite: {{ task.data_limite }}</div>
                    <div class="task-buttons">
                        <button 
                            @click="handleEdit(task)" 
                            class="action-btn edit-btn"
                            title="Editar"
                        >
                            ✏️
                        </button>
                        <button 
                            @click="handleToggleTask(task.id)" 
                            :class="[
                                'action-btn',
                                task.finalizado ? 'undo-btn' : 'complete-btn'
                            ]"
                            :title="task.finalizado ? 'Desmarcar como finalizada' : 'Marcar como finalizada'"
                        >
                            {{ task.finalizado ? '↩️' : '✅' }}
                        </button>
                        <button 
                            @click="handleDeleteTask(task.id)" 
                            class="action-btn delete-btn"
                            title="Excluir"
                        >
                            🗑️
                        </button>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<style scoped>
.tasks-container {
  max-width: 42rem;
  margin: 2.5rem auto 0;
  padding: 1.5rem;
  background-color: white;
  border-radius: 0.5rem;
  box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
  width: 100%;
  box-sizing: border-box;
}

.tasks-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 2rem;
}

.tasks-title {
  font-size: 1.875rem;
  font-weight: 800;
  color: #1f2937;
  margin: 0;
}

.btn {
  padding: 0.75rem 1.5rem;
  border: none;
  border-radius: 0.5rem;
  font-weight: 600;
  font-size: 0.875rem;
  cursor: pointer;
  transition: all 0.2s ease;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.btn-primary {
  background-color: #ef4444;
  color: white;
}

.btn-primary:hover {
  background-color: #dc2626;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

.loading {
  text-align: center;
  color: #6b7280;
  padding: 2rem 0;
}

.tasks-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  list-style: none;
  padding: 0;
  margin: 0;
}

.task-item {
  width: 100%;
  padding: 1rem;
  background-color: #f9fafb;
  border: 1px solid #e5e7eb;
  border-radius: 0.5rem;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  transition: all 0.2s ease;
}

.task-item:hover {
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transform: translateY(-1px);
}

.task-content {
  flex: 1;
}

.task-header {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 0.25rem;
}

.task-name {
  font-size: 1.125rem;
  color: #111827;
  margin: 0;
}

.task-status {
  padding: 0.25rem 0.5rem;
  font-size: 0.75rem;
  border-radius: 0.25rem;
  font-weight: 500;
}

.task-completed {
  background-color: #dcfce7;
  color: #166534;
}

.task-description {
  color: #6b7280;
  font-size: 0.875rem;
  margin-top: 0.25rem;
  line-height: 1.4;
}

.task-actions {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  justify-content: space-between;
}

.task-deadline {
  font-size: 0.75rem;
  color: #6b7280;
}

.task-buttons {
  display: flex;
  gap: 0.25rem;
}

.action-btn {
  padding: 0.25rem 0.5rem;
  font-size: 0.75rem;
  border: none;
  border-radius: 0.25rem;
  cursor: pointer;
  transition: all 0.2s ease;
  background: none;
}

.edit-btn {
  background-color: #dbeafe;
  color: #1d4ed8;
}

.edit-btn:hover {
  background-color: #bfdbfe;
}

.complete-btn {
  background-color: #dcfce7;
  color: #166534;
}

.complete-btn:hover {
  background-color: #bbf7d0;
}

.undo-btn {
  background-color: #fef3c7;
  color: #d97706;
}

.undo-btn:hover {
  background-color: #fde68a;
}

.delete-btn {
  background-color: #fee2e2;
  color: #dc2626;
}

.delete-btn:hover {
  background-color: #fecaca;
}

@media (min-width: 640px) {
  .task-item {
    flex-direction: row;
    align-items: center;
  }
  
  .task-actions {
    flex-direction: row;
    align-items: center;
  }
}
</style> 