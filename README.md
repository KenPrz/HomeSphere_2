## About HomeSphere 2

HomeSphere 2 is an enhanced version of the HomeSphere project, focusing on Vue.js implementation for the frontend. It's a web-based home automation system built with Vue.js and Laravel. The project continues the legacy of HomeSphere by aiming to provide an even more seamless and intuitive home automation experience. This system utilizes ESP32 microcontrollers to connect and control various devices within a home environment.

HomeSphere 2 offers users the ability to manage and automate their home devices remotely, creating a more convenient and efficient living experience.

## Features

+ Seamlessly control lights, appliances, and other devices remotely.
+ Schedule devices to turn on and off at specific times.
+ Create personalized automation scenarios with Modes.
+ Receive real-time notifications for device status changes.
+ Access live video feeds from integrated security cameras.

## Requirements 📒

Before getting started, make sure you have the following tools installed:

+ [Node.js](https://nodejs.org/en)
+ [Composer](https://getcomposer.org/)
+ [XAMPP](https://www.apachefriends.org/) or [MySQL Workbench](https://www.mysql.com/products/workbench/)
+ [Git](https://git-scm.com/) or [GitHub Desktop](https://desktop.github.com/)

### Installation 🔧

#### Setting Up the Database 

##### XAMPP
+ Launch XAMPP and start the Apache and MySQL modules.
+ Access the XAMPP control panel.
+ Open http://localhost/phpmyadmin in your browser.
+ Create a new database named 'homesphere'.

##### MySQL
+ Open your command prompt.
+ Log in to your MySQL account: `mysql -u [username] -p [password];`
+ Run: `CREATE DATABASE homesphere;`
+ Exit the MySQL command line: `exit;`

#### Clone the Repository

##### Git Bash
+ Open your VS Code and navigate to your desired project directory.
+ Use the terminal in VS Code: `ctrl + ~`
+ Clone the repository: `git clone https://github.com/KenPrz/HomeSphere.git`
+ Change into the project directory: `cd homesphere`

##### GitHub Desktop
+ Open the [HomeSphere repository](https://github.com/KenPrz/HomeSphere).
+ Click the "Code" button on the right and select "Open with GitHub Desktop."
+ Follow the prompts to clone the repository to your local system.
+ Open the repository in Visual Studio Code via GitHub Desktop.

#### Initializing the Project

Make sure you're in the HomeSphere project directory when running the following commands.

Install Composer dependencies:
```
composer install
```
Install Node.js dependencies:
```
npm install
```
Create a `.env` file:
```
cp .env.example .env
```
Generate an app key:
```
php artisan key:generate
```
#### Database Connection
In the `.env` file, provide your database credentials:
```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homesphere
DB_USERNAME=[your_username] # usually root by default
DB_PASSWORD=[your_db_password]
```
Run database migrations:
```
php artisan migrate
```
Create a symbolic link to storage:
```
php artisan storage:link
```
#### Serve the Project

Local machine:
```
php artisan serve
```
npm
```
npm run dev
```
websockets
```
php artisan websockets:serve --debug
```
schedule
```
php artisan schedule:work
```
Local network (replace `[your_IP]` with your actual IP):
```
php artisan serve --host [your_IP] --port 80
```

## License

HomeSphere 2 is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
