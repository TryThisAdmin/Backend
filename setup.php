<?php

/**
 * Setup script to create Database and htaccess
 */
include "config.php";

/**
 * Creates htaccess file with redirect on main.php except for files
 */
function htaccess()
{
	$dir = FILES_DIR;
	$htaccess = "Options -Indexes\n"
		. "<IfModule mod_rewrite.c>\n"
		. "\tRewriteEngine On\n"
		. "\tRewriteRule !^{$dir}/.*\..* main.php [L]\n"
		. "</IfModule>";

	file_put_contents(".htaccess", $htaccess);
}


/**
 * Creates Database with tables
 */
function database()
{
	file_put_contents(DATABASE, "");
	$PDO = new PDO("sqlite:" . DATABASE);
	$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$PDO->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_TO_STRING);

	$default_hash = $PDO->quote(password_hash("12345678", PASSWORD_DEFAULT));

	$stmnt = "
	PRAGMA foreign_keys = ON;
	----------------------------
	--- drop existing tables ---
	----------------------------
	DROP TABLE IF EXISTS COMMENTLIKES;
	DROP TABLE IF EXISTS IDEALIKES;
	DROP TABLE IF EXISTS COMMENTS;
	DROP TABLE IF EXISTS TAGS;
	DROP TABLE IF EXISTS IDEAS;
	DROP TABLE IF EXISTS FOLLOWERS;
	DROP TABLE IF EXISTS USERS;
	
	
	---------------------
	--- create tables ---
	---------------------
	CREATE TABLE USERS(
		id INTEGER PRIMARY KEY,
		name TEXT UNIQUE NOT NULL,
		hash TEXT NOT NULL,
		email TEXT UNIQUE NOT NULL,
		github TEXT NOT NULL DEFAULT '',
		role TEXT NOT NULL DEFAULT 'user'
	);
	
	CREATE TABLE FOLLOWERS(
		user INTEGER NOT NULL,
		follower INTEGER NOT NULL,
		PRIMARY KEY(user, follower),
		FOREIGN KEY(user) REFERENCES USERS(id) ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY(follower) REFERENCES USERS(id) ON DELETE CASCADE ON UPDATE CASCADE
	);
	
	CREATE TABLE IDEAS(
		id INTEGER PRIMARY KEY,
		title TEXT NOT NULL,
		content TEXT NOT NULL,
		author INTEGER NOT NULL,
		created TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
		updated TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
		FOREIGN KEY(author) REFERENCES USERS(id) ON DELETE CASCADE ON UPDATE CASCADE
	);
	
	CREATE TABLE TAGS(
		name TEXT NOT NULL,
		idea INTEGER NOT NULL,
		PRIMARY KEY(name, idea),
		FOREIGN KEY(idea) REFERENCES IDEAS(id) ON DELETE CASCADE ON UPDATE CASCADE
	);
	
	CREATE TABLE COMMENTS(
		id INTEGER PRIMARY KEY,
		author INTEGER NOT NULL,
		idea INTEGER NOT NULL,
		content TEXT NOT NULL,
		created TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
		updated TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
		FOREIGN KEY(idea) REFERENCES IDEAS(id) ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY(author) REFERENCES USERS(id) ON DELETE CASCADE ON UPDATE CASCADE
	);
	
	CREATE TABLE IDEALIKES(
		idea INTEGER NOT NULL,
		user INTEGER NOT NULL,
		PRIMARY KEY(idea, user)
		FOREIGN KEY(idea) REFERENCES IDEAS(id) ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY(user) REFERENCES USERS(id) ON DELETE CASCADE ON UPDATE CASCADE
	);
	
	CREATE TABLE COMMENTLIKES(
		comment INTEGER NOT NULL,
		user INTEGER NOT NULL,
		PRIMARY KEY(comment, user)
		FOREIGN KEY(comment) REFERENCES COMMENTS(id) ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY(user) REFERENCES USERS(id) ON DELETE CASCADE ON UPDATE CASCADE
	);

	CREATE TABLE IDEASAVES(
		idea INTEGER NOT NULL,
		user INTEGER NOT NULL,
		PRIMARY KEY(idea, user),
		FOREIGN KEY(idea) REFERENCES IDEAS(id) ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY(user) REFERENCES USERS(id) ON DELETE CASCADE ON UPDATE CASCADE
	);

	---------------------------
	--- create default admin ---
	---------------------------
	INSERT INTO USERS(name, hash, email, role)
	VALUES('Admin', {$default_hash}, 'admin@mail.com', 'admin');
";

	$PDO->exec($stmnt);
}


htaccess();
database();
