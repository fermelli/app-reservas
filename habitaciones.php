<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estilos.css">
    <link rel="icon" href="./favicon.ico">
    <title>Habitaciones reservadas y libres</title>
</head>

<body>
    <div class="container">
        <?php
        $enlaceActivo = 'habitaciones.php';
        $esTemaOscuro = TRUE;
        require_once "./commons/header.php";
        ?>
        <div class="container-cards">
            <h2 class="container-cards__title">Habitaciones reservadas</h2>
            <?php
            include('database-init.php');
            $habitacionesReservadas = $db->getReservedRooms();
            if (count($habitacionesReservadas) > 0) :
                foreach ($habitacionesReservadas as $habitacion) :
                    $priceArray = explode(".", $habitacion['precio']);
            ?>
                    <div class="card">
                        <div class="card__head">
                            <h2 class="card__title">#<?= $habitacion['numero'] ?></h2>
                            <a href="#" class="card__link">
                                <svg class="card__link-icon" xmlns="http://www.w3.org/2000/svg">
                                    <use href="./feather-sprite.svg#external-link" />
                                </svg>
                            </a>
                        </div>
                        <div class="card__body">
                            <ul class="card__list">
                                <li class="card__item"><?= ucfirst($habitacion['tipo_habitacion']) ?></li>
                                <li class="card__item"><span class='<?= $habitacion['bano_privado'] ? '' : 'strikethrough'  ?>'>Baño privado</span></li>
                                <li class="card__item">
                                    <span class="money">BOB <?= $priceArray[0] ?> <sup><?= $priceArray[1] ?></sup></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php
                endforeach;
            else :
                ?>
                <div class="alert-no-records">No hay registros de reservaciones de habitaciones.</div>
            <?php
            endif;
            ?>
        </div>
        <div class="container-cards">
            <h2 class="container-cards__title">Habitaciones sin reservas</h2>
            <?php
            $habitacionesSinReservas = $db->getRoomsWithoutReservations();
            if (count($habitacionesSinReservas) > 0) :
                foreach ($habitacionesSinReservas as $habitacion) :
                    $priceArray = explode(".", $habitacion['precio']);
            ?>
                    <div class="card">
                        <div class="card__head">
                            <h2 class="card__title">#<?= $habitacion['numero'] ?></h2>
                            <a href="#" class="card__link">
                                <svg class="card__link-icon" xmlns="http://www.w3.org/2000/svg">
                                    <use href="./feather-sprite.svg#external-link" />
                                </svg>
                            </a>
                        </div>
                        <div class="card__body">
                            <ul class="card__list">
                                <li class="card__item"><?= ucfirst($habitacion['tipo_habitacion']) ?></li>
                                <li class="card__item"><span class='<?= $habitacion['bano_privado'] ? '' : 'strikethrough'  ?>'>Baño privado</span></li>
                                <li class="card__item">
                                    <span class="money">BOB <?= $priceArray[0] ?> <sup><?= $priceArray[1] ?></sup></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php
                endforeach;
            else :
                ?>
                <div class="alert-no-records">No hay registros de habitaciones sin reservas.</div>
            <?php
            endif;
            ?>
        </div>
    </div>
</body>

</html>