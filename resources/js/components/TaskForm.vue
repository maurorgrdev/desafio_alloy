<script setup>
import { ref, watch } from 'vue';
import { useTaskStore } from '@/stores/taskStore';

const emit = defineEmits(['added', 'cancel']);

const taskStore = useTaskStore();

const nome = ref('');
const descricao = ref('');
const dataLimite = ref('');
const formLoading = ref(false);
const formError = ref('');

const resetForm = () => {
    nome.value = '';
    descricao.value = '';
    dataLimite.value = '';
    formError.value = '';
};

function formatDateTimeLocalToBackend(dt) {
  if (!dt) return null;
  // dt: "2024-07-10T18:00"
  return dt.replace('T', ' ') + ':00'; // "2024-07-10 18:00:00"
}

const props = defineProps({
    task: Object, // tarefa para edição (opcional)
});

// Preenche os campos quando uma tarefa é passada para edição
watch(
    () => props.task,
    (newTask) => {
        if (newTask) {
            nome.value = newTask.nome || '';
            descricao.value = newTask.descricao || '';
            dataLimite.value = newTask.data_limite
                ? newTask.data_limite.replace(' ', 'T').slice(0, 16)
                : '';
        } else {
            resetForm();
        }
    },
    { immediate: true }
);

const handleSubmit = async () => {
    console.log('TaskForm: handleSubmit chamado');
    formError.value = '';
    if (!nome.value.trim()) {
        formError.value = 'O nome da tarefa é obrigatório.';
        return;
    }
    formLoading.value = true;
    try {
        const payload = {
            nome: nome.value,
            descricao: descricao.value,
            data_limite: formatDateTimeLocalToBackend(dataLimite.value) || null,
        };
        console.log('TaskForm: payload para', props.task ? 'update' : 'add', ':', payload);
        
        if (props.task) {
            await taskStore.updateTask(props.task.id, payload);
        } else {
            await taskStore.createTask(payload);
        }
        resetForm();
        emit('added');
    } catch (e) {
        formError.value = 'Erro ao salvar tarefa.';
        console.log('TaskForm: erro ao salvar:', e);
    } finally {
        formLoading.value = false;
    }
};
</script>

<template>
    <form @submit.prevent="handleSubmit" class="task-form">
        <div class="form-group">
            <label class="form-label">Nome *</label>
            <input 
                v-model="nome" 
                type="text" 
                class="form-input" 
                required 
                placeholder="Digite o nome da tarefa"
            />
        </div>
        
        <div class="form-group">
            <label class="form-label">Descrição</label>
            <textarea 
                v-model="descricao" 
                class="form-textarea" 
                rows="3"
                placeholder="Digite uma descrição (opcional)"
            ></textarea>
        </div>
        
        <div class="form-group">
            <label class="form-label">Data Limite</label>
            <input 
                v-model="dataLimite" 
                type="datetime-local" 
                class="form-input"
            />
        </div>
        
        <div v-if="formError" class="form-error">{{ formError }}</div>
        
        <div class="form-actions">
            <button 
                type="button" 
                @click="$emit('cancel')" 
                class="btn btn-secondary"
            >
                Cancelar
            </button>
            <button 
                type="submit" 
                :disabled="formLoading" 
                class="btn btn-primary"
            >
                {{ formLoading ? 'Salvando...' : (task ? 'Atualizar' : 'Adicionar') }}
            </button>
        </div>
    </form>
</template>

<style scoped>
.task-form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 0.375rem;
}

.form-label {
  font-weight: 600;
  color: #374151;
  font-size: 0.875rem;
}

.form-input,
.form-textarea {
  width: 100%;
  padding: 0.75rem;
  border: 2px solid #e5e7eb;
  border-radius: 0.5rem;
  font-size: 0.875rem;
  transition: all 0.2s ease;
  background-color: white;
}

.form-input:focus,
.form-textarea:focus {
  outline: none;
  border-color: #ef4444;
  box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

.form-input::placeholder,
.form-textarea::placeholder {
  color: #9ca3af;
}

.form-textarea {
  resize: vertical;
  min-height: 60px;
  max-height: 120px;
}

.form-error {
  color: #dc2626;
  font-size: 0.875rem;
  background-color: #fef2f2;
  border: 1px solid #fecaca;
  padding: 0.75rem;
  border-radius: 0.5rem;
}

.form-actions {
  display: flex;
  gap: 0.75rem;
  justify-content: flex-end;
  padding-top: 0.5rem;
  margin-top: 0.5rem;
  border-top: 1px solid #e5e7eb;
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
  min-width: 100px;
}

.btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

.btn-secondary {
  background-color: #f3f4f6;
  color: #374151;
}

.btn-secondary:hover:not(:disabled) {
  background-color: #e5e7eb;
}

.btn-primary {
  background-color: #ef4444;
  color: white;
}

.btn-primary:hover:not(:disabled) {
  background-color: #dc2626;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

.btn-primary:active:not(:disabled) {
  transform: translateY(0);
}

/* Responsividade */
@media (max-width: 640px) {
  .form-actions {
    flex-direction: column;
  }
  
  .btn {
    width: 100%;
  }
}
</style> 