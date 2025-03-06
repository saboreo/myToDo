# MyToDo App

## Description

MyToDo App is a simple and minimalistic Todo application built to demonstrate basic task management features in a limited time. The app supports the full range of CRUD operations to manage tasks efficiently.

It was built using **Laravel 12** for the backend, **Vue.js** for the frontend, and **MySQL** as the database.

First, you'll need to register a new user. Once the user is registered, a set of sample tasks will be created to provide an instant understanding of the app's capabilities.

---

## Features

- **Create Task:** Users can add new tasks.
- **View Tasks:** Tasks are listed with details.
- **Edit Task:** Users can update each task.
- **Delete Task:** Tasks can be removed from the list.
- **Pagination:** Pagination is implemented to handle long task lists efficiently.

---

## Installation Instructions

To get this application running on your local machine, follow the steps below:

### Prerequisites

- **PHP:** Version 8.4 or higher.
- **Composer:** PHP package manager.
- **Node.js:** JavaScript runtime for managing frontend dependencies.
- **Docker:** To deploy the application in a containerized environment. (Optional)
- **MySQL:** Relational database for storing tasks.

### Setup

1. Clone the Repository.
2. Install PHP Dependencies: `composer install`
3. Configure your database credentials.
4. Run Migrations: `php artisan migrate`
5. Install Node.js Dependencies: `npm install`
6. Compile Frontend Assets: `npm run dev`
7. Run the Application Locally: `php artisan serve`

---

## Design Choices

- **Backend:** The backend is built using **Laravel**, chosen for its scalability, elegant syntax, and ease of development. It also provides robust features for authentication, database handling, and rapid development, making it ideal for this project.
- **Frontend:** **Vue.js** is used for creating a dynamic and interactive task management interface. To integrate the backend with the frontend, Inertia is employed. For UI components, the app partially utilizes the **shadcn-vue** component library and **Heroicons** for the icon library.
- **Database:** **MySQL** is used as the relational database to store task data. This choice aligns with the project requirements and is preferred over SQLite, which would have been the default option for a minimalistic app.
- **User Interface:** The user interface is designed to be minimalistic, clean, and very user-friendly. The frontend is styled using **Tailwind CSS**, providing a responsive layout suitable for both desktop and mobile devices. Additionally, the **shadcn-vue** component library is leveraged to speed up development.
- **Pagination:** To efficiently manage large sets of tasks, pagination is implemented, ensuring the app performs well even when the task list grows significantly.
