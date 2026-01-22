# 🎟️ Event Ticket Booking System

## 1. Project Overview

The **Event Ticket Booking System** is a full-stack web application designed to digitalize and automate the process of event management and ticket booking. It addresses common challenges such as manual ticket sales, poor record keeping, and lack of real-time booking updates.

The system enables users to browse available events, select sessions, reserve seats, and book tickets online, while administrators manage events, venues, users, and booking reports through a centralized backend system.

This project is developed using a **modular PHP backend architecture**, making it scalable, maintainable, and suitable for integration with modern frontend frameworks such as React.

---

## 2. Objectives

The main objectives of this project are:

* To design and implement a secure and scalable event ticket booking system
* To simplify event and ticket management for administrators
* To provide users with an easy-to-use online ticket booking experience
* To apply software engineering principles such as modularity and separation of concerns
* To prepare the system for future frontend and mobile integration

---

## 3. Technologies Used

### Backend Technologies

* PHP (Modular / Procedural Architecture)
* MySQL Database Management System
* Apache Web Server (XAMPP / LAMP Stack)
* REST-style API endpoints using JSON

### Frontend Technologies (Planned)

* React.js
* HTML5
* CSS3 (Responsive Design)

### Development Tools

* Visual Studio Code
* Git & GitHub for version control

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

The database is designed using a relational model to ensure data consistency and integrity.

### Main Tables

* **users**: stores user and admin information
* **events**: stores event details
* **venues**: stores venue information
* **sessions**: stores event session schedules
* **tickets**: stores booking and ticket data

### Relationships

* One user can book multiple tickets (One-to-Many)
* One event can have multiple sessions (One-to-Many)
* One venue can host multiple events (One-to-Many)

Primary keys and foreign keys are used to maintain relationships between tables.

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

The backend operates as a REST-style API and follows this workflow:

1. The client sends an HTTP request (GET, POST, PUT, DELETE)
2. The request is routed to the appropriate PHP module
3. Input data is validated and sanitized
4. Database operations are executed using prepared statements
5. A structured JSON response is returned to the client

### Example Endpoints

* `GET /modules/events/read.php`
* `POST /modules/users/create.php`
* `PUT /modules/events/update.php`
* `DELETE /modules/events/delete.php`

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

The Event Ticket Booking System successfully demonstrates the application of backend web development concepts, database design, and modular software architecture. The system provides a strong foundation for a complete production-ready application.

By following best practices in software engineering, this project ensures scalability, maintainability, and security. Future enhancements such as frontend integration, authentication, and online payments will further increase the system’s usability and real-world applicability.

---

**Author:** Barinda System Sylvere
**Institution:** (Tumba college)
**Academic Year:** (2025-2026)
