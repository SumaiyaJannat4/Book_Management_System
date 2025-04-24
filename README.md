
### Book Management System (Laravel)

A simple Laravel-based application to manage books and publisher. This project includes CRUD functionality and basic relational data handling.

## 🚀 Setup Instructions
These steps assume:

-You're working on a local machine

-You have PHP, Composer, MySQL installed
=======
## ✅Setup Instructions 

These steps assume:

-You're working on a local machine
-You have PHP, Composer, MySQL (or MariaDB), and Laravel CLI installed
-You have already downloaded/extracted your Laravel project (e.g., from a .zip file)

1. Open Terminal in Project Folder
Navigate to project folder (where artisan file is located):
cd path/to/your/project


-You have already downloaded/extracted Laravel project (e.g., from a .zip file)

➤ 1. Clone the Repository-

git clone https://github.com/SumaiyaJannat4/Book_Management_System.git

cd book-management-system


➤ 2. Install Dependencies-

composer install


➤ 3. Create Environment File-

cp .env.example .env

Edit .env and set your database credentials.


➤ 4. Generate App Key-

php artisan key:generate

➤ 5. Set Up the Database-

Create a new MySQL database (e.g., book_management).

Open .env and configure DB settings like this:

DB_CONNECTION=mysql

DB_HOST=127.0.0.1

DB_PORT=3306

DB_DATABASE=book_management

DB_USERNAME=root

DB_PASSWORD=your_mysql_password

➤ 6. Run Migrations-

php artisan migrate

➤ 7. (Optional) Run Seeders

To pre-fill some sample data in database:

php artisan db:seed

➤ 8. Serve the App-

php artisan serve

Then visit: http://127.0.0.1:8000


### ✅ Features
➤ Book Management: 
Add, edit, delete, and list books in the system.

➤ Publisher Management: 
Manage publisher, link them to books via relationships.

➤ Clean UI: 
Simple, easy-to-navigate interface (likely using Blade templates).

➤Database Relationships: 
Books belong to Publisher (One-to-Many relationship).

➤ Validation: 
Form inputs are validated using Laravel's validation system.

➤ CRUD Operations: 
Full create, read, update, delete for books and publisher.

➤ Search Functionality: 
Quickly search through title ,authors , publisher, year, genre.

➤Sorting Feature: 
Sort listings by different criteria (e.g., title,authors , publisher, year, genre.).

➤Pagination: 
Book listings are paginated using Laravel's built-in pagination.



### 📝 Notes
● Framework: Laravel(12.9.2)

● PHP Version Required: ^8.1 or compatible with Laravel version

● Development Environment: Localhost using XAMPP

● Database: MySQL (configured in .env)

● Dependencies:

   -Basic UI using Blade templates
   
   -Styling with Tailwind 

➤ Make sure:

-Composer is installed and accessible via terminal

-Database is set up and .env is configured correctly

-Migrations are run before using the app :php artisan migrate


