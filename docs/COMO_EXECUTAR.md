# 🛠️ Como executar o projeto

## 📋 Pré-requisitos

### **Software necessário:**
- ✅ **PHP 8.2+**
- ✅ **Composer**
- ✅ **Node.js 18+**
- ✅ **SQLite** (já incluído no PHP)
- ✅ **Redis** (opcional, para melhor performance)

### **Verificar instalação:**
```bash
# Verificar PHP
php --version

# Verificar Composer
composer --version

# Verificar Node.js
node --version

# Verificar npm
npm --version

# Verificar Redis (se instalado)
redis-cli ping
```

## 🚀 Instalação e Configuração

### **1. Clone o projeto**
```bash
git clone <url-do-repositorio>
cd testealloylaravel
```

### **2. Instalar dependências**
```bash
# Dependências PHP
composer install

# Dependências Node.js
npm install
```

### **3. Configurar ambiente**
```bash
# Copiar arquivo de ambiente
cp .env.example .env

# Gerar chave da aplicação
php artisan key:generate
```

### **4. Configurar banco de dados**
```bash
# Criar arquivo do banco SQLite
touch database/database.sqlite

# Executar migrações
php artisan migrate

# Executar seeders (dados de teste)
php artisan db:seed
```

### **5. Configurar cache e filas**
```bash
# Limpar cache existente
php artisan cache:clear

# Criar tabela de jobs (se não existir)
php artisan queue:table
php artisan migrate
```

### **6. Configurar Redis (opcional - para melhor performance)**
```bash
# Instalar Redis (Ubuntu/Debian)
sudo apt update
sudo apt install redis-server
sudo systemctl start redis-server

# Instalar Redis (macOS)
brew install redis
brew services start redis

# Verificar se Redis está funcionando
redis-cli ping
# Deve retornar: PONG

# Configurar .env para usar Redis
# CACHE_DRIVER=redis
# QUEUE_CONNECTION=redis
# REDIS_HOST=127.0.0.1
# REDIS_PORT=6379
```

## 🎯 Executar o projeto

### **Terminais separados**
```bash
# Terminal 1 - Laravel
php artisan serve

# Terminal 2 - Queue Worker
php artisan queue:work

# Terminal 3 - Vite (desenvolvimento frontend)
npm run dev
```

## 🌐 Acessar a aplicação

### **Frontend:**
- **URL:** http://localhost:8000
- **Descrição:** Interface principal da aplicação

### **API:**
- **Base URL:** http://localhost:8000/api
- **Descrição:** Endpoints da API RESTful

## 🧪 Testar funcionalidades

### **1. Testar Frontend**
1. Acesse http://localhost:8000
2. **Criar tarefa:**
   - Clique em "+ Adicionar Tarefa"
   - Preencha o formulário
   - Clique em "Adicionar"

3. **Editar tarefa:**
   - Clique no ícone ✏️
   - Modifique os dados
   - Clique em "Atualizar"

4. **Marcar como finalizada:**
   - Clique no ícone ✅
   - Tarefa será marcada como finalizada

5. **Excluir tarefa:**
   - Clique no ícone 🗑️
   - Confirme a exclusão

### **2. Testar API**
```bash
# Listar todas as tarefas
curl http://localhost:8000/api/tasks

# Criar nova tarefa
curl -X POST http://localhost:8000/api/tasks \
  -H "Content-Type: application/json" \
  -d '{"nome":"Nova Tarefa","descricao":"Descrição da tarefa"}'

# Ver tarefa específica
curl http://localhost:8000/api/tasks/1

# Editar tarefa
curl -X PUT http://localhost:8000/api/tasks/1 \
  -H "Content-Type: application/json" \
  -d '{"nome":"Tarefa Editada"}'

# Marcar como finalizada
curl -X PATCH http://localhost:8000/api/tasks/1/toggle

# Excluir tarefa
curl -X DELETE http://localhost:8000/api/tasks/1
```

### **3. Testar Job de Exclusão Automática**
1. Crie uma tarefa
2. Marque como finalizada
3. **Aguarde 10 minutos** (ou modifique o delay)
4. A tarefa será excluída automaticamente

**Para testar mais rapidamente:**
- Edite o arquivo `app/Observers/TaskObserver.php`
- Mude `->delay(now()->addMinutes(10))` para `->delay(now()->addSeconds(30))`

### **4. Testar Cache**
1. Acesse `GET /api/tasks` (primeira requisição)
2. Acesse novamente `GET /api/tasks` (segunda requisição)
3. A segunda deve ser mais rápida (cache)

## 🔧 Comandos úteis

### **Desenvolvimento:**
```bash
# Executar todos os serviços
composer run dev

# Apenas Laravel
php artisan serve

# Apenas Vite
npm run dev

# Build de produção
npm run build
```

### **Banco de dados:**
```bash
# Executar migrações
php artisan migrate

# Reverter migrações
php artisan migrate:rollback

# Executar seeders
php artisan db:seed

# Limpar banco e recriar
php artisan migrate:fresh --seed
```

### **Cache:**
```bash
# Limpar cache
php artisan cache:clear

# Ver cache
php artisan cache:table

# Se usando Redis
redis-cli keys "*cache*"
redis-cli flushall
```

### **Filas:**
```bash
# Executar worker
php artisan queue:work

# Ver jobs na fila
php artisan queue:monitor

# Limpar fila
php artisan queue:clear

# Se usando Redis
redis-cli llen queues:default
redis-cli del queues:default
```

### **Logs:**
```bash
# Ver logs em tempo real
tail -f storage/logs/laravel.log

# Limpar logs
php artisan log:clear
```

## 🐛 Debug e Troubleshooting

### **Problemas comuns:**

#### **1. Erro 500 no frontend**
```bash
# Verificar logs
tail -f storage/logs/laravel.log

# Limpar cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

#### **2. Erro de banco de dados**
```bash
# Verificar se o arquivo existe
ls -la database/database.sqlite

# Recriar banco
rm database/database.sqlite
touch database/database.sqlite
php artisan migrate --seed
```

#### **3. Erro de dependências**
```bash
# Reinstalar dependências
rm -rf vendor node_modules
composer install
npm install
```

#### **4. Erro de permissões**
```bash
# Dar permissões necessárias
chmod -R 755 storage bootstrap/cache
```

#### **5. Porta ocupada**
```bash
# Verificar processos na porta 8000
lsof -i :8000

# Matar processo
kill -9 <PID>
```

### **Verificar status:**
```bash
# Status do Laravel
php artisan about

# Status das rotas
php artisan route:list

# Status do cache
php artisan cache:table

# Status das filas
php artisan queue:monitor

# Status do Redis (se instalado)
redis-cli info
redis-cli keys "*"
```

## 📊 Monitoramento

### **Verificar se tudo está funcionando:**
1. ✅ **Frontend:** http://localhost:8000
2. ✅ **API:** http://localhost:8000/api/tasks
3. ✅ **Cache:** Segunda requisição mais rápida
4. ✅ **Filas:** `php artisan queue:work` rodando
5. ✅ **Jobs:** Logs em `storage/logs/laravel.log`
6. ✅ **Redis:** `redis-cli ping` retorna PONG (se instalado)

## 🎯 Próximos passos

Após executar com sucesso:
1. **Teste todas as funcionalidades** listadas acima
2. **Verifique o job** de exclusão automática
3. **Teste o cache** nas requisições GET
4. **Explore a interface** e API

---

**🎉 Se tudo estiver funcionando, o projeto está pronto para uso!** 
