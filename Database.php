   
<?php

class Database extends mysqli
{
    public function __construct($host, $user, $password, $database)
    {
        parent::__construct($host, $user, $password, $database);

        if (mysqli_connect_error()) {
            die('Error de conexión (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
        }
    }

    public function getRoomTypes()
    {
        $sql = "SHOW COLUMNS FROM habitaciones LIKE 'tipo_habitacion'";
        $result = $this->query($sql);
        if (!$result || $result->num_rows == 0) {
            return [];
        }
        $row = $result->fetch_assoc();
        $typeColumn = $row['Type'];
        preg_match('/enum\((.*)\)$/', $typeColumn, $matches);
        $roomTypes = str_getcsv($matches[1], ',', "'");
        return $roomTypes;
    }

    public function getRooms($filters)
    {
        $query = "SELECT id, numero, tipo_habitacion, bano_privado, precio FROM habitaciones";
        $applicableFilters = $this->applicableFilters($filters);
        $i = 0;
        foreach ($applicableFilters as $filter => $value) {
            if ($i == 0) {
                $query .= " WHERE";
            }
            $query .= $this->$filter($value);
            $i++;
            if ($i > 0 && $i < count($applicableFilters)) {
                $query .= " AND";
            }
        }
        $result = $this->query($query);
        if (!$result || $result->num_rows == 0) {
            return [];
        }
        $rooms = $result->fetch_all(MYSQLI_ASSOC);
        return $rooms;
    }

    private function applicableFilters($filters)
    {
        $validFilters = ['preciomax', 'tipohabitacion', 'banoprivado', 'fechas'];
        $applicableFilters = [];
        foreach ($filters as $filter => $value) {
            if ($value != '' && in_array($filter, $validFilters)) {
                $applicableFilters[$filter] = $value;
            }
        }
        return $applicableFilters;
    }

    private function preciomax($precio)
    {
        return " precio <= $precio";
    }

    private function tipohabitacion($tipo)
    {
        return " tipo_habitacion = '$tipo'";
    }

    private function banoprivado($value)
    {
        return " bano_privado = $value";
    }

    private function fechas($fechas)
    {
        return " id NOT IN (SELECT habitacion_id FROM reservas WHERE fecha_inicio BETWEEN '$fechas[0]' AND '$fechas[1]' OR fecha_fin BETWEEN '$fechas[0]' AND '$fechas[1]' AND esta_activo = 1)";
    }

    public function storeRoom($numero, $tipohabitacion, $banio, $precio)
    {
        $query = "INSERT INTO habitaciones (numero, tipo_habitacion, bano_privado, precio) VALUES ($numero, '$tipohabitacion',$banio, $precio)";
        return $this->query($query);
    }

    public function getRoomById($id)
    {
        $query = "SELECT id, numero, tipo_habitacion, bano_privado, precio FROM habitaciones WHERE id = $id";
        $result = $this->query($query);
        if (!$result || $result->num_rows == 0) {
            return [];
        }
        $room = $result->fetch_array(MYSQLI_ASSOC);
        return $room;
    }

    public function getReservationsByRoomId($id)
    {
        $query = "SELECT id, fecha_inicio, fecha_fin FROM reservas WHERE habitacion_id = $id AND esta_activo = 1 AND (fecha_inicio >= NOW() OR fecha_fin >= NOW())";
        $result = $this->query($query);
        if (!$result || $result->num_rows == 0) {
            return [];
        }
        $reservations = $result->fetch_all(MYSQLI_ASSOC);
        return $reservations;
    }

    public function storeReservation(
        $ci,
        $nombres,
        $apellidoPaterno,
        $apellidoMaterno,
        $telefono,
        $fechaInicio,
        $fechaFin,
        $habitacionId
    ) {
        $query = "SELECT id FROM reservas WHERE habitacion_id = $habitacionId AND (fecha_inicio BETWEEN '$fechaInicio' AND '$fechaFin' OR fecha_fin BETWEEN '$fechaInicio' AND '$fechaFin') AND esta_activo = 1";
        $result = $this->query($query);
        if ($result->num_rows == 0) {
            try {
                $this->begin_transaction();
                $query1 = "INSERT INTO clientes (ci, nombres, apellido_paterno, apellido_materno, telefono) VALUES ('$ci', '$nombres', '$apellidoPaterno', '$apellidoMaterno', '$telefono')";
                $this->query($query1);
                $clienteId = $this->insert_id;
                $query2 = "INSERT INTO reservas (fecha_inicio, fecha_fin, habitacion_id, cliente_id) VALUES ('$fechaInicio', '$fechaFin', $habitacionId, $clienteId)";
                $this->query($query2);
                $reservationId = $this->insert_id;
                $this->commit();
                return $reservationId;
            } catch (mysqli_sql_exception $exception) {
                $this->rollback();
                throw $exception;
            }
        } else {
            throw new Error("¡Error: La habitación no se encuentra disponible en esas fechas!");
        }
    }

    public function getReservationsById($id)
    {
        $query = "SELECT r.id, r.fecha, fecha_inicio, fecha_fin, habitacion_id, h.id, numero, tipo_habitacion, bano_privado, precio, c.id,  ci, nombres, apellido_paterno, apellido_materno, telefono FROM reservas AS r LEFT JOIN habitaciones AS h ON habitacion_id = h.id LEFT JOIN clientes AS c ON cliente_id = c.id WHERE r.id = $id AND esta_activo = 1 LIMIT 1";
        $result = $this->query($query);
        if (!$result || $result->num_rows == 0) {
            return [];
        }
        $reservation = $result->fetch_array(MYSQLI_ASSOC);
        return $reservation;
    }

    public function getReservedRooms()
    {
        $query = "SELECT id, numero, tipo_habitacion, bano_privado, precio FROM habitaciones WHERE id IN (SELECT habitacion_id FROM reservas WHERE (fecha_inicio >= NOW() OR fecha_fin >= NOW()) AND esta_activo = 1)";
        $result = $this->query($query);
        if (!$result || $result->num_rows == 0) {
            return [];
        }
        $reservedRooms = $result->fetch_all(MYSQLI_ASSOC);
        return $reservedRooms;
    }

    public function getRoomsWithoutReservations()
    {
        $query = "SELECT id, numero, tipo_habitacion, bano_privado, precio FROM habitaciones WHERE id NOT IN (SELECT habitacion_id FROM reservas WHERE (fecha_inicio >= NOW() OR fecha_fin >= NOW()) AND esta_activo = 1)";
        $result = $this->query($query);
        if (!$result || $result->num_rows == 0) {
            return [];
        }
        $reservedRooms = $result->fetch_all(MYSQLI_ASSOC);
        return $reservedRooms;
    }
}
