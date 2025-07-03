# Teste Técnico Alloy - To-Do List

## 📋 Descrição do Projeto

Este é um teste técnico para desenvolvedores da Alloy, consistindo na implementação de uma aplicação de lista de tarefas (To-Do List) utilizando **Laravel 12** como backend e **Vue.js 3** como frontend.

## 🚀 Status do Projeto

✅ **PROJETO CONCLUÍDO** - Todas as funcionalidades principais implementadas e funcionando.

## 📚 Documentação

### [✅ O que foi implementado](./docs/IMPLEMENTADO.md)
- CRUD completo de tarefas
- Sistema de filas e jobs
- Cache com invalidação automática
- Interface responsiva
- API RESTful completa

### [❌ O que não foi implementado](./docs/NAO_IMPLEMENTADO.md)
- TailwindCSS (substituído por CSS puro)
- Alguns diferenciais opcionais
- Testes automatizados

### [🛠️ Como executar](./docs/COMO_EXECUTAR.md)
- Configuração do ambiente
- Instalação de dependências
- Execução do projeto
- Testes das funcionalidades

### [🏗️ Arquitetura do projeto](./docs/ARQUITETURA.md)
- Estrutura de pastas
- Padrões utilizados
- Decisões técnicas

### [🔧 Configurações](./docs/CONFIGURACOES.md)
- Configuração do banco de dados
- Configuração de cache (File, Database, Redis)
- Configuração de filas (Database, Redis)
- Instalação e configuração do Redis

## 🎯 Funcionalidades Principais

- ✅ **CRUD completo** de tarefas
- ✅ **Interface responsiva** baseada no design fornecido
- ✅ **Sistema de filas** implementado
- ✅ **Cache** com invalidação automática
- ✅ **Soft deletes** funcionando
- ✅ **Job de exclusão automática** (10 min após finalizar)
- ✅ **API RESTful** completa
- ✅ **Validação de dados** no backend

## 🛠️ Stack Tecnológica

### Backend
- **Laravel 12.x** - Framework PHP
- **SQLite** - Banco de dados (configurável para MySQL/PostgreSQL)
- **Redis** - Cache e filas (configurável)
- **PHP 8.2+** - Linguagem de programação

### Frontend
- **Vue.js 3.4** - Framework JavaScript
- **Pinia 2.1** - Gerenciamento de estado
- **Vite 6.3** - Build tool
- **CSS Puro** - Estilização (substituindo TailwindCSS)

## 📁 Estrutura do Projeto

```
├── app/
│   ├── Http/Controllers/     # TaskController
│   ├── Models/              # Task Model
│   ├── Jobs/                # DeleteCompletedTask
│   ├── Observers/           # TaskObserver
│   └── Http/Middleware/     # CacheMiddleware
├── database/
│   └── migrations/          # Tabela tasks
├── resources/
│   ├── js/
│   │   ├── components/      # TaskList, TaskModal, TaskForm
│   │   ├── stores/         # taskStore (Pinia)
│   │   └── services/       # taskService
│   └── css/                # Estilos CSS
├── routes/
│   └── api.php             # Rotas da API
└── docs/                   # Documentação
```

## 🚀 Quick Start

```bash
# Clone e configure
cp .env.example .env
php artisan key:generate

# Configure banco de dados
touch database/database.sqlite
php artisan migrate

# Execute o projeto
composer run dev
```

Acesse: http://localhost:8000

## 📖 Documentação Detalhada

Para informações completas sobre implementação, configuração e uso, consulte os arquivos na pasta `docs/`:

- [📋 O que foi implementado](./docs/IMPLEMENTADO.md)
- [❌ O que não foi implementado](./docs/NAO_IMPLEMENTADO.md)
- [🛠️ Como executar](./docs/COMO_EXECUTAR.md)
- [🏗️ Arquitetura do projeto](./docs/ARQUITETURA.md)
- [🔧 Configurações](./docs/CONFIGURACOES.md)

---

