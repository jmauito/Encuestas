create database covidec;
use covidec;

CREATE TABLE `covidec`.`infographic`(  
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `number` INT(10) UNSIGNED NOT NULL,
  `start_date` DATE NOT NULL,
  `cut_date_time` DATETIME NOT NULL,
  `heat_map_id` INT UNSIGNED NOT NULL,
  `deleted` BOOL NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
);
ALTER TABLE `covidec`.`infographic`  
  ENGINE=INNODB;

CREATE TABLE `covidec`.`national_data`(  
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `infographic_id` INT UNSIGNED NOT NULL,
  `recovered_patients` INT UNSIGNED,
  `hospital_discharge` INT UNSIGNED,
  `high_epidemiology` INT UNSIGNED,
  `cases_ruled_out` INT UNSIGNED,
  `confirmed_cases` INT UNSIGNED,
  `dead_people` INT UNSIGNED,
  `probable_deceased` INT UNSIGNED,
  `stable_home_isolation` INT UNSIGNED,
  `stable_hospitalized` INT UNSIGNED,
  `hospitalized_prognosis_reserved` INT UNSIGNED,
  `total_samples_taken` INT UNSIGNED,
  `confirmed_percentage_men` INT UNSIGNED,
  `confirmed_percentage_women` INT UNSIGNED,
  `discarded_pcr` INT UNSIGNED,
  `confirmed_pcr` INT UNSIGNED,
  `confirmed_rapid_test` INT UNSIGNED,	
  `discarded_rapid_test` INT UNSIGNED,
  `deleted` BOOL NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
  
);
ALTER TABLE `covidec`.`national_data`  
  ADD CONSTRAINT `fk_national_data_infographic` FOREIGN KEY (`infographic_id`) REFERENCES `covidec`.`infographic`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
  ENGINE=INNODB;


CREATE TABLE `covidec`.`heat_map`(  
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50),
  `deleted` BOOL DEFAULT 0,
  PRIMARY KEY (`id`)
);
ALTER TABLE `covidec`.`heat_map`  
  ENGINE=INNODB;


CREATE TABLE `covidec`.`heat_map_detail`(  
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `heat_map_id` INT UNSIGNED NOT NULL,
  `order` SMALLINT UNSIGNED NOT NULL,
  `initial_range` INT UNSIGNED,
  `final_range` INT UNSIGNED,
  `color` CHAR(10),
  `deleted` BOOL DEFAULT 0,
   KEY(`id`),
  UNIQUE INDEX `uq_heat_map_detail_order` (`order`),
  CONSTRAINT `fk_heat_map_detail_heat_map` FOREIGN KEY (`heat_map_id`) REFERENCES `covidec`.`heat_map`(`id`) ON UPDATE CASCADE ON DELETE CASCADE
);
ALTER TABLE `covidec`.`heat_map_detail`  
  ENGINE=INNODB;


ALTER TABLE `covidec`.`infographic`  
  ADD CONSTRAINT `fk_infographic_heat_map` FOREIGN KEY (`heat_map_id`) REFERENCES `covidec`.`heat_map`(`id`) ON UPDATE RESTRICT ON DELETE RESTRICT;



CREATE TABLE `covidec`.`age_group`(  
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `deleted` BOOL DEFAULT 0,
  PRIMARY KEY (`id`)
);
ALTER TABLE `covidec`.`age_group`  
  ENGINE=INNODB;


CREATE TABLE `covidec`.`age_group_data`(  
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `confirmed_cases` INT UNSIGNED,
  `age_group_id` INT UNSIGNED,
  `infographic_id` INT UNSIGNED,
  `deleted` BOOL DEFAULT 0,
  PRIMARY KEY (`id`)
);

ALTER TABLE `covidec`.`age_group_data`  
  ADD CONSTRAINT `fk_age_group_data_age_group` FOREIGN KEY (`age_group_id`) REFERENCES `covidec`.`age_group`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
  ADD CONSTRAINT `fk_age_group_data_infographic` FOREIGN KEY (`infographic_id`) REFERENCES `covidec`.`infographic`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT
  ;


CREATE TABLE `covidec`.`region`(  
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `deleted` BOOL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=INNODB;


CREATE TABLE `covidec`.`province`(  
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `region_id` INT UNSIGNED,
  `deleted` BOOL DEFAULT 0,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_province_region` FOREIGN KEY (`region_id`) REFERENCES `covidec`.`region`(`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=INNODB;


CREATE TABLE `covidec`.`canton`(  
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `province_id` INT UNSIGNED,
  `deleted` BOOL DEFAULT 0,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_canton_province` FOREIGN KEY (`province_id`) REFERENCES `covidec`.`province`(`id`) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=INNODB;

CREATE TABLE `covidec`.`canton_data`(  
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `canton_id` INT UNSIGNED,
  `infographic_id` INT UNSIGNED,
  `name` VARCHAR(50) NOT NULL,
  `confirmed_cases` INT UNSIGNED,
  `deleted` BOOL DEFAULT 0,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_canton_data_canton` FOREIGN KEY (`canton_id`) REFERENCES `covidec`.`canton`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_canton_data_infographic` FOREIGN KEY (`infographic_id`) REFERENCES `covidec`.`infographic`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=INNODB;


CREATE TABLE `covidec`.`province_data`(  
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `province_id` INT UNSIGNED NOT NULL,
  `infographic_id` INT UNSIGNED NOT NULL,
  `decesased` INT UNSIGNED,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_province_data_province` FOREIGN KEY (`province_id`) REFERENCES `covidec`.`province`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT `fk_province_data_infographic` FOREIGN KEY (`infographic_id`) REFERENCES `covidec`.`infographic`(`id`) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=INNODB;





# Grupo etario
INSERT INTO `covidec`.`age_group` (`name`) VALUES ('de 0 a 11 meses');
INSERT INTO `covidec`.`age_group` (`name`) VALUES ('de 1 a 4 años');
INSERT INTO `covidec`.`age_group` (`name`) VALUES ('de 5 a 9 años');
INSERT INTO `covidec`.`age_group` (`name`) VALUES ('de 10 a 14 años');
INSERT INTO `covidec`.`age_group` (`name`) VALUES ('de 15 a 19 años');
INSERT INTO `covidec`.`age_group`(`name`) VALUES ('de 20 a 49 años');
INSERT INTO `covidec`.`age_group` (`name`) VALUES ('de 50 a 64 años');
INSERT INTO `covidec`.`age_group` (`name`) VALUES ('más de 65');

# Mapa de calor
INSERT INTO `covidec`.`heat_map` (`name`) VALUES ('Mapa 1');
INSERT INTO `covidec`.`heat_map_detail` (`heat_map_id`, `order`, `initial_range`, `final_range`, `color`) VALUES ('1', '1', '1', '500', '#36e5cd');
INSERT INTO `covidec`.`heat_map_detail` (`heat_map_id`, `order`, `initial_range`, `final_range`, `color`) VALUES ('1', '2', '501', '1000', '#f8d488');
INSERT INTO `covidec`.`heat_map_detail` (`heat_map_id`, `order`, `initial_range`, `final_range`, `color`) VALUES ('1', '3', '1001', '5000', '#f8b688');
INSERT INTO `covidec`.`heat_map_detail` (`heat_map_id`, `order`, `initial_range`, `final_range`, `color`) VALUES ('1', '4', '5001', '10000', '#f6826d');
INSERT INTO `covidec`.`heat_map_detail` (`heat_map_id`, `order`, `initial_range`, `final_range`, `color`) VALUES ('1', '5', '10001', '14000000', '#ff0c0c');

#Regiones
INSERT INTO `covidec`.`region` (`name`) VALUES ('Costa');
INSERT INTO `covidec`.`region` (`name`) VALUES ('Sierra');
INSERT INTO `covidec`.`region` (`name`) VALUES ('Oriente');
INSERT INTO `covidec`.`region` (`name`) VALUES ('Región Insular');

#Provincias
INSERT INTO `covidec`.`province` (`name`, `region_id`) VALUES ('Azuay', '2');
INSERT INTO `covidec`.`province` (`name`, `region_id`) VALUES ('Bolívar', '2');
INSERT INTO `covidec`.`province` (`name`, `region_id`) VALUES ('Cañar', '2');
INSERT INTO `covidec`.`province` (`name`, `region_id`) VALUES ('Carchi', '2');
INSERT INTO `covidec`.`province` (`name`, `region_id`) VALUES ('Chimborazo', '2');
INSERT INTO `covidec`.`province` (`name`, `region_id`) VALUES ('Cotopaxi', '2');
INSERT INTO `covidec`.`province` (`name`, `region_id`) VALUES ('El Oro', '1');
INSERT INTO `covidec`.`province` (`name`, `region_id`) VALUES ('Esmeraldas', '1');
INSERT INTO `covidec`.`province` (`name`, `region_id`) VALUES ('Galápagos', '4');
INSERT INTO `covidec`.`province` (`name`, `region_id`) VALUES ('Guayas', '1');
INSERT INTO `covidec`.`province` (`name`, `region_id`) VALUES ('Imbabura', '2');
INSERT INTO `covidec`.`province` (`name`, `region_id`) VALUES ('Loja', '2');
INSERT INTO `covidec`.`province` (`name`, `region_id`) VALUES ('Los Ríos', '1');
INSERT INTO `covidec`.`province` (`name`, `region_id`) VALUES ('Manabí', '1');
INSERT INTO `covidec`.`province` (`name`, `region_id`) VALUES ('Morona Santiago', '3');
INSERT INTO `covidec`.`province` (`name`, `region_id`) VALUES ('Napo', '3');
INSERT INTO `covidec`.`province` (`name`, `region_id`) VALUES ('Orellana', '3');
INSERT INTO `covidec`.`province` (`name`, `region_id`) VALUES ('Pastaza', '3');
INSERT INTO `covidec`.`province` (`name`, `region_id`) VALUES ('Pichincha', '2');
INSERT INTO `covidec`.`province` (`name`, `region_id`) VALUES ('Santa Elena', '1');
INSERT INTO `covidec`.`province` (`name`, `region_id`) VALUES ('Sto. Domingo Tsáchilas', '2');
INSERT INTO `covidec`.`province` (`name`, `region_id`) VALUES ('Sucumbíos', '3');
INSERT INTO `covidec`.`province` (`name`, `region_id`) VALUES ('Tungurahua', '1');
INSERT INTO `covidec`.`province` (`name`, `region_id`) VALUES ('Zamora Chinchipe', '3');

#Infografía 145
INSERT INTO `covidec`.`infographic` (`number`, `start_date`, `cut_date_time`, `heat_map_id`) VALUES ('145', '2020-02-29', '2020-07-21', '1');
# Datos País infografía 145
INSERT INTO `covidec`.`national_data` (`infographic_id`, `recovered_patients`, `hospital_discharge`, `high_epidemiology`, `cases_ruled_out`, `confirmed_cases`, `dead_people`, `probable_deceased`, `stable_home_isolation`, `stable_hospitalized`, `hospitalized_prognosis_reserved`, `total_samples_taken`, `confirmed_percentage_men`, `confirmed_percentage_women`, `discarded_pcr`, `confirmed_pcr`, `confirmed_rapid_test`, `discarded_rapid_test`) VALUES ('1', '5900', '9779', '17046', '103507', '76217', '5366', '3400', '37026', '753', '347', '207780', '54.1', '45.9', '91891', '67261', '8956', '11616');
# El Gobierno de Todos ;)
