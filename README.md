# Appointment Finder

## Overview

The "Appointment Finder" is a web project developed for the Web Scripting course. It is designed to allow users to find and vote for appointment dates, similar to services like doodle.com. This project encompasses both frontend and backend development, focusing on user interactions such as viewing appointments, voting for dates, and adding comments.

## Project Requirements

- **General Requirements:**
  - The project must be completed as part of the Web Scripting course.
  - Parts of previously submitted exercises should be reused for the implementation.
  - The project is intended for team work but can be done individually under exceptional circumstances.

- **Core Features:**
  - Display all appointments in a list on the homepage.
  - Provide a detailed view of an appointment, including all date options and existing votes (with comments).
  - Allow users to vote for one or more dates in the detail view.
  - Enable users to create a new appointment with title, location, information, duration, and a list of date suggestions.

- **Technologies:**
  - Frontend: HTML5, CSS3, Bootstrap, JavaScript, jQuery, AJAX, TypeScript
  - Backend: PHP for REST backend and database connection, MySQLi + Prepared Statements for database interactions

- **User Experience:**
  - Ensure a good user experience with no whitepages, error states, and a positive overall impression.

## Project Structure and Layout

- Develop a single-page application without refreshing the entire webpage for dynamic content loading.
- Organize the project into clear components including frontend (`index.html`), CSS, JS, backend (`serviceHandler.php`), business logic, database (`db.php`, `dataHandler.php`), and models.

## Backend Development

- Base the backend development on the code blocks used in Block 4.
- Implement a DB-Service class for centralized database access, ensuring security in data access.

## Database

- Create a new database for the project.
- Design a suitable database model to store appointments, selectable dates, usernames, chosen dates, and comments.

## Frameworks and Libraries

- The use of frameworks or libraries like Bootstrap is at your discretion.
- The use of ready-made solutions (like CMS) is not allowed.

## Submission

- Submit the project as a zip/rar file in Moodle, including a copy of the MySQL database (SQL statements).
- Comment on complex processes/functions in the code.
- If further configuration steps are required for the application's operation, include a readme.txt file.

## Functionality

- **List of Appointments:** Show all appointments on the homepage, marking expired ones as such.
- **Appointment Detail View:** Allow users to click on appointments to see details, vote for dates, and leave comments, subject to the voting expiration date.
- **Creating and Deleting Appointments:** Enable functionality for adding new appointments and deleting existing ones, accessible through the frontend.

## Development Suggestions

- Start with backend development, adapting the code templates from Block 4.
- Proceed with frontend development, ensuring responsive design for smartphones, tablets, and desktops.
- Focus on functionality over styling.

