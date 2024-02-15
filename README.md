# StrongMind Pizza

Welcome to StrongMind Pizza! This is a web application for managing pizza orders and toppings.

1. [StrongMind Pizza](#strongmind-pizza)
2. [Features](#features)
3. [Installing Composer](#installing-composer)
4. [Running Pizza App Locally](#running-pizza-app-locally)
5. [Running Tests](#running-tests)
6. [File Structure](#file-structure)
7. [Uninstalling Composer](#uninstalling-composer)
8. [Images](#images)

## Features

- **Pizza Management**: Create, update, and delete pizza recipes.
- **Topping Management**: Create, update, and delete pizza toppings.

## Installing Composer

- For this project, you will need Composer, a dependency manager for php from https://getcomposer.org

1. Download Composer. This will produce 'composer.phar' in the directory where the command was ran
```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'edb40769019ccf227279e3bdd1f5b2e9950eb000c3233ee85148944e555d97be3ea4f40c3c2fe73b22f875385f6a5155') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

2. Make Composer globaly to call it anywhere
```bash
mv composer.phar /usr/local/bin/composer
```

## Running Pizza App Locally

1. Clone the repository to your local machine:
```bash
git clone https://github.com/MrLuna12/pizza-app.git
```

2. Navigate to the project directory
```bash
cd pizza
```
3. Install dependencies using composer
```bash
composer install
```
4. Configure environment variables by copying the .env.example file to .env:
```bash
cp .env.example .env
```
5. Set up your database credentials in the .env file.
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pizza
DB_USERNAME=<username>
DB_PASSWORD=<password>
```
6. Generate the APP_KEY in the .env file
```bash
php artisan key:generate
```  
7. Ensure Database Existence: Log into MySQL & Create a MySQL database named 'pizza'
```bash
mysql -u USERNAME -pPASSWORD
CREATE DATABASE pizza;
```
8. Go to project directory and Migrate the database and seed it with some data
```bash
php artisan migrate --seed
```
9. Serve the application:
```bash
php artisan serve
```
10. Access the application in your web browser:
```bash
http://localhost:8000
```
## Running Tests
1. In the root directory, run:
```bash
php artisan test
```
2. Re-seed the database after the tests to repopulate the DB
```bash
php artisan db:seed
```
## File Structure:
- **app/Models/**: Here you will find the models
- **app/Livewrie/**: Here you will find the Livewire components that act like controllers
- **app/database/**: Here you will find the Factory (used to create fake data), DB Migration, DB Seeder
- **app/public/**: Here you will find the CSS and images that I used for the app
- **app/resources/views**: Here, you will find my views for the app.
- **app/routes/web.php**: Here you will find the routes I created for the app
- **app/test/Feature**: This directory contains all the test implementations

## Uninstalling Composer
1. Remove the composer file
```bash
sudo rm /usr/local/bin/composer
```
2. Remove Composer related files
```bash
rm -rf ~/.composer
```

## Images:
![App Picture 1](images/1-pic.png)
![App Picture 2](images/2-pic.png)
![App Picture 3](images/3-pic.png)

