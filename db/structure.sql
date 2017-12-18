drop table if exists t_adresse;
drop table if exists t_contact;
drop table if exists t_user;

create table t_user (
  usr_id integer not null primary key auto_increment,
  usr_login varchar(100) not null,
  usr_password varchar(88) not null,
  use_salt varchar(23) not null,
  use_role varchar(50) not null
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_contact (
  con_id integer not null primary key auto_increment,
  usr_id integer not null,
  con_nom varchar(100) not null,
  con_prenom varchar(100) not null,
  con_email varchar(100) not null,
  constraint fk_con_usr foreign key(usr_id) references t_user(usr_id)
) engine=innodb character set utf8 collate utf8_unicode_ci;

create table t_adresse (
  adr_id integer not null primary key auto_increment,
  con_id integer not null,
  adr_rue varchar(200) not null,
  adr_code_postal varchar(100) not null,
  adr_ville varchar(100) not null,
  constraint fk_adr_con foreign key(con_id) references t_contact(con_id)
) engine=innodb character set utf8 collate utf8_unicode_ci;