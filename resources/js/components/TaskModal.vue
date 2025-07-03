<script setup>
import { ref, watch } from 'vue';
import TaskForm from './TaskForm.vue';

const props = defineProps({
  show: Boolean,
  task: Object,
});

const emit = defineEmits(['close', 'saved']);

const handleClose = () => {
  emit('close');
};

const handleSaved = () => {
  emit('saved');
  handleClose();
};

// Fechar modal com ESC
const handleKeydown = (event) => {
  if (event.key === 'Escape') {
    handleClose();
  }
};

// Adicionar listener quando modal abrir
watch(() => props.show, (newValue) => {
  if (newValue) {
    document.addEventListener('keydown', handleKeydown);
  } else {
    document.removeEventListener('keydown', handleKeydown);
  }
});
</script>

<template>
  <Transition name="modal">
    <div v-if="show" class="modal-overlay">
      <div class="modal-container">
        <!-- Header -->
        <div class="modal-header">
          <h3 class="modal-title">
            {{ task ? 'Editar Tarefa' : 'Nova Tarefa' }}
          </h3>
          <button 
            @click="handleClose" 
            class="modal-close-btn"
            title="Fechar"
          >
            <svg class="close-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
        
        <!-- Content -->
        <div class="modal-content">
          <TaskForm
            :task="task"
            @added="handleSaved"
            @cancel="handleClose"
          />
        </div>
      </div>
    </div>
  </Transition>
</template>

<style scoped>
/* CSS puro para garantir que funcione */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.7);
  backdrop-filter: blur(4px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 9999;
  padding: 0.5rem;
  overflow-y: auto;
}

.modal-container {
  background-color: white;
  border-radius: 0.5rem;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
  max-width: 26rem;
  width: 100%;
  max-height: 95vh;
  overflow-y: auto;
  overflow-x: hidden;
  margin: auto;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.25rem;
  border-bottom: 1px solid #e5e7eb;
  position: sticky;
  top: 0;
  background-color: white;
  z-index: 1;
}

.modal-title {
  font-size: 1.125rem;
  font-weight: 600;
  color: #111827;
  margin: 0;
}

.modal-close-btn {
  color: #9ca3af;
  background: none;
  border: none;
  cursor: pointer;
  padding: 0.25rem;
  border-radius: 0.25rem;
  transition: color 0.2s;
  flex-shrink: 0;
}

.modal-close-btn:hover {
  color: #4b5563;
}

.close-icon {
  width: 1.5rem;
  height: 1.5rem;
}

.modal-content {
  padding: 1.25rem;
  min-height: 200px;
  overflow-x: hidden;
}

/* Animações */
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}

.modal-enter-active .modal-container,
.modal-leave-active .modal-container {
  transition: transform 0.3s ease;
}

.modal-enter-from .modal-container,
.modal-leave-to .modal-container {
  transform: scale(0.9);
}
</style> 