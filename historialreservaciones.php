<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estilos.css">
    <link rel="icon" href="./favicon.ico">
    <title>Habitación</title>
</head>

<body>
    <?php
    $enlaceActivo = null;
    $esTemaOscuro = TRUE;
    require_once "./commons/header.php";
    ?>
    <div class="container-fluid">
        <section>
            <?php
            if (isset($_GET['id'])) :
                $id = $_GET['id'];
                include('database-init.php');
                $habitacion = $db->getRoomById($id);
                $reservaciones = $db->getHistorialReservationsByRoomId($id);

                if ($habitacion) :
                    $priceArray = explode(".", $habitacion['precio']);
            ?>
                    <div class="container-cards-detail container-cards-detail--fluid">
                        <div class="card-detail head">
                            <div class="card-detail__head">
                                <h1 class="card-detail__title">Habitación #<?= $habitacion['numero'] ?></h1>
                            </div>
                        </div>
                        <div class="card-detail">
                            <div class="card-detail__head">
                                <h2 class="card-detail__title">Detalles</h2>
                            </div>
                            <div class="card-detail__body">
                                <ul class="card-detail__list">
                                    <li class="card-detail__list-item">
                                        <svg class="card__list-item-icon" xmlns="http://www.w3.org/2000/svg">
                                            <use href="./feather-sprite.svg#single-bed" />
                                        </svg>
                                        <span><?= ucfirst($habitacion['tipo_habitacion']) ?></span>
                                    </li>
                                    <li class="card-detail__list-item">
                                        <svg class="card__list-item-icon <?= $habitacion['bano_privado'] ?: ' card__list-item-icon--no-available' ?>" xmlns="http://www.w3.org/2000/svg">
                                            <use href="./feather-sprite.svg#bath" />
                                        </svg>
                                        <span class='<?= $habitacion['bano_privado'] ? '' : 'strikethrough'  ?>'>Baño privado</span>
                                    </li>
                                    <li class="card-detail__list-item">
                                        <span class="money">BOB <?= $priceArray[0] ?> <sup><?= $priceArray[1] ?></sup></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-detail">
                            <div class="card-detail__head">
                                <h2 class="card-detail__title">Historial de reservaciones</h2>
                            </div>
                            <div class="card-detail__body">
                                <a class="btn-link btn-link--primary" href="./habitaciones.php">Volver</a>
                                <?php
                                if (count($reservaciones) > 0) :
                                ?>
                                    <table class="table-historial">
                                        <thead>
                                            <tr>
                                                <th colspan="5">Reservación</th>
                                                <th colspan="5">Huesped</th>
                                                <th colspan="2">Promoción</th>
                                            </tr>
                                            <tr>
                                                <th>Fecha reservación</th>
                                                <th>Fecha inicio</th>
                                                <th>Fecha fin</th>
                                                <th>Precio (BOB)</th>
                                                <th>Activo</th>
                                                <th>Carnet de identidad</th>
                                                <th>Nombres</th>
                                                <th>Apellido paterno</th>
                                                <th>Apellido materno</th>
                                                <th>Teléfono</th>
                                                <th>Promoción</th>
                                                <th>% desc.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($reservaciones as $indice => $reservacion) {
                                                $porcentajeDescuento = $reservacion['porcentaje_descuento'] ? $reservacion['porcentaje_descuento'] : 0;
                                                $fechaInicio = $reservacion['fecha_inicio'];
                                                $fechaFin = $reservacion['fecha_fin'];
                                                $now = time();
                                            ?>
                                                <tr>
                                                    <td><?= $reservacion['fecha_reservacion'] ?></td>
                                                    <td><?= $fechaInicio ?></td>
                                                    <td><?= $fechaFin ?></td>
                                                    <td><?= round($habitacion['precio'] * (1 - ($porcentajeDescuento / 100))) . '.00' ?></td>
                                                    <td>
                                                        <?=
                                                        $now <= strtotime($fechaFin) ?
                                                            '<span class="pin-status pin-status--active" title=\'Activo\'></span>' :
                                                            '<span class="pin-status pin-status--inactive" title=\'Inactivo\'></span>'
                                                        ?>
                                                    </td>
                                                    <td><?= $reservacion['ci'] ?></td>
                                                    <td><?= $reservacion['nombres'] ?></td>
                                                    <td><?= $reservacion['apellido_paterno'] ?></td>
                                                    <td><?= $reservacion['apellido_materno'] ?></td>
                                                    <td><?= $reservacion['telefono'] ?></td>
                                                    <td><?= $reservacion['nombre'] ? $reservacion['nombre'] : 'Sin promo' ?></td>
                                                    <td><?= $porcentajeDescuento != 0 ? $porcentajeDescuento : '0'  ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                <?php
                                else :
                                ?>
                                    <p class="py-5">No hay reservaciones para esta habitación</p>
                                <?php
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                <?php
                else :
                ?>
                    <div class="no-records">
                        <h2 class="no-records__title">No existe la habitación solicitada</h2>
                        <p class="no-records__content">Por favor intente nuevamente en <a href="./habitaciones.php">lista de habitaciones reservadas y no reservadas</a></p>
                        <svg class="no-records__icon" xmlns="http://www.w3.org/2000/svg" width="128px" height="128px">
                            <use href="./feather-sprite.svg#no-agency-records" />
                        </svg>
                    </div>
                <?php
                endif;
            else :
                ?>
                <h2>Error de peticion</h2>
                <p>Por favor intente nuevamente en <a href="./habitaciones.php">lista de habitaciones reservadas y no reservadas</a></p>
                <svg xmlns="http://www.w3.org/2000/svg" width="128x" height="128px">
                    <use href="./feather-sprite.svg#no-agency-records" />
                </svg>
            <?php
            endif;
            ?>
        </section>
    </div>
    <script src="./js/main.js"></script>
</body>

</html>