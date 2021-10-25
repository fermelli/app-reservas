CREATE TABLE IF NOT EXISTS clientes (
    id INT(11) NOT NULL AUTO_INCREMENT,
    ci VARCHAR(16) NOT NULL,
    nombres VARCHAR(32) NOT NULL,
    apellido_paterno VARCHAR(24) NOT NULL,
    apellido_materno VARCHAR(24) NOT NULL,
    telefono VARCHAR(16) NOT NULL,
    PRIMARY KEY(id)
);