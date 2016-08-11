alter table user change column u_phone u_phone varchar(255);
alter table user change column u_name u_name varchar(32) not null  unique;
alter table user add column u_fullname varchar(255) not null;
alter table user change column u_mail u_mail varchar(255);
alter table user change cloumn u_created_at created_at datetime;
alter table user change cloumn u_updated_at updated_at datetime;
alter table user change column u_is_deleted is_deleted int(4) default 0;