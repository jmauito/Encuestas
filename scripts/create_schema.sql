CREATE SCHEMA `Encuesta` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish2_ci ;

CREATE TABLE `Encuesta`.`Cuestionario` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `activo` TINYINT(1) NOT NULL DEFAULT 0,
  `nombre` VARCHAR(50) NOT NULL,
  `descripcion` TEXT NULL,
  `createdAt` DATETIME NULL,
  `updatedAt` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `uq_cuestionario_nombre` (`nombre` ASC)) ENGINE InnoDB;
  
  
  CREATE TABLE `Encuesta`.`Seccion` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `cuestionarioId` INT UNSIGNED NOT NULL,
  `nombre` VARCHAR(50) NOT NULL,
  `descripcion` TEXT NULL,
  `orden` INT UNSIGNED NOT NULL,
  `createdAt` DATETIME NULL,
  `updatedAt` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  UNIQUE INDEX `uq_Seccion_nombre` (`cuestionarioId` ASC, `nombre` ASC),
  UNIQUE INDEX `uq_Seccion_orden` (`cuestionarioId` ASC, `orden` ASC),
  CONSTRAINT `fk_Seccion_Cuestionario`
    FOREIGN KEY (`id`)
    REFERENCES `encuesta`.`cuestionario` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE) ENGINE InnoDB;

   
ALTER TABLE `encuesta`.`seccion` 
ADD CONSTRAINT `fk_cuestionario_seccion`
  FOREIGN KEY (`cuestionarioId`)
  REFERENCES `encuesta`.`cuestionario` (`id`)
  ON DELETE CASCADE
  ON UPDATE CASCADE;
  
  
CREATE TABLE `encuesta`.`pregunta` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `seccionId` INT UNSIGNED NOT NULL,
  `orden` INT UNSIGNED NOT NULL,
  `descripcion` VARCHAR(500) NOT NULL,
  `tipoPreguntaId` INT UNSIGNED NOT NULL,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `createdAt` DATETIME NULL,
  `updatedAt` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) ,
  UNIQUE INDEX `uq_Pregunta_SeccionOrden` (`seccionId` ASC, `orden` ASC) ,
  UNIQUE INDEX `uq_Pregunta_SeccionDescripcion` (`descripcion` ASC, `seccionId` ASC) ,
  CONSTRAINT `fk_Pregunta_Seccion`
    FOREIGN KEY (`seccionId`)
    REFERENCES `encuesta`.`seccion` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE) ENGINE InnoDB;

ALTER TABLE `encuesta`.`pregunta` 
ADD COLUMN `nombre` VARCHAR(50) NOT NULL AFTER `orden`;

CREATE TABLE `encuesta`.`opcion` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `preguntaId` INT unsigned NOT NULL,
  `nombre` VARCHAR(50) NOT NULL,
  `descripcion` TEXT NULL,
  `orden` INT NOT NULL,
  `valor` INT NULL,
  `esCorrecta` TINYINT(1) NULL,
  `createdAt` DATETIME NULL,
  `updatedAt` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC), 
  CONSTRAINT `fk_Opcion_Pregunta`
    FOREIGN KEY (`preguntaId`)
    REFERENCES `encuesta`.`pregunta` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE) ENGINE = InnoDB
;


CREATE TABLE `encuesta`.`poblacion` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `nombre` VARCHAR(200) NOT NULL,
  `email` VARCHAR(200) NULL,
  `codigoExterno` VARCHAR(200) NULL COMMENT 'Para registrar el id en el programa externo de donde se migró la población',
  `createdAt` DATETIME NULL,
  `updatedAt` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC) )
ENGINE = InnoDB;


CREATE TABLE `encuesta`.`respuesta` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `poblacionId` INT UNSIGNED NOT NULL,
  `opcionId` INT UNSIGNED NOT NULL,
  `respuesta` MEDIUMTEXT NULL,
  `activo` TINYINT(1) NULL,
  `createdAt` DATETIME NULL,
  `updatedAt` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  CONSTRAINT `fk_respuesta_poblacion`
    FOREIGN KEY (`id`)
    REFERENCES `encuesta`.`poblacion` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
    ,
  CONSTRAINT `fk_respuesta_opcion`
    FOREIGN KEY (`id`)
    REFERENCES `encuesta`.`opcion` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) engine InnoDB;
