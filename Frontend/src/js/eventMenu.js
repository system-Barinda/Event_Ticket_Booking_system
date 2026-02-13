fetch("../components/eventMenu.html")
  .then(res => res.text())
  .then(data => {
    document.getElementById("event-menu-placeholder").innerHTML = data;
  })
  .catch(err => console.error("Failed to load event menu:", err));
