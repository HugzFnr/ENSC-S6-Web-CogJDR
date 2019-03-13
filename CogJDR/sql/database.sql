create database if not exists cogjdr character set utf8 collate utf8_unicode_ci;
use cogjdr;

grant all privileges on cogjdr.* to 'cogjdr_user'@'localhost' identified by 'admin';
