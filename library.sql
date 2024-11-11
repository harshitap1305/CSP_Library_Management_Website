create database library;
use library;
create table booklist (
id int primary key auto_increment,
bookName varchar(255) NOT NULL,
authorName varchar(255) not null,
genre varchar(255) not null,
shelfNo int not null,
status_book boolean default true,
quantity int default 0,
year_published int,
language varchar(50),
remain int not null
);
INSERT INTO booklist (bookName, authorName, genre, shelfNo, status_book, quantity, year_published, language,remain) VALUES
('To Kill a Mockingbird', 'Harper Lee', 'Fiction', 1, TRUE, 5, 1960, 'English',5),
('1984', 'George Orwell', 'Dystopian', 2, TRUE, 3, 1949, 'English',3),
('The Great Gatsby', 'F. Scott Fitzgerald', 'Classic', 3, TRUE, 4, 1925, 'English',3),
('Pride and Prejudice', 'Jane Austen', 'Romance', 1, TRUE, 2, 1813, 'English',1),
('Moby Dick', 'Herman Melville', 'Adventure', 4, TRUE, 1, 1851, 'English',1),
('War and Peace', 'Leo Tolstoy', 'Historical', 5, TRUE, 6, 1869, 'Russian',6),
('The Catcher in the Rye', 'J.D. Salinger', 'Fiction', 2, TRUE, 4, 1951, 'English',4),
('The Hobbit', 'J.R.R. Tolkien', 'Fantasy', 3, TRUE, 8, 1937, 'English',8),
('Ulysses', 'James Joyce', 'Modernist', 6, TRUE, 5, 1922, 'English',5),
('The Odyssey', 'Homer', 'Epic', 7, TRUE, 3, 2000, 'Greek',3),
('Les Misérables', 'Victor Hugo', 'Historical', 8, TRUE, 2, 1862, 'French',2),
('Crime and Punishment', 'Fyodor Dostoevsky', 'Psychological', 9, TRUE, 1, 1866, 'Russian',1),
('Don Quixote', 'Miguel de Cervantes', 'Adventure', 10, TRUE, 5, 1605, 'Spanish',5),
('Brave New World', 'Aldous Huxley', 'Dystopian', 11, TRUE, 5, 1932, 'English',5),
('Harry Potter and the Philosopher\'s Stone', 'J.K. Rowling', 'Fantasy', 12, TRUE, 10, 1997, 'English',10);


create table user_info(
user_id int unique,
user_name varchar(100) not null,
user_email varchar(100) primary key,
userPassword varchar(255) not  null,
user_department varchar(50) not null,
user_degree varchar(50) not null,
user_mobile varchar(10) not null
);

INSERT INTO user_info (user_id, user_name, user_email, userPassword, user_department, user_degree, user_mobile)
VALUES 
    (1, 'Amit Kumar', 'amit.kumar@iitbhilai.ac.in', 'pass1234', 'Computer Science', 'B.Tech', '9876543210'),
    (2, 'Sneha Sharma', 'sneha.sharma@iitbhilai.ac.in', 'mypwd123', 'Electrical Engineering', 'M.Tech', '8765432109'),
    (3, 'Rohit Gupta', 'rohit.gupta@iitbhilai.ac.in', 'rohit123', 'Mechanical Engineering', 'Ph.D.', '7654321098'),
    (4, 'Neha Singh', 'neha.singh@iitbhilai.ac.in', 'neha@123', 'Civil Engineering', 'B.Tech', '6543210987'),
    (5, 'Pooja Patel', 'pooja.patel@iitbhilai.ac.in', 'pooja987', 'Computer Science', 'M.Sc.', '9432109876'),
    (6, 'Vikram Joshi', 'vikram.joshi@iitbhilai.ac.in', 'vikram45', 'Electrical Engineering', 'B.Tech', '8321098765'),
    (7, 'Kiran Mehta', 'kiran.mehta@iitbhilai.ac.in', 'kiran123', 'Mechanical Engineering', 'M.Tech', '7210987654'),
    (8, 'Arjun Desai', 'arjun.desai@iitbhilai.ac.in', 'arjun@89', 'Civil Engineering', 'Ph.D.', '7109876543'),
    (9, 'Anjali Verma', 'anjali.verma@iitbhilai.ac.in', 'anjali55', 'Chemical Engineering', 'B.Tech', '9098765432'),
    (10, 'Suresh Nair', 'suresh.nair@iitbhilai.ac.in', 'suresh98', 'Physics', 'M.Sc.', '9987654321'),
    (11, 'Ravi Kapoor', 'ravi.kapoor@iitbhilai.ac.in', 'ravi4321', 'Chemistry', 'Ph.D.', '9876123450'),
    (12, 'Divya Pandey', 'divya.pandey@iitbhilai.ac.in', 'divya999', 'Computer Science', 'B.Tech', '8765432101'),
    (13, 'Prakash Yadav', 'prakash.yadav@iitbhilai.ac.in', 'prakash1', 'Electrical Engineering', 'M.Tech', '7654321092'),
    (14, 'Priya Kulkarni', 'priya.kulkarni@iitbhilai.ac.in', 'priya123', 'Mechanical Engineering', 'M.Sc.', '6543210983'),
    (15, 'Rajesh Sharma', 'rajesh.sharma@iitbhilai.ac.in', 'rajesh77', 'Civil Engineering', 'B.Tech', '8432109874'),
    (16, 'Sonali Deshmukh', 'sonali.deshmukh@iitbhilai.ac.in', 'sonali88', 'Mathematics', 'M.Sc.', '8321098765'),
    (17, 'Ankit Chauhan', 'ankit.chauhan@iitbhilai.ac.in', 'ankit123', 'Chemical Engineering', 'Ph.D.', '8210987656'),
    (18, 'Pankaj Bhatia', 'pankaj.bhatia@iitbhilai.ac.in', 'pankaj12', 'Computer Science', 'M.Tech', '9109876547'),
    (19, 'Meena Iyer', 'meena.iyer@iitbhilai.ac.in', 'meena456', 'Physics', 'B.Tech', '7098765438'),
    (20, 'Gaurav Saxena', 'gaurav.saxena@iitbhilai.ac.in', 'gaurav91', 'Mathematics', 'Ph.D.', '7987654329');
    
    
    create table admin_info(
    admin_id int unique,
    admin_name varchar(100) not null,
    admin_email varchar(100) primary key,
	adminPassword varchar(255) not  null,
    
    );

