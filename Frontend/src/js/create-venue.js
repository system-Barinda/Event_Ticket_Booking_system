const form = document.getElementById("venueForm");
const message = document.getElementById("message");

form.addEventListener("submit", async e => {
  e.preventDefault();

  const fd = new FormData(form);

  // 🔧 FIX checkbox value
  fd.set(
    "wheelchair_access",
    form.wheelchair_access.checked ? 1 : 0
  );

  const res = await fetch("../backend/venues/create.php", {
    method: "POST",
    body: fd
  });

  const data = await res.json();

  message.classList.remove("hidden");

  if (data.success) {
    message.textContent = "Venue registered successfully.";
    message.className = "mt-4 text-sm text-green-600";
    form.reset();
  } else {
    message.textContent =
      data.error || "Failed to register venue.";
    message.className = "mt-4 text-sm text-red-600";
  }
});