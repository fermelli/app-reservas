CREATE TABLE IF NOT EXISTS imagenes (
    id INT(11) NOT NULL AUTO_INCREMENT,
    ruta_imagen VARCHAR(50),
    nombre_imagen VARCHAR(50),
    id_habitacion INT(11) NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (id_habitacion) REFERENCES habitaciones(id)
);