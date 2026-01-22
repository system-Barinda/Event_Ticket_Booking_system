# 🎟️ Event Ticket Booking System

## 1. Project Overview

The **Event Ticket Booking System** is a web-based application designed to manage events, venues, ticket sales, and user participation. The system allows users to browse events, select seats, book tickets, and track their bookings, while administrators manage events, venues, and reports.

The backend is built using **PHP (modular architecture)** and is designed to be easily connected to a modern frontend (React).

---

## 2. Objectives

* Provide a reliable ticket booking platform
* Manage events, venues, sessions, and users
* Ensure secure and structured backend logic
* Support future frontend integration (React)
* Allow scalability and maintainability

---

## 3. Technologies Used

### Backend

* PHP (Modular / Procedural)
* MySQL Database
* Apache Server (XAMPP / LAMP)
* REST-style API endpoints

### Frontend (Planned)

* React.js
* CSS (Responsive design)

---

## 4. System Architecture

The system follows a **Modular Backend Architecture**:

* `config/` → Database configuration
* `modules/` → Feature-based modules (users, events, venues, sessions)
* `uploads/` → Uploaded files (images, documents)
* `tickets/` → Ticket generation & handling
* `reports/` → Sales and booking reports

Each module contains CRUD operations:

* create.php
* read.php
* update.php
* delete.php

---

## 5. Database Design (Overview)

Main entities:

* Users
* Events
* Venues
* Sessions
* Tickets

Relationships:

* One user can book many tickets
* One event can have many sessions
* One venue can host many events

---

## 6. Core Features

### User Features

* View events
* Select sessions and seats
* Book tickets
* View booking history

### Admin Features

* Manage users
* Create & manage events
* Assign venues and sessions
* View booking reports

---

## 7. API Workflow (Backend Logic)

1. Client sends HTTP request
2. PHP module receives request
3. Database interaction occurs
4. JSON response is returned

Example:

* `GET /modules/events/read.php`
* `POST /modules/users/create.php`

---

## 8. Security Considerations (Planned)

* Input validation
* Prepared statements
* Token-based authentication (JWT – future)
* Role-based access control

---

## 9. Future Improvements

* React frontend integration
* Authentication & authorization
* Seat selection UI
* Payment gateway integration
* Deployment to production server

---

## 10. Conclusion

This project demonstrates a structured backend system suitable for real-world event management platforms. Its modular design allows easy expansion, security upgrades, and frontend integration.

---

**Author:** Barinda System Sylvere
