/**
 * Load an HTML component into a placeholder element
 * @param {string} id - The placeholder element ID
 * @param {string} path - Path to the component file
 * @param {Function} callback - Optional callback after load
 */
function loadComponent(id, path, callback) {
  fetch(path)
    .then((response) => response.text())
    .then((html) => {
      const container = document.getElementById(id);

      if (!container) {
        console.error(`Element with id "${id}" not found`);
        return;
      }

      container.innerHTML = html;

      if (typeof callback === "function") {
        callback();
      }
    })
    .catch((error) => {
      console.error(`Error loading component: ${path}`, error);
    });
}

/* ================= COMPONENT LOADERS ================= */

// 1️ Header
loadComponent("header-placeholder", "./components/header.html", () => {
  const menuBtn = document.getElementById("menuBtn");
  const mobileMenu = document.getElementById("mobileMenu");

  if (menuBtn && mobileMenu) {
    menuBtn.addEventListener("click", () => {
      mobileMenu.classList.toggle("hidden");
    });
  }
});

// 2️ Upcoming Events
loadComponent(
  "upcoming-events-placeholder",
  "./components/upcoming-events.html"
);

// 3️ Past Events
loadComponent(
  "past-events-placeholder",
  "./components/past-events.html"
);

// 4️ Footer
loadComponent(
  "footer-placeholder",
  "./components/footer.html"
);
