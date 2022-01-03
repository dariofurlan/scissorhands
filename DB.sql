CREATE DATABASE IF NOT EXISTS `scissorhands`;
USE `scissorhands`;

-- DROP TABLES
DROP TABLE IF EXISTS credential CASCADE;
DROP TABLE IF EXISTS reservation CASCADE;
DROP TABLE IF EXISTS service CASCADE;
DROP TABLE IF EXISTS staff CASCADE;
DROP TABLE IF EXISTS company CASCADE;
DROP TABLE IF EXISTS owner CASCADE;
DROP TABLE IF EXISTS customer CASCADE;


-- CREATE TABLES
CREATE TABLE IF NOT EXISTS `owner` (
  `_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `date_of_birth` date,
  PRIMARY KEY (`_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;


CREATE TABLE IF NOT EXISTS `customer` (
  `_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `sex` ENUM('M', 'F') NOT NULL,
  PRIMARY KEY (`_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;


CREATE TABLE IF NOT EXISTS `credential` (
  `_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(100) NOT NULL,
  `type` ENUM('USER', 'OWNER') NOT NULL,
  `customer_ref` INT UNSIGNED DEFAULT NULL,
  `owner_ref` INT UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

ALTER TABLE `credential` ADD CONSTRAINT `FK_credential_customer` FOREIGN KEY (`customer_ref`) REFERENCES `customer` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE `credential` ADD CONSTRAINT `FK_credential_owner` FOREIGN KEY (`owner_ref`) REFERENCES `owner` (`_id`) ON DELETE CASCADE ON UPDATE CASCADE;

CREATE TABLE IF NOT EXISTS `company` (
  `_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `open_at` INT UNSIGNED NOT NULL,
  `close_at` INT UNSIGNED NOT NULL,
  `days`
  set(
      'MON',
      'TUE',
      'WED',
      'THU',
      'FRI',
      'SAT',
      'SUN'
    ) NOT NULL,
    `book_before` INT UNSIGNED NOT NULL,
    `book_after` INT UNSIGNED NOT NULL,
    `owner` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`_id`),
    KEY `FK__owner_azienda` (`owner`) USING BTREE,
    CONSTRAINT `FK__owner_azienda` FOREIGN KEY (`owner`) REFERENCES `owner` (`_id`) ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `service` (
  `_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `duration` INT UNSIGNED NOT NULL,
  `price` DECIMAL(7,2) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` ENUM('capelli','barba'),
  `description` text NOT NULL,
  `company` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`_id`),
  KEY `FK_servizio_azienda` (`company`) USING BTREE,
  CONSTRAINT `FK_service_company` FOREIGN KEY (`company`) REFERENCES `company` (`_id`) ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `staff` (
  `_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `surname` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `sex` enum('M', 'F') NOT NULL,
  `company` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`_id`),
  KEY `FK__azienda` (`company`) USING BTREE,
  CONSTRAINT `FK__company` FOREIGN KEY (`company`) REFERENCES `company` (`_id`) ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS `reservation` (
  `_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `company` INT UNSIGNED NOT NULL,
  `start_at` INT UNSIGNED NOT NULL,
  `end_at` INT UNSIGNED NOT NULL,
  `confirmed` BOOLEAN DEFAULT NULL,
  `price` decimal(7, 2) NOT NULL,
  `notes` text NOT NULL default '',
  `staff` INT UNSIGNED NOT NULL,
  `customer` INT UNSIGNED NOT NULL,
  `service` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`_id`),
  KEY `FK_reservation_service` (`service`) USING BTREE,
  KEY `FK__customer_reservation` (`customer`) USING BTREE,
  KEY `FK__staff_reservation` (`staff`) USING BTREE,
  KEY `FK__azienda_reservation` (`company`) USING BTREE,
  CONSTRAINT `FK__customer_reservation` FOREIGN KEY (`customer`) REFERENCES `customer` (`_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK__staff_reservation` FOREIGN KEY (`staff`) REFERENCES `staff` (`_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_reservation_service` FOREIGN KEY (`service`) REFERENCES `service` (`_id`) ON UPDATE CASCADE,
  CONSTRAINT `FK__azienda_reservation` FOREIGN KEY (`company`) REFERENCES `company` (`_id`) ON UPDATE CASCADE
) ENGINE = InnoDB DEFAULT CHARSET = utf8;



-- Popolazione database

INSERT INTO
  owner(_id, name, surname)
VALUES
  (1, 'Edoardo', 'Coppola');

INSERT INTO
  credential(_id, owner_ref, email, password, type)
VALUES 
  (1, 1, 'edoardocoppola@email.com', 'supersecure123', 'OWNER');

INSERT INTO 
  company(_id,name,open_at,close_at,days,book_before,book_after,owner)
VALUES
  (1, 'Scissorhands', 28800, 75600, "Tue,Wed,Thu,Fri,Sat", 1209600, 3600, 1);

INSERT INTO
  service(_id, duration, price, name, type, description, company)
VALUES 
  (1, 1800, 30.00, "Taglio", "capelli", "Eseguito a macchinetta e forbice, comprende il lavaggio e la piega.", 1),
  (2, 900, 25.00, "Rasatura con lama", "capelli", "Rasatura totale della testa eseguita con rasoio a mano libera.", 1),
  (3, 900, 20.00, "Rasatura con macchinetta", "capelli", "Rasatura della testa eseguita con la macchinetta.", 1),
  (4, 1200, 15.00, "Lavaggio e piega", "capelli", " Lavaggio dei capelli e messa in piega, con applicazione di lozione finale.", 1),
  (5, 2400, 40.00, "Tinta", "capelli", "Utilizziamo solo tinte senza ammoniaca ed ecosostenibili.", 1),
  (6, 600, 10.00, "Trattamento anticaduta", "capelli", "Applicazione di lozione anticaduta.", 1),
  (7, 1800, 25.00, "Rasatura completa", "barba", "Rasatura tradizionale con applicazione di prodotti specifici e massaggio viso finale con balsamo.", 1),
  (8, 1200, 20.00, "Modellatura completa", "barba", "Rimodellatura di barba e baffi con forbice e tosatrice, seguita dall'applicazione di un balsamo.", 1),
  (9, 1200, 15.00, "Modellatura veloce", "barba", "Riassetto di barba e baffi con forbice e tosatrice, seguito dall'applicazione di un balsamo.", 1);
  
INSERT INTO
  customer(_id, surname, name, sex) 
VALUES 
  ('1', 'Fake1', 'Customer1', 'M'),
  ('2', 'Fake2', 'Customer2', 'F'),
  ('3', 'Timmi', 'Burrus', 'F'),
  ('4', 'Giffy', 'Feild', 'M'),
  ('5', 'Oliviero', 'Sarre', 'M'),
  ('6', 'Cindy', 'Reignould', 'F'),
  ('7', 'Frederica', 'Fereday', 'F'),
  ('8', 'Barton', 'Blest', 'M'),
  ('9', 'Ripley', 'Krauss', 'M'),
  ('10', 'Valentijn', 'Haldon', 'M'),
  ('11', 'Tammy', 'Gooders', 'M'),
  ('12', 'Nicola', 'Rosenstein', 'M');
  

INSERT INTO 
  staff(_id, surname, name, sex, company)
VALUES
  (1, 'Rivazzi','Gaetana','F',1),
  (2, 'Ginnati','Roberto','M',1);
