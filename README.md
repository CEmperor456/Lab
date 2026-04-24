# Lab
A web  driven database with CRUD oparations

Club Management System
A web-based Club Management System built with PHP and MySQL.
It manages students, clubs, events, rooms, equipment, and registrations.
Supports full CRUD operations, search functionality, and basic reporting.

Features
-Student Management – Add, edit, delete, and search students.
-Club Management – Create, update, delete clubs.
-Event Management – Schedule events with date, time, room, and associated club.
-Room Management – Manage rooms (capacity, name).
-Equipment Management – Track equipment by room and quantity; low‑stock alerts.
-Registration Management – Register students for events with attendance status.
-Queries Page – Show upcoming events, filter events by room, low‑stock equipment, and total equipment count.
-Responsive UI – Simple HTML tables and forms with basic CSS styling.

Technology Stack
-Backend: PHP
-Frontend: HTML, CSS
-Database: MySQL
-Server: Apache (XAMPP / WAMP / LAMP recommended)

Usage Examples
-Add a student – Fill the form on student.php and click “ADD STUDENT”.
-Search clubs – Use the search box on club.php to filter by name.
-View low‑stock equipment – Go to queries.php; equipment with quantity < 5 is listed.
-Register a student – On registration.php, provide registration ID, student ID, event ID, and status.

Future Improvements
-Add login/authentication for admin and users.
-Implement proper error handling and input sanitization.
-Add pagination for large tables.
-Use Bootstrap for responsive design.
-Generate PDF reports for events and registrations.
