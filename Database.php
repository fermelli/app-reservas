   
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
        $validFilters = ['preciomax', 'tipohabitacion', 'banoprivado'];
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
}
