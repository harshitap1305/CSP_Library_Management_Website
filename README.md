# CSP_Library_Management_Website
# Central Library, IIT Bhilai Webpage

Under this project , we developed a dynamic website for Library Management containing various features. It includes various sections to provide users with relevant information and access to library services.This project includes a database schema with tables to store information about books, users, admins, book requests, book issues, and penalties.

## Usage

1. Clone or download this repository.
2. Ensure the `styles.css` and `home_images` folder are in the correct directory as specified in the HTML files.
3. Open `home.html` in a browser to view the homepage and navigate through the other sections.
4. Set up the Database:
   - Import  MySQL database named library.sql and run the SQL script to create the tables.
    - Insert sample data present in library.sql into the booklist, user_info, and admin_info tables for testing.

## Project Structure
The project consists of the following components:

   ## library.sql
      - import the library.sql file

 ## I. HOME PAGE 

1. **HTML Files**: 
   - `home.html` - Homepage with a welcome message and introduction.
   - `user_login.html` - Page for user login.
   - `admin_login.html` - Page for admin login.
   - `about_us.html` - Page with information about the library.
   - `contact_us.html` - Contact information page.
   - `vision_mission.html` - Page outlining the library's vision, mission and objective.
   - `rules.html` - Page listing the library rules.
   - `student_registration.html` - Registration form for students of IIT BHILAI.
   - `books.html` - A list of available books in the library.

2. **CSS**:
   - `styles.css` - Stylesheet for the webpage's layout and design.

3. **Images**:
   - `home_images/IIT_Bhilai_logo.png` - Logo of IIT Bhilai.
4. **PHP files**
   - 'admin_get_books.php' - when we click on search in books.html page, it handles the book search logic, querying the database based on user input.

## Features

- **Responsive Design**: Ensures compatibility across devices with different screen sizes.
- **Navigation Bar**: Allows users to easily navigate between different sections of the website.
- **Dynamic Content**: Provides comprehensive information about the library's resources, mission, and services.
- **User Interaction**: Offers pages for user login, admin login, and student registration.


## II. USER DASHBOARD

## III. ADMIN DASHBOARD

ADMIN DASHBOARD
The Admin Dashboard is part of the Library Management System, designed to help the library staff manage and control the books and students in the library. It provides features like adding books, editing book details, viewing issued books, managing student data, and more.
Features:
1. admin_login.php
This file contains the login form for the admin to securely log in to the dashboard. On successful login, the admin is redirected to the main dashboard.

2. admin_dashboard.php
This is the main admin dashboard page. It provides links to:all the following files.


3. add_book.php
This page allows the admin to add new books to the system. It accepts input fields like book title, author, ISBN, and publisher.

4. edit_book.php
This page allows the admin to edit existing book details. The admin can update the title, author, and quantity of a book.

5. delete_book.php
This page allows the admin to delete  particular book and all the available data of the book.

6. currently_issued.php
This page displays the list of all currently issued books, including book ID, title, student ID, and student name.

7. booklist.php
This page displays the list of all  books availablity and status.

8. view_students.php
This page displays student information associated with borrowed books.

9. logout.php
This file logs out the admin by destroying the session and redirecting them to the login page.

## Features

- **Responsive Design**: Ensures compatibility across devices with different screen sizes.
- **Navigation Bar**: Allows users to easily navigate between different sections of the website.
- **Dynamic Content**: Provides comprehensive information about the library's resources, mission, and services.
- **User Interaction**: Offers pages for user login, admin login, and student registration.




