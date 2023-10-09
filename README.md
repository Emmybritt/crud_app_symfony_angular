# CRUD API & Angular Frontend Application

This repository contains a Symfony-based CRUD API and an Angular frontend application for managing users data. Follow the instructions below to set up and run the project locally.

## Prerequisites

Before you begin, ensure you have met the following requirements:

- **Symfony Backend**:

     - PHP installed on your local machine.
     - Composer installed. You can download it from [getcomposer.org](https://getcomposer.org/).
     - Symfony CLI installed. You can follow the installation guide at [Symfony Docs](https://symfony.com/download).
     - A web server like Apache.

- **Angular Frontend**:
     - Node.js and npm installed. You can download them from [nodejs.org](https://nodejs.org/).

## Installation

### Symfony Backend

1. Clone this repository:

      ```bash
      git clone https://github.com/Emmybritt/crud_app_symfony_angular.git
      ```

- **How To Run And Setup**:

1. Navigate to the Symfony project directory:

      ```bash
      cd crud_api

      ```

2. Install PHP dependencies using Composer:

      ```bash
          Composer install
          php bin/console doctrine:database:create
          php bin/console doctrine:migrations:migrate
      ```

3. Configure your database connection in the .env file.

4. Create the database schema:

      ```bash
          php bin/console doctrine:database:create
          php bin/console doctrine:migrations:migrate
      ```

5. symfony serve
   Access the API at http://127.0.0.1:8000.

### Angular Frontend

- **How To Run And Setup**:

1. Navigate to the Angular project directory:

      ```bash
          cd app-frontend
      ```

2. Install Angular CLI globally (if not already installed):

      ```bash
        npm install -g @angular/cli
      ```

3. Install Angular project dependencies:

      ```bash
        npm install or yarn install
      ```

4. Start Server

              ```bash
                 ng serve
              ```

      Access the frontend at http://localhost:4200.
