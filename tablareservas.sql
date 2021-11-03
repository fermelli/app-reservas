CREATE TABLE IF NOT EXISTS reservas (
    id INT(11) NOT NULL AUTO_INCREMENT,
    fecha DATE NOT NULL DEFAULT CURRENT_DATE,
    fecha_inicio DATE NOT NULL CHECK(fecha_inicio >= fecha),
    fecha_fin DATE NOT NULL CHECK(fecha_fin >= fecha_inicio),
    esta_activo BOOLEAN NOT NULL DEFAULT TRUE,
    habitacion_id INT(11) NOT NULL,
    cliente_id INT(11) NOT NULL,
    promocion_id_promo INT(11),
    habitacion_id_promo INT(11),
    PRIMARY KEY(id),
    FOREIGN KEY (habitacion_id) REFERENCES habitaciones(id),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id),
    FOREIGN KEY (promocion_id_promo, habitacion_id_promo) REFERENCES promocion_habitacion (promocion_id, habitacion_id)
);
