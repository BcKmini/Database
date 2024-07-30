
CREATE USER 'IBKCenter'@'%' IDENTIFIED WITH mysql_native_password BY '0305';
GRANT ALL PRIVILEGES ON * . * TO 'IBKCenter'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;

create database loginIBK;

use loginIBK;

DROP TABLE personal_tbl;
drop table hospital_tbl;
CREATE TABLE personal_tbl (
  `p_name` char(20) NOT NULL,
  `p_prescription` char(45),
  `p_sex` char(10) NULL,
  `p_id` char(20) NOT NULL,
  `p_pw` char(20) NULL,
  `p_idnumber` char(20) NOT NULL,
  `p_mobile` char(15) NULL,
  `p_height` int(5) NULL,
  `p_weight` int(5) NULL,
  `p_adressnumber` int(10) NULL,
  `p_roadaddress` char(45) NULL,
  `p_jibunaddress` char(45) NULL,
  `p_detailaddress` char(45) NULL,
  `p_disease` char(45) NULL,
  `p_hospitalname` char(45) NULL,
  `p_hospitaladdress` char(45) NULL,
  `p_protectorname` char(20) NULL,
  `p_protectorrelation` char(20) NULL,
  `p_protectoridnumber` char(20) NULL,
  `p_protectormobile` char(20) NULL,
  PRIMARY KEY (`p_name`, `p_idnumber`),
  UNIQUE KEY `unique_person` (`p_id`));

select * from personal_tbl;
select * from hospital.opentime_tbl;

drop table hospital_tbl;

select * from hospital_tbl;

CREATE TABLE hospital_tbl (
  `h_distingush` CHAR(10)NULL,
  `h_name` CHAR(10) NOT NULL,
  `h_id` CHAR(20) NOT NULL,
  `h_pw` CHAR(20) NULL,
  `h_sex` CHAR(10) NULL,
  `h_idnumber` CHAR(20) NOT NULL,
  `h_mobile` CHAR(15) NULL,
  `h_major` CHAR(15) NULL,
  `h_file` VARCHAR(200) NOT NULL,
  `h_workingname` CHAR(45) NULL,
  `h_workingaddress` VARCHAR(45) NULL,
  PRIMARY KEY (`h_name`,`h_idnumber`),
  UNIQUE KEY `unique_hospital`(`h_id`));
  
  select * from hospital_data;
  
  CREATE TABLE `loginibk`.`hospital_datatbl` (
  `name` CHAR(255) NOT NULL,
  `city` TEXT NULL,
  `gu_address` TEXT NULL,
  `dong_address` TEXT NULL,
  `post_code` INT NULL,
  `address` TEXT NULL,
  `tel` TEXT NULL,
  `homepages` TEXT NULL,
  `subject` TEXT NULL,
  PRIMARY KEY (`name`));

select * from pharmacy_tbl;
		

select * from pharmacy_data;

select name,address from hospital_data where name = "강북삼성병원";

select * from test_file_tbl;


select * from personal_tbl;
select * from hospital_tbl;
select * from pharmacy_tbl;


delete from pharmacy_tbl where ph_id = 'dlaghldus3';
select * from hospital_data;
select * from pharmacy_data;


CREATE TABLE reviews (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `order` INT NOT NULL,
    place_name VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    date DATE NOT NULL,
    content TEXT NOT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5)
);


ALTER TABLE hospital_tbl ADD COLUMN h_approved BOOLEAN DEFAULT FALSE;
ALTER TABLE pharmacy_tbl ADD COLUMN ph_approved BOOLEAN DEFAULT FALSE;

CREATE TABLE admin_tbl (
    admin_id VARCHAR(50) PRIMARY KEY,
    admin_pw VARCHAR(50) NOT NULL
);

DELETE FROM personal_tbl WHERE p_id = 'maxtell0202';
DELETE FROM hospital_tbl WHERE h_id = 'maxtell0302';
DELETE FROM pharmacy_tbl WHERE ph_id = 'maxtell0402';