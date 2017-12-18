create database if not exists mescontacts character set utf8 collate utf8_unicode_ci;
use mescontacts;

grant all privileges on mescontacts.* to 'mescontacts_user'@'localhost' identified by 'secret';