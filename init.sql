create database iti;
create user 'mo'@'localhost' IDENTIFIED by 'PASSHERE';
grant all privileges on *.* to 'mo'@'localhost';

create table users (
    id integer primary key auto_increment,
    name varchar(255),
    email varchar(255) not null unique,
    room varchar(64),
    profilePic varchar(255),
    created_at timestamp default now()
);

alter table users add column password varchar(255) not null;
