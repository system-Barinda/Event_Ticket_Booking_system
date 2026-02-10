/**
 * Load footer component into its placeholder
 */
(function loadFooter() {
  const footerContainer = document.getElementById("footer-placeholder");

  if (!footerContainer) {
    console.error('Footer placeholder not found');
    return;
  }

  fetch("/components/footer.html")
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.text();
    })
    .then((html) => {
      footerContainer.innerHTML = html;
    })
    .catch((error) => {
      console.error("Error loading footer:", error);
    });
})();
