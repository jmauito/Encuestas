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
