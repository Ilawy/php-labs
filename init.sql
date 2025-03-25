-- create database iti;
-- create user 'mo'@'localhost' IDENTIFIED by 'PASSHERE';
-- grant all privileges on *.* to 'mo'@'localhost';
create table
    users (
        id integer primary key auto_increment,
        name varchar(255),
        email varchar(255) not null unique,
        room varchar(64),
        profilePic varchar(255),
        created_at timestamp default now ()
    );

alter table users
add column password varchar(255) not null;

create table
    rooms (
        id integer primary key auto_increment,
        name varchar(64) not null,
        capacity int not null
    );

alter table users drop column room;

CREATE TABLE reservations (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user INT NOT NULL,
    room INT NOT NULL,
    duration_in_hours DECIMAL(5, 2) NOT NULL,
    start_at datetime NOT NULL,
    constraint uniq_user_room UNIQUE (user, room),
    constraint user_fk FOREIGN KEY (user) REFERENCES users(id),
    constraint room_fk FOREIGN KEY (room) REFERENCES rooms(id)
);

alter table rooms add column occupied int;
alter table rooms alter occupied set default 0;
alter table rooms add check (occupied <= capacity);