CREATE DATABASE `chang_dev` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
create user changadm_dev identified by "changdb123";
grant all on chang_dev.* to changadm_dev;
