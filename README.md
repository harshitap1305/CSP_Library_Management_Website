# CSP_Library_Management_Website
# Git repository link
 https://github.com/harshitap1305/CSP_Library_Management_Website
 
# Central Library, IIT Bhilai Webpage

Under this project , we developed a dynamic website for Library Management containing various features. It includes various sections to provide users with relevant information and access to library services.This project includes a database schema with tables to store information about books, users, admins, book requests, book issues, and penalties.

## Usage

1. Clone or download this repository.
2. Ensure the `styles.css` and `home_images` folder are in the correct directory as specified in the HTML files.
3. Open `home.html` in a browser to view the homepage and navigate through the other sections.
4. Set up the Database:
   - Import  MySQL database named library.sql and run the SQL script to create the tables.
    - Insert sample data present in library.sql into the booklist, user_info, and admin_info tables for testing.


## Library System Login Credentials

For testing the login functionality, use the following credentials:

#User Login:
Email: amit.kumar@iitbhilai.ac.in
Password: pass1234

Email: sneha.sharma@iitbhilai.ac.in
Password: mypwd123

#Admin Login:
Email: john.doe@iitbhilai.ac.in
Password: password123

Email: alice.brown@iitbhilai.ac.in
Password: alice@123

## Database Design:
The system uses the following tables:

booklist: Stores information about books, including their name, author, genre, and availability.
user_info: Stores user details, including their email, password, department, and mobile number.
admin_info: Stores admin details, including their email and password.
requests: Stores the status of book requests by users.
issues: Tracks the books issued to users, including issue and return dates.
penalties: Stores penalties incurred by users for overdue books.

## Project Structure
The project consists of the following components:

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
   - user_login.php - Handles user login functionality in backend.
   -admin_login.php- Handles admin login functionality in backend.

## Features


- **Navigation Bar**: Allows users to easily navigate between different sections of the website.
- **Dynamic Content**: Provides comprehensive information about the library's resources, mission, and services.
- **User Interaction**: Offers pages for user login, admin login, and student registration.


## II. USER DASHBOARD
The User Dashboard is an essential component of the Library Management System, offering students a user-friendly interface to interact with library resources. It allows users to perform actions like searching for books, viewing borrowing history, and managing their library account seamlessly.

Features:
1. user_login.php
This provides a secure login form for users to access their personalized dashboard. It redirects users to their dashboard upon successful authentication.
2. user_login.html
This is the html file of user login.

3. user_dashboard.php
This is the central page for users to access all library-related functionalities. It includes links to features such as book search, borrowing history, and account details.The penality given by the admin is also shown here.

4. user_request_bookissue.php
Allows users to search for books based on various filters such as title, author, category, or book number.
Displays detailed information about available books, including availability status and shelf location.

5. borrow_history.php
Displays a user’s borrowing history, including book titles, issue dates, and return dates.
Helps users keep track of their borrowed books and due dates.

6. student_registration.php
A page where students can register themselves in the library system.
Ensures their information is securely stored for future transactions.

7. books.html
Provides a list of all books available in the library.
Displays key details like book title, author, genre, publication year, and language.

8. user_logout.php
Safely logs users out of the system by destroying their session.
Redirects them to the login page for added security

## III. ADMIN DASHBOARD

ADMIN DASHBOARD
The Admin Dashboard is part of the Library Management System, designed to help the library staff manage and control the books and students in the library. It provides features like adding books, editing book details, viewing issued books, managing student data, and more.
Features:
1. admin_login.php
This file contains the login form for the admin to securely log in to the dashboard. On successful login, the admin is redirected to the main dashboard.

2. admin_dashboard.php
This is the main admin dashboard page. It provides links to:all the following files.


3. admin_add_book.php
This page allows the admin to add new books to the system. It accepts input fields like book title, author, ISBN, and publisher.

4. admin_edit_book.php
This page allows the admin to edit existing book details. The admin can update the title, author, and quantity of a book.

5. admin_delete_book.php
This page allows the admin to delete  particular book and all the available data of the book.

6. admin_currently_issued.php
This page displays the list of all currently issued books, including book ID, title, student ID, and student name.The admin can also add penalty to the students.

7. admin_booklist.php
This page displays the list of all  books availablity and status.

8. admin_view_students.php
This page displays student information associated with borrowed books.

9. admin_logout.php
This file logs out the admin by destroying the session and redirecting them to the login page.


