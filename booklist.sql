create database booklist;
use booklist;
create table books(
book_id INT primary key,
title varchar(50) not null,
author varchar(50) not null,
genre varchar(50),
availability boolean default true,
description text
);
