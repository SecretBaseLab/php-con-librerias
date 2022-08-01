use cursophp;

create table users(
	id int unsigned AUTO_INCREMENT primary key,
	email varchar(100),
	password text,
	created_at DATETIME,
	updated_at DATETIME
);

create table projects(
	id int unsigned AUTO_INCREMENT primary key,
	title varchar(100),
	description text,
	created_at DATETIME,
	updated_at DATETIME
);

create table jobs(
	id int unsigned AUTO_INCREMENT primary key,
	title varchar(100),
	description text,
	fileName varchar(100),
	fileName_hash text,
	extension varchar(10),
	created_at DATETIME,
	updated_at DATETIME
