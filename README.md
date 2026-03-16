# Labzz Chat System

Full-stack realtime chat system built as a technical challenge.

---

# Architecture

Frontend (Next.js)
↓
API (Laravel)
↓
MySQL / Redis / Elasticsearch

---

# Backend Stack

- PHP 8.2
- Laravel 12
- MySQL
- Redis
- Elasticsearch
- Laravel Passport (OAuth2)
- WebSockets
- Docker

---

# Frontend Stack

- Next.js
- TypeScript
- TailwindCSS

---

# Features

## Authentication

OAuth2 login

POST /api/v1/auth/login

Two Factor Authentication

POST /api/v1/auth/2fa/verify

---

## Conversations

GET /api/v1/conversations
POST /api/v1/conversations

---

## Messages

POST /api/v1/messages
GET /api/v1/conversations/{id}/messages

---

# Realtime Chat

Messages are broadcast using WebSockets.

Clients subscribe to conversation channels and receive events instantly.

---

# Search

Message search is powered by Elasticsearch.

---

# API Documentation

Swagger UI available at:

http://localhost:8000/api/documentation

---

# Postman Collection

Available in:

/postman/LabzzChat.postman_collection.json

---

# Running the Backend

Start docker containers

docker compose up -d

Enter container

docker exec -it labzz_app bash

Install dependencies

composer install

Run migrations

php artisan migrate

Install passport

php artisan passport:install

Generate swagger

php artisan l5-swagger:generate

---

# Running Tests

php artisan test

---

# Frontend Setup

Create frontend project

npx create-next-app@latest labzz-chat-frontend --typescript

Install dependencies

npm install axios socket.io-client tailwindcss

Run development server

npm run dev

---

# Project Structure

Backend

app
Http
Controllers
Services
Models

Frontend

src
app
components
services
hooks
types

---

# Future Improvements

- Message reactions
- File attachments
- Group conversations
- Read receipts
- Message pagination
- Push notifications

---

# Author

Jefferson Luiz Lima
