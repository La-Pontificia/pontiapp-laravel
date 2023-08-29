-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema eda_consorcio
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema eda_consorcio
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `eda_consorcio` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ;
USE `eda_consorcio` ;

-- -----------------------------------------------------
-- Table `eda_consorcio`.`cargos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eda_consorcio`.`cargos` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo_cargo` VARCHAR(50) NOT NULL,
  `nombre_cargo` VARCHAR(50) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 10
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `eda_consorcio`.`areas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eda_consorcio`.`areas` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo_area` VARCHAR(10) NOT NULL,
  `nombre_area` VARCHAR(50) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 12
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `eda_consorcio`.`departamentos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eda_consorcio`.`departamentos` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo_departamento` VARCHAR(50) NOT NULL,
  `nombre_departamento` VARCHAR(50) NOT NULL,
  `id_area` BIGINT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `departamentos_id_area_foreign` (`id_area` ASC) VISIBLE,
  CONSTRAINT `departamentos_id_area_foreign`
    FOREIGN KEY (`id_area`)
    REFERENCES `eda_consorcio`.`areas` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `eda_consorcio`.`puestos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eda_consorcio`.`puestos` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo_puesto` VARCHAR(50) NOT NULL,
  `nombre_puesto` VARCHAR(255) NOT NULL,
  `id_departamento` BIGINT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `puestos_id_departamento_foreign` (`id_departamento` ASC) VISIBLE,
  CONSTRAINT `puestos_id_departamento_foreign`
    FOREIGN KEY (`id_departamento`)
    REFERENCES `eda_consorcio`.`departamentos` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 74
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `eda_consorcio`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eda_consorcio`.`users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NULL DEFAULT NULL,
  `email` VARCHAR(255) NOT NULL,
  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `remember_token` VARCHAR(100) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `users_email_unique` (`email` ASC) VISIBLE)
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `eda_consorcio`.`colaboradores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eda_consorcio`.`colaboradores` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `dni` VARCHAR(8) NOT NULL,
  `apellidos` VARCHAR(40) NOT NULL,
  `nombres` VARCHAR(40) NOT NULL,
  `estado` INT NOT NULL DEFAULT '1',
  `id_cargo` BIGINT UNSIGNED NOT NULL,
  `id_puesto` BIGINT UNSIGNED NOT NULL,
  `id_usuario` BIGINT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `colaboradores_id_cargo_foreign` (`id_cargo` ASC) VISIBLE,
  INDEX `colaboradores_id_puesto_foreign` (`id_puesto` ASC) VISIBLE,
  INDEX `colaboradores_id_usuario_foreign` (`id_usuario` ASC) VISIBLE,
  CONSTRAINT `colaboradores_id_cargo_foreign`
    FOREIGN KEY (`id_cargo`)
    REFERENCES `eda_consorcio`.`cargos` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `colaboradores_id_puesto_foreign`
    FOREIGN KEY (`id_puesto`)
    REFERENCES `eda_consorcio`.`puestos` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `colaboradores_id_usuario_foreign`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `eda_consorcio`.`users` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 7
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `eda_consorcio`.`accesos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eda_consorcio`.`accesos` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `modulo` VARCHAR(50) NOT NULL,
  `acceso` INT NOT NULL DEFAULT '0',
  `id_colaborador` BIGINT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `accesos_id_colaborador_foreign` (`id_colaborador` ASC) VISIBLE,
  CONSTRAINT `accesos_id_colaborador_foreign`
    FOREIGN KEY (`id_colaborador`)
    REFERENCES `eda_consorcio`.`colaboradores` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
AUTO_INCREMENT = 57
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `eda_consorcio`.`failed_jobs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eda_consorcio`.`failed_jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` VARCHAR(255) NOT NULL,
  `connection` TEXT NOT NULL,
  `queue` TEXT NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `exception` LONGTEXT NOT NULL,
  `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `failed_jobs_uuid_unique` (`uuid` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `eda_consorcio`.`migrations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eda_consorcio`.`migrations` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255) NOT NULL,
  `batch` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 14
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `eda_consorcio`.`objetivos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eda_consorcio`.`objetivos` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_colaborador` BIGINT UNSIGNED NOT NULL,
  `objetivo` VARCHAR(200) NOT NULL,
  `descripcion` VARCHAR(255) NOT NULL,
  `porcentaje` INT NOT NULL,
  `indicadores` VARCHAR(255) NOT NULL,
  `fecha_vencimiento` TIMESTAMP NULL DEFAULT NULL,
  `puntaje_01` DECIMAL(8,2) NOT NULL,
  `fecha_calificacion_1` TIMESTAMP NULL DEFAULT NULL,
  `fecha_aprobacion_1` TIMESTAMP NULL DEFAULT NULL,
  `puntaje_02` DECIMAL(8,2) NOT NULL,
  `fecha_calificacion_2` TIMESTAMP NULL DEFAULT NULL,
  `fecha_aprobacion_2` TIMESTAMP NULL DEFAULT NULL,
  `aprobado` INT NOT NULL DEFAULT '0',
  `aprovado_ev_1` INT NOT NULL DEFAULT '0',
  `aprovado_ev_2` INT NOT NULL DEFAULT '0',
  `año_actividad` VARCHAR(255) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `objetivos_id_colaborador_foreign` (`id_colaborador` ASC) VISIBLE,
  CONSTRAINT `objetivos_id_colaborador_foreign`
    FOREIGN KEY (`id_colaborador`)
    REFERENCES `eda_consorcio`.`colaboradores` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `eda_consorcio`.`password_reset_tokens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eda_consorcio`.`password_reset_tokens` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`email`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `eda_consorcio`.`password_resets`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eda_consorcio`.`password_resets` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  INDEX `password_resets_email_index` (`email` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `eda_consorcio`.`personal_access_tokens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eda_consorcio`.`personal_access_tokens` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` VARCHAR(255) NOT NULL,
  `tokenable_id` BIGINT UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `token` VARCHAR(64) NOT NULL,
  `abilities` TEXT NULL DEFAULT NULL,
  `last_used_at` TIMESTAMP NULL DEFAULT NULL,
  `expires_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `personal_access_tokens_token_unique` (`token` ASC) VISIBLE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type` ASC, `tokenable_id` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `eda_consorcio`.`supervisores`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `eda_consorcio`.`supervisores` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_colaborador` BIGINT UNSIGNED NOT NULL,
  `id_supervisor` BIGINT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `supervisores_id_colaborador_foreign` (`id_colaborador` ASC) VISIBLE,
  INDEX `supervisores_id_supervisor_foreign` (`id_supervisor` ASC) VISIBLE,
  CONSTRAINT `supervisores_id_colaborador_foreign`
    FOREIGN KEY (`id_colaborador`)
    REFERENCES `eda_consorcio`.`colaboradores` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `supervisores_id_supervisor_foreign`
    FOREIGN KEY (`id_supervisor`)
    REFERENCES `eda_consorcio`.`colaboradores` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
