<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estilos.css">
    <link rel="icon" href="./favicon.ico">
    <title>Registrar reserva</title>
</head>

<body>
    <div class="container">
        <?php

        if (isset($_POST['ci'], $_POST['nombres'], $_POST['apellidopaterno'], $_POST['apellidomaterno'], $_POST['telefono'], $_POST['fechainicio'], $_POST['fechafin'], $_POST['habitacionid'])) {
            $ci = $_POST['ci'];
            $nombres = $_POST['nombres'];
            $apellidoPaterno = $_POST['apellidopaterno'];
            $apellidoMaterno = $_POST['apellidomaterno'];
            $telefono = $_POST['telefono'];
            $fechaInicio = $_POST['fechainicio'];
            $fechaFin = $_POST['fechafin'];
            $habitacionId = $_POST['habitacionid'];

            include('database-init.php');

            try {
                $reservaId = $db->storeReservation($ci, $nombres, $apellidoPaterno, $apellidoMaterno, $telefono, $fechaInicio, $fechaFin, $habitacionId);

                $reservation = $db->getReservationsById($reservaId);
        ?>
                <div class="alert alert--success">
                    <h4 class="alert-title">Registro de reserva</h4>
                    <p class="alert-content">Reserva registrada correctamente</p>
                </div>
                <?php
                if ($reservation) :
                ?>
                    <div class="reservation-details">
                        <ul class="reservation-details__list">
                            <h3 class="reservation-details__title">Cliente</h3>
                            <li class="reservation-details__list-item">
                                <span>Nombres</span>
                                <span><?= $reservation['nombres'] ?></span>
                            </li>
                            <li class="reservation-details__list-item">
                                <span>Apellido paterno</span>
                                <span><?= $reservation['apellido_paterno'] ?></span>
                            </li>
                            <li class="reservation-details__list-item">
                                <span>Apellido materno</span>
                                <span><?= $reservation['apellido_materno'] ?></span>
                            </li>
                            <li class="reservation-details__list-item">
                                <span>Teléfono</span>
                                <span><?= $reservation['telefono'] ?></span>
                            </li>
                        </ul>
                        <ul class="reservation-details__list">
                            <h3 class="reservation-details__title">Habitación</h3>
                            <li class="reservation-details__list-item">
                                <span>Número</span>
                                <span><?= $reservation['numero'] ?></span>
                            </li>
                            <li class="reservation-details__list-item">
                                <span>Tipo</span>
                                <span><?= $reservation['tipo_habitacion'] ?></span>
                            </li>
                            <li class="reservation-details__list-item">
                                <span>Baño privado</span>
                                <span><?= $reservation['bano_privado'] ? 'Si' : 'No' ?></span>
                            </li>
                            <li class="reservation-details__list-item">
                                <span>Precio</span>
                                <span><?= $reservation['precio'] ?></span>
                            </li>
                        </ul>
                        <ul class="reservation-details__list">
                            <h3 class="reservation-details__title">Reserva</h3>
                            <li class="reservation-details__list-item">
                                <span>Fecha</span>
                                <span><?= $reservation['fecha'] ?></span>
                            </li>
                            <li class="reservation-details__list-item">
                                <span>Fecha inicio</span>
                                <span><?= $reservation['fecha_inicio'] ?></span>
                            </li>
                            <li class="reservation-details__list-item">
                                <span>Fecha fin</span>
                                <span><?= $reservation['fecha_fin'] ?></span>
                            </li>
                        </ul>
                    </div>
                    <a class="btn-link btn-link--primary" href="./listarhabitaciones.php">Aceptar</a>
                <?php
                endif;
            } catch (\Throwable $th) {
                ?>
                <div class="alert alert--danger">
                    <h4 class="alert-title">Registro de reserva</h4>
                    <p class="alert-content"><?= $th->getMessage(); ?>, volver a <a class="alert__link" href="./listarhabitaciones.php">buscar habitaciones</a></p>
                </div>
        <?php
            }
        }
        ?>
    </div>
</body>

</html>