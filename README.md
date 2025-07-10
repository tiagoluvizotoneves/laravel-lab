# Laravel Lab – Technical Test - Task Management App

Este projeto é a implementação do teste técnico, utilizando:

-   Laravel 12.x (PHP 8.2+)
-   Vue.js 3.4 + Vite 6.3
-   Pinia 2.1
-   TailwindCSS 4
-   Jobs assíncronos, cache e boas práticas

---

## Funcionalidades

-   CRUD completo de tarefas com validação (frontend + backend)
-   Modal para criação e edição (UX fluida)
-   Exclusão lógica e job assíncrono para limpeza automática
-   Cache da listagem com invalidação automática
-   Testes automatizados (Feature + Factory)

---

## Instalação

### Backend (Laravel)

```bash
git clone https://github.com/tiagoluvizotoneves/laravel-lab.git
cd laravel-lab

cp .env.example .env
composer install
php artisan key:generate

php artisan migrate --seed
php artisan serve
```

### Frontend (Vite + Vue 3)

```bash
npm install
npm run dev
```

### Frontend (Vite + Vue 3)

```bash
├── app/
│   └── Http/Controllers/TaskController.php
│   └── Jobs/DeleteCompletedTask.php
│   └── Models/Task.php
│
├── database/
│   └── migrations/2025_06_28_125519_create_tasks_table.php
│
├── resources/
│   └── js/
│       ├── components/
│       │   ├── Appbar.vue
│       │   ├── TaskList.vue
│       │   ├── TaskModal.vue
│       │   ├── TasksContainer.vue
│       ├── stores/
│       │   └── taskStore.js
│       └── services/
│           └── taskService.js
│
├── routes/
│   └── api.php
│
└── README.md
```

### Testes

```bash
php artisan test
```

Cobertura:

-   Criação de tarefas
-   Listagem e edição
-   Marcar como finalizada
-   Soft delete com validação
-   Verificação em banco com assertDatabaseHas e assertSoftDeleted

### Deploy

Pronto para rodar em ambiente local (http://127.0.0.1:8000) com build automatizado via Vite:

```bash
npm run build (terminal 1)
php artisan serve (terminal 2)
```

### Desenvolvimento

Tiago Luvizoto Neves
Desenvolvedor Full Stack | Laravel | Vue.js | WordPress | UX/UI
LinkedIn: https://www.linkedin.com/in/tiagoluvizotoneves/
