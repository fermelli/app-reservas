CREATE TABLE IF NOT EXISTS promociones (
    id INT NOT NULL AUTO_INCREMENT,
    nombre VARCHAR(72) NOT NULL,
    porcentaje_descuento INT NOT NULL CHECK(porcentaje_descuento >= 1 AND porcentaje_descuento <= 100),
    fecha DATE NOT NULL DEFAULT NOW(),
    fecha_inicio DATE NOT NULL CHECK(fecha_inicio >= fecha),
    fecha_fin DATE NOT NULL CHECK(fecha_fin >= fecha_inicio),
    primary key(id)
);