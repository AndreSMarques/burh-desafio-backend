# Desafio Backend BURH

## Introdução
Este projeto é uma API Restful desenvolvida em PHP com Laravel, para cadastro de vagas de emprego e candidatura de usuários. O objetivo é atender ao desafio da vaga de **Desenvolvedor(a) Backend PHP** publicada no BURH.

A API permite:
- Empresas criarem vagas;
- Usuários se candidatarem às vagas;
- Consultar usuários e suas candidaturas.

---

## Tecnologias Utilizadas
- PHP 8.2
- Laravel 12
- MySQL
- Docker & Docker Compose (para facilitar o ambiente de desenvolvimento)
- Eloquent ORM

---

## Estrutura do Projeto
O projeto contém as seguintes entidades:

### Empresa
Campos:  
- `name` (string)  
- `description` (text)  
- `cnpj` (string, único)  
- `plan` (enum: Free ou Premium)  

Regras:
- Empresas com plano Free podem criar até 5 vagas.
- Empresas com plano Premium podem criar até 10 vagas.

### Vaga
Campos:  
- `title` (string)  
- `description` (text)  
- `type` (enum: pj, clt, internship)  
- `salary` (decimal)  
- `workload` (integer)  

Regras:
- CLT: salário mínimo R$1212 e workload obrigatório.
- Estágio: workload máximo 6 horas.
- PJ: não há salário mínimo ou limite de workload.

### Usuário
Campos:  
- `name` (string)  
- `email` (string, único)  
- `cpf` (string, único)  
- `age` (integer)  

---

## Funcionalidades
- Empresas podem criar vagas.
- Usuários podem se candidatar a vagas.
- Busca de usuários por `name`, `email` ou `cpf`, incluindo todas as vagas em que estão inscritos.
- Tratamento de limites de vagas por plano e validações por tipo de vaga.
- Nenhuma autenticação é necessária.

---

## Rotas da API

### Empresas
| Método | Rota                 | Descrição           |
|--------|--------------------|-------------------|
| GET    | /api/companies      | Lista empresas     |
| POST   | /api/companies      | Cria empresa       |
| GET    | /api/companies/{id} | Detalha empresa    |
| PUT    | /api/companies/{id} | Atualiza empresa   |
| DELETE | /api/companies/{id} | Remove empresa     |

### Vagas
| Método | Rota           | Descrição            |
|--------|----------------|--------------------|
| GET    | /api/jobs      | Lista vagas         |
| POST   | /api/jobs      | Cria vaga           |
| GET    | /api/jobs/{id} | Detalha vaga        |
| PUT    | /api/jobs/{id} | Atualiza vaga       |
| DELETE | /api/jobs/{id} | Remove vaga         |

### Usuários
| Método | Rota               | Descrição                 |
|--------|------------------|--------------------------|
| GET    | /api/users        | Lista usuários           |
| POST   | /api/users        | Cria usuário             |
| GET    | /api/users/{id}   | Detalha usuário          |
| PUT    | /api/users/{id}   | Atualiza usuário         |
| DELETE | /api/users/{id}   | Remove usuário           |
| GET    | /api/users/search | Busca usuários (filtro por name, email ou cpf) |

### Candidaturas
| Método | Rota                    | Descrição                     |
|--------|------------------------|-------------------------------|
| GET    | /api/applications       | Lista candidaturas            |
| POST   | /api/applications       | Cria candidatura (user → vaga) |
| GET    | /api/applications/{id}  | Detalha candidatura           |
| PUT    | /api/applications/{id}  | Atualiza candidatura          |
| DELETE | /api/applications/{id}  | Remove candidatura            |

---

## Exemplos de Uso (Postman)
### Criar Usuário
```json
POST /api/users
{
    "name": "João Silva",
    "email": "joao@email.com",
    "cpf": "12345678901",
    "age": 25
}
```

### Criar Empresa
```json
POST /api/companies
{
    "name": "Tech Company",
    "description": "Empresa de tecnologia",
    "cnpj": "12345678000199",
    "plan": "Free"
}
```

### Criar Vaga
```json
POST /api/jobs
{
    "company_id": 1,
    "title": "Desenvolvedor Backend",
    "description": "Vaga para Laravel",
    "type": "clt",
    "salary": 2500,
    "workload": 8
}
```

### Candidatar-se a Vaga
```json
POST /api/applications
{
    "user_id": 1,
    "job_id": 1,
    "resume": "https://meucv.com/cv.pdf"
}
```

### Buscar Usuário e suas Vagas
```
GET /api/users/search?name=João
```

---

## Setup do Projeto

### Com Docker
```bash
docker compose build
docker compose up -d
docker compose exec app php artisan migrate:fresh
```

### Sem Docker
1. Instale PHP, Composer e MySQL
2. Configure o `.env` com seu banco
3. Execute:
```bash
composer install
php artisan migrate:fresh
php artisan serve
```

---

