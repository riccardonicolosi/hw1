Create DATABASE hw1;
USE hw1;

CREATE TABLE users (
    id integer primary key auto_increment,
    username varchar(16) not null unique,
    email varchar(255) not null unique,
    password varchar(255) not null,
    name varchar(255) not null,
    surname varchar(255) not null,
    profilePic varchar(255)
) Engine = InnoDB;

CREATE TABLE recipes {
    
}