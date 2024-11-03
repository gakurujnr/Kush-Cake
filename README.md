Here's a README file for setting up a Laravel project with Inertia.js:

---

# Laravel Inertia.js Setup Guide

This guide provides step-by-step instructions on setting up a Laravel project with Inertia.js on your machine.

## Requirements

Before you begin, make sure you have the following installed on your machine:

- **PHP (>= 8.0)**: Laravel requires PHP version 8.0 or higher. You can [download it here](https://www.php.net/downloads).
- **Composer**: A dependency manager for PHP, which is required to install Laravel and other packages. Install it from [Composer's official website](https://getcomposer.org/).
- **Node.js & npm**: Required to manage front-end dependencies. Download from [Node.js](https://nodejs.org/).
- **Laravel**: The PHP framework for web artisans. Install it using Composer after setting up the project.

## Installation Steps

### 1. Clone the Project Repository

Clone the Laravel project repository or create a new Laravel project if starting from scratch:

```bash
# Clone an existing project
git clone https://github.com/DavidzMwangi/kushcake.git
cd kushcake
```


### 2. Install PHP Dependencies

Run the following command to install all PHP dependencies defined in `composer.json`:

```bash
composer install
```

### 3. Install Node.js Dependencies

Inertia.js requires some JavaScript libraries, which are managed through npm. Install all JavaScript dependencies defined in `package.json`:

```bash
npm install
```

### 4. Configure the Environment

Copy the `.env.example` file to `.env` and configure your environment settings:

```bash
cp .env.example .env
php artisan key:generate
```

Update the database and other configuration settings in the `.env` file as needed.


## Running the Application in Development Mode

To run the application in development mode, you need to serve the back-end with PHP and compile front-end assets using npm.

1. **Serve the Laravel Application**

   Open a terminal and run:

   ```bash
   php artisan serve
   ```

   This command will start the development server and make your Laravel app available at `http://localhost:8000` (or another specified port).

2. **Run npm for Front-End Development**

   In a separate terminal, run:

   ```bash
   npm run dev
   ```

   This command will compile your front-end assets in development mode and watch for changes. Make sure this is running whenever you work on front-end code.


3. **To pull changes from Github, run this command**

    ```bash
    git pull origin main
    ```
    
    This command will pull changes from the main branch of the repository.


4. **To push changes to Github, run this command**

    ```bash
    git add .
    git commit -m "Your commit message"
    git push origin main
    ```
    
    This command will push changes to the main branch of the repository.
## Additional Notes

- If you encounter issues with cross-origin requests (CORS), consider using Laravel’s CORS configuration or the [Laravel CORS package](https://github.com/fruitcake/laravel-cors).
- When pushing to production, use `php artisan config:cache` and `npm run build` to optimize performance.

## License

This project is open-source and available under the [MIT license](https://opensource.org/licenses/MIT).

---

This should cover the basic steps needed for setting up and running a Laravel project with Inertia.js in development mode.
