# Simple Login and CRUD User Project

This project is a simple login and CRUD (Create, Read, Update, Delete) user application built with PHP 8.1, HTML, CSS, and MySQL 8.0. It supports running in a local environment or using Docker.

## Requirements

- PHP 8.1
- HTML
- CSS
- MySQL 8.0
- OpenServer 5.4.3 (for local development)
- Docker (optional)

## Running the Project Locally

1. Clone the repository:

   ~~~bash
   git clone <repository-url>
   cd <repository-directory>
   ~~~

2. Edit the `.env` file: Update the `.env` file with your MySQL database credentials.

   ~~~ini
   DB_HOST=localhost
   DB_NAME=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ~~~

3. Run migrations:

   ~~~bash
   php migration.php
   ~~~

4. Start the PHP built-in server:

   ~~~bash
   php -S localhost:8000 -t public
   ~~~

5. Access the application: Open your browser and navigate to [http://localhost:8000](http://localhost:8000).

## Running the Project with Docker

1. Clone the repository:

   ~~~bash
   git clone <repository-url>
   cd <repository-directory>
   ~~~

2. Edit the `.env` file: Update the `.env` file with your MySQL database credentials.

   ~~~ini
   DB_HOST=db
   DB_NAME=assistant-test-task
   DB_USERNAME=root
   DB_PASSWORD=root
   ~~~

3. Build and run the Docker containers:

   ~~~bash
   docker-compose up --build
   ~~~

4. Access the application: Open your browser and navigate to [http://localhost:8080](http://localhost:8080).

## Notes

- Ensure that Docker is installed and running on your machine if you choose to run the project with Docker.
- The `docker-compose.yml` file is configured to use the `wait-for-it` script to ensure that the MySQL service is up and running before running the migrations.

Enjoy using the Simple Login and CRUD User Project!
