# 🏗️ Arquitetura do projeto

## 📁 Estrutura de Pastas

```
testealloylaravel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── TaskController.php          # Controller principal
│   │   └── Middleware/
│   │       └── CacheMiddleware.php         # Middleware de cache
│   ├── Jobs/
│   │   └── DeleteCompletedTask.php         # Job de exclusão automática
│   ├── Models/
│   │   └── Task.php                        # Model da tarefa
│   ├── Observers/
│   │   └── TaskObserver.php                # Observer para eventos
│   └── Providers/
│       └── AppServiceProvider.php          # Registro de observers
├── database/
│   ├── migrations/
│   │   └── 2024_01_01_000000_create_tasks_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── TaskSeeder.php
├── resources/
│   ├── js/
│   │   ├── components/
│   │   │   ├── TaskList.vue                # Lista principal
│   │   │   ├── TaskModal.vue               # Modal de criação/edição
│   │   │   ├── TaskForm.vue                # Formulário
│   │   │   ├── Appbar.vue                  # Cabeçalho
│   │   │   └── Footer.vue                  # Rodapé
│   │   ├── services/
│   │   │   └── taskService.js              # Comunicação com API
│   │   ├── stores/
│   │   │   └── taskStore.js                # Store Pinia
│   │   └── App.vue                         # Componente principal
│   └── css/
│       ├── app.css                         # CSS principal
│       └── alloy-tests.webflow.css         # CSS do design
├── routes/
│   └── api.php                             # Rotas da API
├── bootstrap/
│   └── app.php                             # Configuração de middleware
└── docs/                                   # Documentação
```

## 🏛️ Padrões Arquiteturais

### **1. MVC (Model-View-Controller)**

#### **Model (Task.php)**
```php
class Task extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'nome', 'descricao', 'finalizado', 'data_limite'
    ];
    
    protected $casts = [
        'finalizado' => 'boolean',
        'data_limite' => 'datetime',
    ];
}
```

**Responsabilidades:**
- ✅ Definição da estrutura de dados
- ✅ Relacionamentos (se houver)
- ✅ Casts e mutators
- ✅ Soft deletes

#### **Controller (TaskController.php)**
```php
class TaskController extends Controller
{
    public function index(): JsonResponse
    public function store(Request $request): JsonResponse
    public function show(Task $task): JsonResponse
    public function update(Request $request, Task $task): JsonResponse
    public function destroy(Task $task): JsonResponse
    public function toggle(Task $task): JsonResponse
}
```

**Responsabilidades:**
- ✅ Receber requisições HTTP
- ✅ Validar dados de entrada
- ✅ Orquestrar operações
- ✅ Retornar respostas JSON

#### **View (Vue.js Components)**
```vue
<!-- TaskList.vue -->
<template>
  <div class="tasks-container">
    <!-- Interface do usuário -->
  </div>
</template>
```

**Responsabilidades:**
- ✅ Apresentar dados ao usuário
- ✅ Capturar interações
- ✅ Gerenciar estado local

### **2. Observer Pattern**

#### **TaskObserver.php**
```php
class TaskObserver
{
    public function updated(Task $task): void
    public function deleted(Task $task): void
    public function created(Task $task): void
}
```

**Responsabilidades:**
- ✅ Escutar eventos do Model
- ✅ Disparar jobs automaticamente
- ✅ Limpar cache em modificações

### **3. Service Layer**

#### **taskService.js**
```javascript
export const taskService = {
    async fetchTasks() { /* ... */ },
    async createTask(task) { /* ... */ },
    async updateTask(id, task) { /* ... */ },
    async deleteTask(id) { /* ... */ },
    async toggleTask(id) { /* ... */ }
};
```

**Responsabilidades:**
- ✅ Comunicação com API
- ✅ Tratamento de respostas
- ✅ Centralização de chamadas HTTP

### **4. State Management (Pinia)**

#### **taskStore.js**
```javascript
export const useTaskStore = defineStore('tasks', {
  state: () => ({
    tasks: [],
    loading: false,
    currentTask: null,
  }),
  actions: {
    async fetchTasks() { /* ... */ },
    async createTask(task) { /* ... */ },
    // ...
  }
});
```

**Responsabilidades:**
- ✅ Gerenciar estado global
- ✅ Sincronizar com backend
- ✅ Cache local de dados

## 🔄 Fluxo de Dados

### **1. Criação de Tarefa**
```
Frontend → taskService → API → TaskController → Task Model → Database
                ↓
            taskStore ← Response ← JSON Response
```

### **2. Marcação como Finalizada**
```
Frontend → taskService → API → TaskController → Task Model → Database
                                                      ↓
                                                TaskObserver → Job Queue
                                                      ↓
                                                10 min delay → Delete Job
```

### **3. Cache de Requisições GET**
```
Request → CacheMiddleware → Cache Check → Controller (if miss)
                ↓
            JSON Response ← Cache Store
```

## 🎯 Decisões Técnicas

### **1. Backend**

#### **Laravel 12**
- ✅ **Framework moderno** e robusto
- ✅ **Eloquent ORM** para banco de dados
- ✅ **Sistema de filas** integrado
- ✅ **Cache** com múltiplos drivers
- ✅ **Validação** automática

#### **SQLite**
- ✅ **Simplicidade** de configuração
- ✅ **Portabilidade** do projeto
- ✅ **Performance** adequada para o projeto
- ✅ **Zero configuração** adicional

#### **Observer Pattern**
- ✅ **Separação de responsabilidades**
- ✅ **Código limpo** no Model
- ✅ **Fácil manutenção**
- ✅ **Padrão Laravel**

### **2. Frontend**

#### **Vue.js 3**
- ✅ **Framework moderno** e reativo
- ✅ **Composition API** para lógica reutilizável
- ✅ **Performance** otimizada
- ✅ **Ecosystem** rico

#### **Pinia**
- ✅ **State management** moderno
- ✅ **TypeScript** support
- ✅ **DevTools** integradas
- ✅ **Simplicidade** de uso

#### **CSS Puro**
- ✅ **Controle total** sobre estilos
- ✅ **Sem dependências** externas
- ✅ **Performance** otimizada
- ✅ **Manutenibilidade** alta

### **3. Cache**

#### **File Driver**
- ✅ **Simplicidade** de configuração
- ✅ **Funciona** em qualquer ambiente
- ✅ **Persistência** entre reinicializações
- ✅ **Sem dependências** externas

#### **Middleware Approach**
- ✅ **Transparente** para controllers
- ✅ **Graceful degradation**
- ✅ **Fácil** de configurar
- ✅ **Reutilizável**

### **4. Filas**

#### **Database Driver**
- ✅ **Simplicidade** de configuração
- ✅ **Persistência** de jobs
- ✅ **Monitoramento** fácil
- ✅ **Sem dependências** externas

## 🔧 Configurações

### **1. Middleware**
```php
// bootstrap/app.php
$middleware->alias([
    'cache' => \App\Http\Middleware\CacheMiddleware::class,
]);
```

### **2. Observers**
```php
// AppServiceProvider.php
public function boot(): void
{
    Task::observe(TaskObserver::class);
}
```

### **3. Rotas**
```php
// routes/api.php
Route::middleware('cache')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::get('/tasks/{task}', [TaskController::class, 'show']);
});

Route::post('/tasks', [TaskController::class, 'store']);
Route::put('/tasks/{task}', [TaskController::class, 'update']);
Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggle']);
```

## 🚀 Performance

### **1. Otimizações Implementadas**
- ✅ **Cache** para requisições GET
- ✅ **Índices** no banco de dados
- ✅ **Lazy loading** de componentes
- ✅ **Graceful degradation** para cache

### **2. Monitoramento**
- ✅ **Logs** detalhados
- ✅ **Queue monitoring**
- ✅ **Cache status**
- ✅ **Error tracking**

## 🔒 Segurança

### **1. Validação**
- ✅ **Backend validation** com Laravel
- ✅ **Frontend validation** com Vue.js
- ✅ **CSRF protection** automática
- ✅ **SQL injection** prevention

### **2. Sanitização**
- ✅ **Input sanitization** automática
- ✅ **XSS protection** com Vue.js
- ✅ **Output escaping** automática

## 📈 Escalabilidade

### **1. Horizontal**
- ✅ **Stateless** API
- ✅ **Cache** distribuído
- ✅ **Queue** workers múltiplos

### **2. Vertical**
- ✅ **Database** indexing
- ✅ **Cache** optimization
- ✅ **Code** optimization

---

**Arquitetura: ✅ ROBUSTA, ESCALÁVEL E MANUTENÍVEL** 