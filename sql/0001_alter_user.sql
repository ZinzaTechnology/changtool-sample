alter table user u_phone u_phone varchar(255);
alter table user change column u_name u_name varchar(32) not null  unique;
alter table user add column u_fullname varchar(255) not null;
alter table user change column u_mail u_mail varchar(255);