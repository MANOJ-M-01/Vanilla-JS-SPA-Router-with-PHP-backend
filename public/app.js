const routes = {
  "/": () => `<h1>Home</h1><p>Welcome home!</p>`,
  "/about": () => `<h1>About</h1><p>This is the about page.</p>`,
  "/contact": () => `<h1>Contact</h1><p>Contact us here.</p>`,
};

function router() {
  const path = window.location.pathname;
  const view = routes[path] || (() => `<h1>404 Not Found</h1>`);
  document.getElementById("app").innerHTML = view();
}

function navigate(event) {
  const anchor = event.target.closest("a[data-link]");
  if (anchor) {
    event.preventDefault();
    const url = anchor.getAttribute("href");
    history.pushState(null, "", url);
    router();
  }
}

window.addEventListener("popstate", router);

document.addEventListener("DOMContentLoaded", () => {
  document.body.addEventListener("click", navigate);
  router();
});
