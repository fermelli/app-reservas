CREATE TABLE IF NOT EXISTS promocion_habitacion (
    promocion_id INT(11) NOT NULL,
    habitacion_id INT(11) NOT NULL,
    PRIMARY KEY(promocion_id, habitacion_id),
    FOREIGN KEY (promocion_id) REFERENCES promociones(id),
    FOREIGN KEY (habitacion_id) REFERENCES habitaciones(id)
);