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


# References

### 📌 `popstate` – What is it?

`popstate` is a **browser event** that is fired on the `window` whenever the **active history entry changes** — typically triggered when the user clicks the **Back** or **Forward** buttons in the browser.

---

### 🔄 Why is `popstate` used in your SPA router?

In a **Single Page Application (SPA)**, you're managing page changes via JavaScript (without full page reloads). You also want to react when the user uses the browser’s navigation buttons.

Example:

* User visits `/about` → `history.pushState(null, "", "/about")`
* User clicks **Back** → browser changes to previous entry (`/`)
* At this point, your app should re-render the correct view (`/`)
* That’s where `popstate` comes in

### ✅ Usage in your app:

```js
window.addEventListener("popstate", () => render(window.location.pathname));
```

This ensures that when the user clicks back or forward:

* Your router updates the DOM using `render()` to reflect the correct page.
* The app stays consistent with the URL bar.

---

### 🧠 Summary:

| Action                  | Triggered? | What it does                            |
| ----------------------- | ---------- | --------------------------------------- |
| `pushState()` in code   | ❌          | Updates URL, doesn't trigger `popstate` |
| User clicks **Back**    | ✅          | Triggers `popstate` — lets SPA react    |
| User clicks **Forward** | ✅          | Triggers `popstate` — lets SPA react    |

Let me know if you want a full breakdown of `history.pushState`, `replaceState`, or other router features like lazy loading or hash routing.
