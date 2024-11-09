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
language varchar(50)
);
drop table booklist;
