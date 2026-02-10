
    function loadComponent(id, path, callback) {
      fetch(path)
        .then(response => response.text())
        .then(data => {
          document.getElementById(id).innerHTML = data;
          if (callback) callback();
        })
        .catch(err => console.error("Error loading " + path, err));
    }

    // 1. Load Header
    loadComponent('header-placeholder', './components/header.html', () => {
      const menuBtn = document.getElementById("menuBtn");
      const mobileMenu = document.getElementById("mobileMenu");
      if(menuBtn) menuBtn.onclick = () => mobileMenu.classList.toggle("hidden");
    });

    // 2. Load Upcoming Events
    loadComponent('upcoming-events-placeholder', './components/upcoming-events.html');

    // 3. Load Past Events
    loadComponent('past-events-placeholder', './components/past-events.html');

    // 4. Load Footer
    loadComponent('footer-placeholder', './components/footer.html');
  