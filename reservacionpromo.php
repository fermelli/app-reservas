<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estilos.css">
    <link rel="icon" href="./favicon.ico">
    <title>Promoción habitación</title>
</head>

<body>
    <div class="container">
        <?php
        $enlaceActivo = null;
        $esTemaOscuro = TRUE;
        require_once "./commons/header.php";
        ?>
        <section>
            <?php
            if (isset($_GET['habitacionid'], $_GET['promocionid'])) :
                $habitacionid = $_GET['habitacionid'];
                $promocionId = $_GET['promocionid'];
                include('database-init.php');
                $habitacion = $db->getRoomById($habitacionid);
                $reservaciones = $db->getReservationsByRoomId($habitacionid);
                $promo = $db->getPromo($promocionId);

                if ($habitacion) :
                    $priceArray = explode(".", $habitacion['precio']);
                    $newPrice = round((1 - $promo['porcentaje_descuento'] / 100) * $habitacion['precio']);
            ?>
                    <div class="container-cards-detail">
                        <div class="card-detail head">
                            <div class="card-detail__head">
                                <h1 class="card-detail__title">Habitación #<?= $habitacion['numero'] ?></h1>
                            </div>
                        </div>
                        <div class="card-detail sidebar-top">
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
                                        <span class="money">BOB <?= $newPrice ?> <sup><?= '00' ?></sup></span>&nbsp;&nbsp;(- <?= $promo['porcentaje_descuento'] ?> %)
                                    </li>
                                    <li class="card-detail__list-item">
                                        <span class="strikethrough">BOB <?= $priceArray[0] ?> <sup><?= $priceArray[1] ?></sup></span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-detail sidebar-bottom">
                            <div class="card-detail__head">
                                <h2 class="card-detail__title">Reservas</h2>
                            </div>
                            <div class="card-detail__body">
                                <?php
                                if ($reservaciones) :
                                ?>
                                    <ul class="card-detail__list">
                                        <li class="card-detail__list-item">
                                            <span class="list-title">Fecha inicio / Fecha fin</span>
                                        </li>
                                        <?php
                                        foreach ($reservaciones as $reservacion) :
                                        ?>
                                            <li class="card-detail__list-item">
                                                <span class="pin"></span>
                                                <?= $reservacion['fecha_inicio'] ?>
                                                <svg class="mini-icon mini-icon--in" xmlns="http://www.w3.org/2000/svg">
                                                    <use href="./feather-sprite.svg#calendar" />
                                                </svg>
                                                /
                                                <?= $reservacion['fecha_fin'] ?>
                                                <svg class="mini-icon mini-icon--out" xmlns="http://www.w3.org/2000/svg">
                                                    <use href="./feather-sprite.svg#calendar" />
                                                </svg>
                                            </li>
                                        <?php
                                        endforeach;
                                        ?>
                                    </ul>
                                <?php
                                else :
                                ?>
                                    <span class="empty-message">No hay reservas vigentes</span>
                                <?php
                                endif;
                                ?>

                            </div>
                        </div>
                        <div class="card-detail main">
                            <div class="card-detail__head">
                                <h2 class="card-detail__title">Reservar con promoción</h2>
                            </div>
                            <div class="card-detail__body">
                                <form class="form-reservation" action="./registrarreserva.php" method="POST">
                                    <div class="form-reservation__section">
                                        <h3 class="form-reservation__section-title">Datos cliente</h3>
                                        <div class="field field--w50 field--input">
                                            <label class="field__label" for="ci">Carnet de identidad</label>
                                            <input class="field__input field__input--outline" id="ci" type="number" name="ci" placeholder="Carnet de identidad del cliente" min="0" step="1" required>
                                        </div>
                                        <div class="field field--w50 field--input">
                                            <label class="field__label" for="nombres">Nombres</label>
                                            <input class="field__input field__input--outline" id="nombres" type="text" name="nombres" placeholder="Nombres del cliente" required>
                                        </div>
                                        <div class="field field--w50 field--input">
                                            <label class="field__label" for="apellidopaterno">Apellido paterno</label>
                                            <input class="field__input field__input--outline" id="apellidopaterno" type="text" name="apellidopaterno" placeholder="Apellido paterno del cliente" required>
                                        </div>
                                        <div class="field field--w50 field--input">
                                            <label class="field__label" for="apellidomaterno">Apellido materno</label>
                                            <input class="field__input field__input--outline" id="apellidomaterno" type="text" name="apellidomaterno" placeholder="Apellido materno del cliente" required>
                                        </div>
                                        <div class="field field--w50 field--input">
                                            <label class="field__label" for="telefono">Teléfono</label>
                                            <input class="field__input field__input--outline" id="telefono" type="tel" name="telefono" placeholder="Teléfono del cliente" required>
                                        </div>
                                    </div>
                                    <div class="form-reservation__section">
                                        <h3 class="form-reservation__section-title">Datos reserva</h3>
                                        <div class="field field--select">
                                            <label class="field__label" for="fechainicio">Fecha inicio</label>
                                            <select class="field__select field__select--outline" id="fechainicio" name="fechainicio" oninput="document.getElementById('fechafin').setAttribute('min', this.value);" required>
                                                <option class="field__option" value="" disabled selected>-- Seleccione una fecha --</option>
                                                <?php
                                                function dateToTimestamp($dateString)
                                                {
                                                    $dateArray = explode('-', $dateString);
                                                    return mktime(0, 0, 0, $dateArray[1], $dateArray[2], $dateArray[0]);
                                                }
                                                $startTime = dateToTimestamp($promo['fecha_inicio']);
                                                $endTime = dateToTimestamp($promo['fecha_fin']);
                                                for ($i = $startTime; $i <= $endTime; $i += 86400) {
                                                ?>
                                                    <option class="field__option" value="<?= date('Y-m-d', $i) ?>"><?= date('Y-m-d', $i) ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="field field--w50 field--input">
                                            <label class="field__label" for="fechafin">Fecha fin</label>
                                            <input class="field__input field__input--outline" id="fechafin" type="date" name="fechafin" min="<?= $promo['fecha_inicio'] ?>" required>
                                        </div>
                                        <input type="hidden" name="habitacionid" value="<?= $_GET['id'] ?>">
                                    </div>
                                    <div class="form-reservation__section actions">
                                        <input class="btn btn-primary" type="submit" value="Reservar">
                                        <input class="btn btn-secondary" type="reset" value="Restablecer">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php
                else :
                ?>
                    <div class="no-records">
                        <h2 class="no-records__title">No existe la habitación solicitada</h2>
                        <p class="no-records__content">Por favor intente nuevamente en <a href="./listarhabitaciones.php">lista de habitaciones</a></p>
                        <svg class="no-records__icon" xmlns="http://www.w3.org/2000/svg" width="128px" height="128px">
                            <use href="./feather-sprite.svg#no-agency-records" />
                        </svg>
                    </div>
                <?php
                endif;
            else :
                ?>
                <h2>Error de peticion</h2>
                <p>Por favor intente nuevamente en <a href="./listarhabitaciones.php">lista de habitaciones</a></p>
                <svg xmlns="http://www.w3.org/2000/svg" width="128x" height="128px">
                    <use href="./feather-sprite.svg#no-agency-records" />
                </svg>
            <?php
            endif;
            ?>
        </section>
    </div>
    <!-- <script src="./js/main.js"></script> -->
</body>

</html>