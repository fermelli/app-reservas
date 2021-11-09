CREATE TABLE IF NOT EXISTS comentarios (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nombre_completo VARCHAR(40) NOT NULL,
    valuacion TINYINT(1) NOT NULL CHECK(valuacion >= 1 AND valuacion <= 5),
    texto VARCHAR(144) NOT NULL,
    PRIMARY KEY(id)
);