
CREATE USER 'IBKCenter'@'%' IDENTIFIED WITH mysql_native_password BY '0305';
GRANT ALL PRIVILEGES ON * . * TO 'IBKCenter'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;

create database loginIBK;

use loginIBK;

CREATE TABLE personal_tbl (
  `p_name` char(20) NOT NULL,
  `p_num` integer not null auto_increment,
  `p_sex` char(10) NOT NULL,
  `p_id` char(20) NOT NULL,
  `p_pw` char(20) NOT NULL,
  `p_idnumber` char(20) NOT NULL,
  `p_mobile` char(15) NOT NULL,
  `p_height` int(5) NOT NULL,
  `p_weight` int(5) NOT NULL,
  `p_adressnumber` int(10) NULL,
  `p_roadaddress` char(45) NULL,
  `p_jibunaddress` char(45) NULL,
  `p_detailaddress` char(45) NULL,
  `p_disease` char(45) NULL,
  `p_hospitalname` char(45) NULL,
  `p_hospitaladdress` char(45) NULL,
  `p_protectorname` char(20) NOT NULL,
  `p_protectorrelation` char(20) NOT NULL,
  `p_protectoridnumber` char(20) NOT NULL,
  `p_protectormobile` char(20) NOT NULL,
  PRIMARY KEY (`p_num`),
  UNIQUE KEY `unique_person` (`p_name`, `p_idnumber`));

select * from personal_tbl;

CREATE TABLE hospital_tbl (
  `h_distingush` CHAR(10) NOT NULL,
  `h_num` integer not null auto_increment,
  `h_name` CHAR(10) NOT NULL,
  `h_id` CHAR(20) NOT NULL,
  `h_pw` CHAR(20) NOT NULL,
  `h_sex` CHAR(10) NULL,
  `h_idnumber` CHAR(20) NOT NULL,
  `h_mobile` CHAR(15) NULL,
  `h_major` CHAR(15) NULL,
  `h_file` VARCHAR(200) NOT NULL,
  `h_workingname` CHAR(45) NULL,
  `h_workingaddress` VARCHAR(45) NULL,
  PRIMARY KEY (`h_num`),
  UNIQUE KEY `unique_hospital`(`h_name`,`h_idnumber`));
  
  select * from hospital_tbl;
