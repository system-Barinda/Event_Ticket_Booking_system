const eventsContainer = document.getElementById("eventsContainer");
const API_URL = "http://localhost/event_ticket_backend/modules/events/read.php";

fetch(API_URL)
  .then(res => res.json())
  .then(events => {
    events.forEach(event => {
      const card = `
        <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition overflow-hidden">
          <img src="assets/images/default-event.jpg" class="w-full h-48 object-cover">
          <div class="p-5">
            <h4 class="text-xl font-bold mb-2">${event.title}</h4>
            <p class="text-gray-600 text-sm mb-3">${event.description}</p>
            <p class="text-sm text-gray-500 mb-1">📍 ${event.venue}</p>
            <p class="text-sm text-gray-500 mb-4">📅 ${event.date}</p>
            <a href="event.html?id=${event.id}" 
               class="block text-center bg-indigo-600 text-white py-2 rounded-lg font-semibold hover:bg-indigo-700 transition">
               View Details
            </a>
          </div>
        </div>
      `;
      eventsContainer.innerHTML += card;
    });
  })
  .catch(() => {
    eventsContainer.innerHTML = "<p class='text-red-500 text-center'>Unable to load events.</p>";
  });


  