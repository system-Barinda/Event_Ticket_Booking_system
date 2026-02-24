const table = document.getElementById("ordersTable");

async function loadOrders() {
  const res = await fetch("../backend/orders/list.php");
  const orders = await res.json();

  table.innerHTML = "";

  orders.forEach(o => {
    table.innerHTML += `
      <tr class="border-b hover:bg-gray-50">
        <td class="p-2">${o.order_id}</td>
        <td>${o.user_id}</td>
        <td>${o.session_id}</td>
        <td>${o.total_amount}</td>
        <td>
          <select
            class="border rounded p-1"
            onchange="updateStatus(${o.order_id}, this.value)">
            <option value="pending" ${o.status==='pending'?'selected':''}>Pending</option>
            <option value="paid" ${o.status==='paid'?'selected':''}>Paid</option>
            <option value="cancelled" ${o.status==='cancelled'?'selected':''}>Cancelled</option>
          </select>
        </td>
        <td>${o.created_at}</td>
        <td>
          <button
            onclick="updateStatus(${o.order_id}, 'paid')"
            class="bg-green-600 text-white px-2 py-1 rounded text-xs">
            Mark Paid
          </button>
        </td>
      </tr>
    `;
  });
}

async function updateStatus(id, status) {
  const fd = new FormData();
  fd.append("order_id", id);
  fd.append("status", status);

  await fetch("../backend/orders/update-status.php", {
    method: "POST",
    body: fd
  });

  loadOrders();
}

loadOrders();