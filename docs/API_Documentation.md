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

## 5. Database Design

The system uses a **relational database design** to ensure data integrity, consistency, and efficient querying. The database structure is modeled using an **Entity Relationship (ER) approach**, which clearly defines entities, attributes, and relationships.

### 5.1 Entity Relationship (ER) Diagram (Conceptual)

Below is a conceptual description of the ER diagram:

* **User** (user_id, name, email, password, role)
* **Event** (event_id, title, description, date, venue_id)
* **Venue** (venue_id, name, location, capacity)
* **Session** (session_id, event_id, start_time, end_time)
* **Ticket** (ticket_id, user_id, session_id, seat_number, status)

### 5.2 Relationships

* One **User** can book many **Tickets** (One-to-Many)
* One **Event** can have many **Sessions** (One-to-Many)
* One **Venue** can host many **Events** (One-to-Many)
* One **Session** can generate many **Tickets** (One-to-Many)

Foreign keys are used to enforce these relationships and maintain referential integrity.

---

### 5.3 Table Descriptions

#### users

Stores registered users and administrators.

* `user_id` (PK)
* `name`
* `email`
* `password`
* `role`

#### venues

Stores venue information.

* `venue_id` (PK)
* `name`
* `location`
* `capacity`

#### events

Stores event details.

* `event_id` (PK)
* `title`
* `description`
* `date`
* `venue_id` (FK)

#### sessions

Stores event session schedules.

* `session_id` (PK)
* `event_id` (FK)
* `start_time`
* `end_time`

#### tickets

Stores booking and ticket data.

* `ticket_id` (PK)
* `user_id` (FK)
* `session_id` (FK)
* `seat_number`
* `status`

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

## 7. API Documentation

The backend exposes a set of REST-style API endpoints that allow the frontend or external clients to interact with the system. All responses are returned in **JSON format**.

### 7.1 API Design Principles

* RESTful endpoint structure
* Use of HTTP methods (GET, POST, PUT, DELETE)
* JSON request and response format
* Separation of concerns using modules

---

### 7.2 User Module API

**Base Path:** `/modules/users/`

#### Create User

* **Endpoint:** `POST create.php`
* **Request Body (JSON):**

```json
{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "secret123",
  "role": "user"
}
```

* **Response:**

```json
{
  "status": "success",
  "message": "User created successfully"
}
```

#### Read Users

* **Endpoint:** `GET read.php`
* **Response:**

```json
[
  {
    "user_id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "role": "user"
  }
]
```

---

### 7.3 Event Module API

**Base Path:** `/modules/events/`

#### Create Event

* **Endpoint:** `POST create.php`
* **Request Body (JSON):**

```json
{
  "title": "Music Concert",
  "description": "Live performance",
  "date": "2026-06-10",
  "venue_id": 2
}
```

````
- **Response:**
```json
{
  "status": "success",
  "message": "Event created successfully"
}
````

#### Read Events

* **Endpoint:** `GET read.php`
* **Response:**

```json
[
  {
    "event_id": 1,
    "title": "Music Concert",
    "date": "2026-06-10",
    "venue": "City Hall"
  }
]
```

---

### 7.4 Ticket Module API

**Base Path:** `/modules/tickets/`

#### Book Ticket

* **Endpoint:** `POST create.php`
* **Request Body (JSON):**

```json
{
  "user_id": 1,
  "session_id": 3,
  "seat_number": "A12"
}
```

* **Response:**

```json
{
  "status": "success",
  "ticket_id": 15
}
```

---

### 7.5 Error Handling

All API errors follow a consistent structure:

```json
{
  "status": "error",
  "message": "Invalid request"
}
```

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
