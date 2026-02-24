const grid = document.getElementById("venuesGrid");
const loading = document.getElementById("loading");
const emptyState = document.getElementById("emptyState");

async function loadVenues() {
  try {
    const res = await fetch("../backend/venues/list.php");
    const venues = await res.json();

    loading.classList.add("hidden");

    if (!venues.length) {
      emptyState.classList.remove("hidden");
      return;
    }

    grid.classList.remove("hidden");
    grid.innerHTML = "";

    venues.forEach(v => {
      grid.innerHTML += `
        <div class="bg-white rounded-lg shadow hover:shadow-md transition">
          <div class="p-5">
            <h2 class="text-lg font-semibold text-gray-800">
              ${v.name}
            </h2>

            <p class="text-sm text-gray-600 mt-1">
              ${v.address ?? "Address not provided"}
            </p>

            <div class="mt-3 text-sm text-gray-700">
              <p><strong>Capacity:</strong> ${v.capacity}</p>
              <p>
                <strong>Wheelchair Access:</strong>
                ${v.wheelchair_access == 1 ? "Yes" : "No"}
              </p>
            </div>

            ${
              v.seating_map
                ? `<a href="${v.seating_map}" target="_blank"
                     class="inline-block mt-4 text-blue-600 text-sm hover:underline">
                     View Seating Map
                   </a>`
                : ""
            }
          </div>
        </div>
      `;
    });

  } catch (err) {
    loading.textContent = "Failed to load venues.";
  }
}

loadVenues();