# Labzz Chat System

Backend de sistema de chat em tempo real desenvolvido como desafio técnico.

## 🚀 Stack

- PHP 8.2
- Laravel 12
- MySQL
- Redis
- Elasticsearch
- Laravel Reverb (WebSockets)
- Docker

---

# 📦 Arquitetura

O projeto segue uma arquitetura baseada em **API REST** com separação de responsabilidades.

Controllers
↓
Services
↓
Models

Principais módulos:

- Auth
- Users
- Conversations
- Messages

---

# 🔐 Autenticação

O sistema utiliza **OAuth2 com Laravel Passport**.

Fluxo de autenticação:

POST /api/v1/auth/login
↓
retorna login_token
↓
POST /api/v1/auth/2fa/verify
↓
retorna access_token

---

# 🔑 Two Factor Authentication

O sistema utiliza **TOTP (Time-based One-Time Password)**.

Compatível com:

- Google Authenticator
- Microsoft Authenticator
- Authy

Fluxo:

POST /api/v1/auth/2fa/setup
↓
retorna secret
↓
registrar no app autenticador
↓
POST /api/v1/auth/2fa/verify

---

# 📡 API Endpoints

## Auth

### Login

POST /api/v1/auth/login

Body

{
"email": "user@email.com
",
"password": "password"
}

---

### Verify 2FA

POST /api/v1/auth/2fa/verify

Body

{
"login_token": "uuid",
"code": "123456"
}

---

## Users

GET /api/v1/users
POST /api/v1/users

---

## Conversations

GET /api/v1/conversations
POST /api/v1/conversations

---

## Messages

GET /api/v1/conversations/{id}/messages
POST /api/v1/messages

---

# ⚡ Realtime

Mensagens são transmitidas em tempo real usando:

Laravel Reverb
WebSockets

Eventos de chat são broadcastados para os clientes conectados.

---

# 🔍 Busca de mensagens

Busca implementada usando **Elasticsearch**.

Permite:

- busca por conteúdo
- busca por conversa
- indexação de mensagens

---

# 🐳 Ambiente Docker

Subir ambiente:

docker compose up -d

Containers:

- nginx
- php
- mysql
- redis
- elasticsearch

---

# 🧪 Testes

O projeto possui **Feature Tests** para os principais fluxos da API.

Executar testes:

php artisan test

Testes implementados:

- Login
- 2FA
- List conversations
- Send message

---

# 🛠 Setup do Projeto

Clone o repositório

git clone https://github.com/jeffersoncarrenho/labzz_chat

Entrar na pasta

cd labzz_chat/backend

Subir containers

docker compose up -d

Entrar no container

docker exec -it labzz_app bash

Instalar dependências

composer install

Rodar migrations

php artisan migrate

Instalar Passport

php artisan passport:install

---

# 📊 Estrutura do Projeto

app
├── Http
│ ├── Controllers
│ │ ├── Api
│ │ └── Auth
│ ├── Requests
│
├── Models
│
├── Services
│ ├── AuthService
│ ├── ConversationService
│ └── MessageService

---

# 📌 Melhorias futuras

- Rate limiting
- Message reactions
- Read receipts
- Group conversations
- Message attachments
- Pagination de mensagens

---

# 👨‍💻 Autor

Jefferson Luiz Lima
