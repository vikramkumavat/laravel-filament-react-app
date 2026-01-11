# Property Auction Application

This is a Laravel-based application for managing property auctions. It provides features for user authentication, property management, and auction handling. This document will guide you through the initial setup and provide an overview of the application.

---

## Table of Contents

1. [About the Application](#about-the-application)
2. [Requirements](#requirements)
3. [Installation](#installation)
4. [Configuration](#configuration)
5. [Running the Application](#running-the-application)
6. [Testing](#testing)
7. [Contributing](#contributing)
8. [License](#license)

---

## About the Application

The Property Auction Application is built using the Laravel framework. It includes the following features:
- User authentication using JWT for API and session-based for web.
- Property management and auction handling.
- Admin panel powered by Filament.
- Queue management for background tasks.

---

## Requirements

Before starting, ensure you have the following installed:
- PHP 8.2 or higher
- Composer
- Node.js and npm
- A database (e.g., MySQL, SQLite)

---

## Installation

Follow these steps to set up the application:

1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd property-auction
   ```

2. Install PHP dependencies using Composer:
   ```bash
   composer install
   ```

3. Install JavaScript dependencies:
   ```bash
   npm install
   ```

4. Create a `.env` file by copying the example:
   ```bash
   cp .env.example .env
   ```

5. Generate the application key:
   ```bash
   php artisan key:generate
   ```

6. Set up the database:
   - Update the `.env` file with your database credentials.
   - Run the migrations:
     ```bash
     php artisan migrate
     ```

7. Compile the front-end assets:
   ```bash
   npm run dev
   ```

---

## Configuration

### Environment Variables

The application uses environment variables defined in the `.env` file. Key variables include:
- `APP_NAME`: The name of the application.
- `APP_URL`: The base URL of the application.
- `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`: Database configuration.
- `APP_KEY`: Encryption key (generated during setup).

### Authentication

The application uses:
- Session-based authentication for web (`web` guard).
- JWT-based authentication for API (`api` guard).

---

## Running the Application

To start the application, use the following command:
```bash
php artisan serve
```

This will serve the application at `http://localhost:8000`.

For front-end development, you can also run:
```bash
npm run dev
```

---

## Testing

Run the test suite using:
```bash
php artisan test
```

---

## Contributing

Contributions are welcome! Please follow these steps:
1. Fork the repository.
2. Create a new branch for your feature or bugfix.
3. Submit a pull request.

---

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.