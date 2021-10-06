CREATE DATABASE IF NOT EXISTS bd_app_reservas;

USE bd_app_reservas;

CREATE TABLE IF NOT EXISTS habitaciones (
    id INT(11) NOT NULL AUTO_INCREMENT,
    numero CHAR(3) NOT NULL UNIQUE,
    tipo_habitacion ENUM('simple', 'doble', 'triple', 'matrimonial', 'suite') NOT NULL,
    bano_privado BOOLEAN NOT NULL,
    precio DECIMAL(6, 2) NOT NULL,
    PRIMARY KEY(id)

);