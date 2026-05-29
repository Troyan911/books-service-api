# 📚 Books API

A simple RESTful API for managing books with import functionality.

---

## 🚀 Tech Stack

- PHP (Laravel)
- Docker
- MySQL / PostgreSQL
- REST API

---

## 📦 Project Setup

### Run in console

```bash
make setup
```

## 📚 Books API

| Method       | Endpoint                 | Description                  |
|--------------|--------------------------|------------------------------|
| GET          | /api/books              | Get all books               |
| POST         | /api/books              | Create a new book           |
| GET          | /api/books/{book}       | Get book by ID              |
| PUT / PATCH  | /api/books/{book}       | Update existing book        |
| DELETE       | /api/books/{book}       | Delete book                 |
| POST         | /api/books/import       | Import books from file/API  |
