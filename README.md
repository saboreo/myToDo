# MyToDo App

<img width="1353" alt="image" src="https://github.com/user-attachments/assets/beca69b6-5898-4d46-a749-63686844aac5" />

_Dashboard view_

## Description

MyToDo App is a simple, minimalist to-do application designed to showcase basic task management features within a limited timeframe. The app supports the full range of CRUD operations for efficient task management.

It was built using **Laravel 12** for the backend, **Vue.js** for the frontend, and **MySQL** as the database.

First, you'll need to register a new user. Once the user is registered, a set of sample tasks will be created to provide an instant understanding of the app's capabilities.

---

## Features

- **Create Task:** Users can add new tasks.
- **View Tasks:** Tasks are listed with details.
- **Edit Task:** Users can update each task.
- **Delete Task:** Tasks can be removed from the list.
- **Pagination:** Pagination is implemented to handle long task lists efficiently.
- **User authentication:** Account registration and authentication.
- **Themes:** Dark & Light Mode support.
- **Flash messages:** Session flash messaging is used for user feedback on actions.
- **Pest:** Feature and unit tests for backend validation.
- **Usage of Laravel Features:**
    - **Controllers:** Manage task CRUD operations and dashboard display.
    - **Models:** Define task and user data structures.
    - **Policies:** Enforce task authorization rules.
    - **Database Factories:** Generate test data for seeding and testing.
    - **Migrations:** Define and manage database schema changes.
    - **Request Rules:** Validate user input before processing actions.

---

## Installation Instructions

To get this application running on your local machine, follow the steps below. You can run this application either locally or using Docker. Choose the method that works best for you.

### Prerequisites

- **PHP:** Version 8.4 or higher.
- **Composer:** PHP package manager.
- **Node.js:** JavaScript runtime for managing frontend dependencies.
- **Docker:** To deploy the application in a containerized environment. (Optional)
- **MySQL:** Relational database for storing tasks.

### Setup

#### Option 1: (Recommended)

1. Clone the Repository.
2. Install PHP Dependencies:

```
composer install
```

3. Configure your database credentials.

```yaml
# Example:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mytodo
DB_USERNAME=root
DB_PASSWORD=
```

4. Run Migrations:

```
php artisan migrate
```

5. Install Node.js Dependencies:

```
npm install
```

6. Compile Frontend Assets:

```
npm run dev
```

7. Run the Application Locally:

```
php artisan serve
```

To run the tests, execute `php artisan test` or `./vendor/bin/pest` in your terminal.

#### Option 2: (Using Docker).

1. Clone the Repository.
2. Copy the environment file.

```
cp .env.example .env
```

3. Start the Docker containers.

```bash
cp .env.example .env
```

4. Access the application at

```
http://localhost:8000
```

That's it! The Docker setup will automatically:

- Build the PHP environment.
- Install all dependencies.
- Run database migrations.
- Build frontend assets.
- Start the web server.

---

## Design Choices

- **Backend:** The backend is built using **Laravel**, chosen for its scalability, elegant syntax, and ease of development. It also provides robust features for authentication, database handling, and rapid development, making it ideal for this project.
- **Frontend:** **Vue.js** is used for creating a dynamic and interactive task management interface. To integrate the backend with the frontend, Inertia is employed. For UI components, the app partially utilizes the **shadcn-vue** component library and **Heroicons** for the icon library.
- **Database:** **MySQL** is used as the relational database to store task data. This choice aligns with the project requirements and is preferred over SQLite, which would have been the default option for a minimalistic app.
- **User Interface:** The user interface is designed to be minimalistic, clean, and very user-friendly. The frontend is styled using **Tailwind CSS**, providing a responsive layout suitable for both desktop and mobile devices. Additionally, the **shadcn-vue** component library is leveraged to speed up development.
- **Pagination:** To efficiently manage large sets of tasks, pagination is implemented, ensuring the app performs well even when the task list grows significantly.
- **Flash Messages:** Reflects on UX standards by providing clear feedback to the user after certain actions.
- **Backend Tests:** Pest was chosen for testing because its expressive syntax and simplicity allow us to write clean, maintainable tests, ensuring that our application functionality is robust and reliable.
