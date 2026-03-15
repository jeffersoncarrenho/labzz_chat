# Labzz Chat System

Realtime chat system built for the Labzz technical challenge.

The project demonstrates a scalable chat architecture with real-time communication, caching, search and containerized infrastructure.

---

# Stack

## Backend

- PHP 8
- Laravel 12
- MySQL
- Redis
- Elasticsearch
- Laravel Reverb (WebSockets)

## Frontend

- Next.js
- TypeScript
- TailwindCSS

## Infrastructure

- Docker
- Nginx

---

# Architecture

The system follows a service-oriented backend architecture.

User
↓
Nginx
↓
Laravel API
↓
MySQL / Redis / Elasticsearch
↓
WebSocket Server (Reverb)

Features implemented:

- Realtime messaging via WebSockets
- Message history with pagination
- Message search using Elasticsearch
- Redis caching
- Redis queue workers
- Message delivery status (sent, delivered, read)
- Typing indicators
- Dockerized development environment
- Automated feature tests

---

# Running the Project (Docker)

Clone the repository

```
git clone <repo>
cd labzz_chat
```

Start containers

```
docker compose up -d --build
```

Enter the Laravel container

```
docker exec -it labzz_app bash
```

Install dependencies

```
composer install
php artisan key:generate
php artisan migrate
```

Application will be available at

```
http://localhost:8000
```

---

# Running Tests

```
php artisan test
```

Tests use SQLite in-memory database.

---

# API Endpoints

## Messages

```
POST /api/v1/messages
GET  /api/v1/conversations/{id}/messages
```

## Message Status

```
POST /api/v1/messages/{id}/delivered
POST /api/v1/messages/{id}/read
```

## Search

```
GET /api/v1/messages/search?query=...
```

## Typing Indicator

```
POST /api/v1/typing
```

---

# Project Structure

```
backend
 ├ app
 │ ├ Events
 │ ├ Models
 │ ├ Services
 │ └ Http
 │
 ├ database
 ├ routes
 ├ tests
 │ ├ Feature
 │ └ Unit
 │
docker
docker-compose.yml
```

---

# Author

Jefferson Luiz Lima
