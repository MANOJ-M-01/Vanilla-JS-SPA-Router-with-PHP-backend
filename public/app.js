const routes = {
  "/": () => `
    <h1>Home</h1>
    <p>Welcome home!</p>
  `,
  "/about": () => `
    <h1>About</h1>
    <p>This is the about page.</p>
  `,
  "/contact": () => `
    <h1>Contact</h1>
    <p>Contact us here.</p>
  `,
  "/todos": () => `
    <h1>Todos</h1>
    <p id="loading">Loading todos...</p>
    <ul id="todo-list"></ul>
  `,
  404: () => `
    <h1>404 - Page Not Found</h1>
  `,
};

// Render the route's HTML
function render(path) {
  const view = routes[path] || routes["404"];
  document.getElementById("app").innerHTML = view();

  if (path === "/todos") loadTodos();
}

// Handle todos route logic
function loadTodos() {
  const loading = document.getElementById("loading");
  const list = document.getElementById("todo-list");

  fetch("/api/todos")
    .then((res) => res.json())
    .then((todos) => {
      loading.remove();
      list.innerHTML = todos
        .map(
          ({ title, completed }) =>
            `<li><strong>${title}</strong> - ${
              completed ? "✅ Done" : "❌ Not done"
            }</li>`
        )
        .join("");
    })
    .catch(() => {
      loading.textContent = "Failed to load todos.";
    });
}

// Handle link navigation
function handleNavigation(event) {
  const anchor = event.target.closest("a[data-link]");
  if (!anchor) return;

  event.preventDefault();
  const href = anchor.getAttribute("href");
  history.pushState(null, "", href);
  render(href);
}

// Initial setup
function initRouter() {
  window.addEventListener("popstate", () => render(window.location.pathname));
  document.body.addEventListener("click", handleNavigation);
  render(window.location.pathname);
}

document.addEventListener("DOMContentLoaded", initRouter);
