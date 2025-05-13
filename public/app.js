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
    <div id="pagination"></div>
  `,
  404: () => `
    <h1>404 - Page Not Found</h1>
  `,
};

// Render the route's HTML
function render(path) {
  const view = routes[path] || routes["404"];
  document.getElementById("app").innerHTML = view();

  // Load the todos when navigating to /todos and extract the page number from the URL
  if (path === "/todos") {
    const page = new URLSearchParams(window.location.search).get("page") || 1;
    loadTodos(page);
  }
}

// Handle todos route logic with pagination
function loadTodos(page = 1) {
  const loading = document.getElementById("loading");
  const list = document.getElementById("todo-list");

  if (loading) {
    loading.textContent = "Loading todos...";
  }

  fetch(`/api/todos?page=${page}`)
    .then((res) => res.json())
    .then((data) => {
      if (loading) {
        loading.remove();
      }

      // Render todos
      list.innerHTML = data.todos
        .map(
          ({ title, completed }) =>
            `<li><strong>${title}</strong>  ${
              completed ? "Done ✅" : "Not done ❌"
            }</li>`
        )
        .join("");

      page = Number(page);

      // Create pagination buttons dynamically
      const pagination = document.getElementById("pagination");
      pagination.innerHTML = ""; // Clear any previous content

      const previousButton = document.createElement("button");
      previousButton.textContent = "Previous";
      previousButton.disabled = page <= 1;
      previousButton.addEventListener("click", () => navigateToPage(page - 1));

      const nextButton = document.createElement("button");
      nextButton.textContent = "Next";
      nextButton.disabled = page >= data.pagination.totalPages;
      nextButton.addEventListener("click", () => navigateToPage(page + 1));

      const pageInfo = document.createElement("span");
      pageInfo.textContent = `Page ${data.pagination.currentPage} of ${data.pagination.totalPages}`;

      // Append the pagination elements
      pagination.appendChild(previousButton);
      pagination.appendChild(pageInfo);
      pagination.appendChild(nextButton);
    })
    .catch(() => {
      if (loading) {
        loading.textContent = "Failed to load todos.";
      }
    });
}

// Handle navigation to different pages
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

/*
// Initial setup for pagination
// This block causes the todo API call to run twice on page load, once from the render function and once here.
document.addEventListener("DOMContentLoaded", () => {
  const page = new URLSearchParams(window.location.search).get("page") || 1;
  loadTodos(page);
});
*/

// Navigate to a new page
function navigateToPage(page) {
  if (page >= 1) {
    history.pushState(null, "", `/todos?page=${page}`);
    loadTodos(page);
  }
}

// Initialize the router when DOM is ready
document.addEventListener("DOMContentLoaded", initRouter);
