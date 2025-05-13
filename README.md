# Vanilla JS SPA Router with PHP Backend

This project demonstrates how to build a simple **Single Page Application (SPA)** using **vanilla JavaScript** for routing, paired with a **PHP backend** served via **Apache** or **Nginx with PHP-FPM** using Docker.

It serves all routes through `index.php`, which returns a static `index.html`, enabling client-side routing similar to `react-router-dom`. This approach works without reloading the browser during navigation.

---

## 📦 Docker Build Sizes

| Server Stack     | Size Estimate | Command |
|------------------|---------------|---------|
| Apache + PHP     | ~725 MB       | `docker-compose -f docker-compose-apache.yaml up --build` |
| Nginx + PHP-FPM  | ~204 MB (131 MB + 73 MB) | `docker-compose -f docker-compose-nginx.yaml up --build` |

---

## 🚀 Preview

| Stack        | URL                       |
|--------------|---------------------------|
| Apache + PHP | [http://localhost:5000](http://localhost:5000) |
| Nginx + PHP  | [http://localhost:5001](http://localhost:5001) |

---

## 🧰 Features

- SPA-like routing with Vanilla JavaScript
- PushState & history API-based navigation
- PHP backend routing fallback
- Dockerized setup for Apache or Nginx + PHP-FPM
- Lightweight, no frameworks

---

## 🛠️ Setup Instructions

### Apache + PHP

```bash
docker-compose -f docker-compose-apache.yaml up --build
````

Visit: [http://localhost:5000](http://localhost:5000)

---

### Nginx + PHP-FPM

```bash
docker-compose -f docker-compose-nginx.yaml up --build
```

Visit: [http://localhost:5001](http://localhost:5001)

---

## 🧪 Routing Example

* `/` → Home
* `/about` → About
* `/contact` → Contact
* Unknown routes → 404

Use `<a href="/about" data-link>About</a>` and similar links to navigate without reloading.
