/**
 * Load footer component into its placeholder
 */
(function loadFooter() {
  const footerContainer = document.getElementById("footer-placeholder");

  if (!footerContainer) {
    console.error('Footer placeholder not found');
    return;
  }

  fetch("../components/footer.html")
    .then(response => {
      if (!response.ok) {
        throw new Error("Footer not found");
      }
      return response.text();
    })
    .then(html => {
      document.getElementById("footer-placeholder").innerHTML = html;
    })
    .catch(error => {
      console.error("Footer load error:", error);
    });
})();
