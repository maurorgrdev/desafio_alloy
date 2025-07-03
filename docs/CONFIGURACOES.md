# 🔧 Configurações

## 📊 Banco de Dados

### **Configuração Atual (SQLite)**
```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

### **Para usar MySQL/PostgreSQL**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=alloy_tasks
DB_USERNAME=root
DB_PASSWORD=
```

## 🚀 Cache

### **Configuração Atual (Database)**
```env
CACHE_DRIVER=database
```

### **Para usar Redis (Recomendado para produção)**
```env
CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_CACHE_DB=1
```

### **Para usar File (Desenvolvimento)**
```env
CACHE_DRIVER=file
```

### **Comandos para configurar cache**
```bash
# Limpar cache
php artisan cache:clear

# Ver tabela de cache (se usar database)
php artisan cache:table
php artisan migrate

# Verificar status do cache
php artisan cache:table
```

## 🔄 Filas

### **Configuração Atual (Database)**
```env
QUEUE_CONNECTION=database
```

### **Para usar Redis (Recomendado para produção)**
```env
QUEUE_CONNECTION=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_QUEUE_CONNECTION=default
```

### **Comandos para configurar filas**
```bash
# Criar tabela de jobs (se usar database)
php artisan queue:table
php artisan migrate

# Executar worker
php artisan queue:work

# Ver jobs na fila
php artisan queue:monitor

# Limpar fila
php artisan queue:clear
```

## 🔴 Redis

### **Instalação do Redis**

#### **Ubuntu/Debian:**
```bash
sudo apt update
sudo apt install redis-server
sudo systemctl start redis-server
sudo systemctl enable redis-server
```

#### **macOS:**
```bash
brew install redis
brew services start redis
```

#### **Windows:**
- Baixar Redis para Windows
- Ou usar WSL com Ubuntu

### **Verificar se Redis está funcionando**
```bash
redis-cli ping
# Deve retornar: PONG
```

### **Configuração completa com Redis**
```env
# Cache com Redis
CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
REDIS_CACHE_DB=1

# Filas com Redis
QUEUE_CONNECTION=redis
REDIS_QUEUE_CONNECTION=default
REDIS_QUEUE=default
```

## 🎯 Configurações por Ambiente

### **Desenvolvimento (.env)**
```env
APP_ENV=local
APP_DEBUG=true

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

CACHE_DRIVER=file
QUEUE_CONNECTION=database
```

### **Produção (.env)**
```env
APP_ENV=production
APP_DEBUG=false

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=alloy_tasks
DB_USERNAME=user
DB_PASSWORD=password

CACHE_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

QUEUE_CONNECTION=redis
REDIS_QUEUE_CONNECTION=default
```

## 🔧 Configurações Avançadas

### **Cache com Tags (Redis)**
```php
// No controller
Cache::tags(['tasks'])->remember('tasks.all', 300, function () {
    return Task::orderBy('created_at', 'desc')->get();
});

// Limpar cache por tag
Cache::tags(['tasks'])->flush();
```

### **Filas com Prioridades (Redis)**
```php
// Job com prioridade alta
DeleteCompletedTask::dispatch($task->id)
    ->onQueue('high')
    ->delay(now()->addMinutes(10));

// Executar worker específico
php artisan queue:work --queue=high,default
```

### **Monitoramento Redis**
```bash
# Ver informações do Redis
redis-cli info

# Ver chaves de cache
redis-cli keys "*cache*"

# Ver filas
redis-cli llen queues:default

# Monitorar comandos em tempo real
redis-cli monitor
```

## 🚀 Performance

### **Otimizações com Redis**
- ✅ **Cache mais rápido** que database/file
- ✅ **Filas mais eficientes** para jobs
- ✅ **Persistência** entre reinicializações
- ✅ **Suporte a clusters** para escalabilidade

### **Benchmarks (aproximados)**
| Driver | Cache Speed | Queue Speed | Setup Complexity |
|--------|-------------|-------------|------------------|
| File   | ⭐⭐        | ❌          | ⭐⭐⭐⭐⭐        |
| Database| ⭐⭐⭐       | ⭐⭐⭐       | ⭐⭐⭐           |
| Redis  | ⭐⭐⭐⭐⭐    | ⭐⭐⭐⭐⭐    | ⭐⭐             |

## 🔒 Segurança

### **Redis Security**
```env
# Configurar senha
REDIS_PASSWORD=your_strong_password

# Bind apenas localhost
# No redis.conf: bind 127.0.0.1

# Desabilitar comandos perigosos
# No redis.conf: rename-command FLUSHDB ""
```

## 📊 Monitoramento

### **Comandos úteis**
```bash
# Status do Laravel
php artisan about

# Status das rotas
php artisan route:list

# Status do cache
php artisan cache:table

# Status das filas
php artisan queue:monitor

# Logs em tempo real
tail -f storage/logs/laravel.log
```

---

**💡 Dica: Para produção, use Redis para cache e filas para melhor performance!** 