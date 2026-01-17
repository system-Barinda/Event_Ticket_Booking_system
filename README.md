# Event_Ticket_Booking_system
the vents ticket booking for the client to an event will take place

# the structure of backend

backend/
│── config/
│   └── database.php
│
│── modules/
│   ├── users/
│   │   ├── create.php
│   │   ├── read.php
│   │   ├── update.php
│   │   └── delete.php
│   ├── events/
│   ├── venues/
│   │    ├── create.php
│   │    ├── read.php
│   │    ├── update.php
│   │    └── delete.php
│   └── sessions/
│       ├── create.php
│       ├── read.php
│       ├── update.php
│       └── delete.php
│   └── ticket_types/
│       ├── create.php
│       ├── read.php
│       ├── update.php
│       └── delete.php
│── uploads/
│── tickets/
│── reports/


# in the folder of Refunds
🧠 REFUND RULES (IMPORTANT)

✅ Refund allowed only if:

Order status = paid

Session not started yet

Organizer policy allows it

❌ No refund after check-in
## ########################################### ##

# ⏳ WAITLIST SYSTEM — PROFESSIONAL BACKEND DESIGN

The waitlist handles cases where:

Tickets are sold out

Seats become available after refunds / cancellations

Next users are automatically prioritized