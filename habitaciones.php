<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estilos.css">
    <link rel="stylesheet" href="registrahab.css">
    <link rel="icon" href="./favicon.ico">
    <title>Habitaciones reservadas y libres</title>
</head>

<body>
    <div class="container">
        <header class="navbar navbar--dark">
            <div class="navbar__container-logo">
                <a href="#" class="navbar__logo-link">
                    <img class="navbar__logo" src="./logo-light.png" alt="Logo">
                </a>
            </div>
            <nav class="navbar__menu">
                <ul class="navbar__list">
                    <li class="navbar__list-item">
                        <a class="navbar__link navbar__link--active" href="./habitaciones.php">Habitaciones</a>
                    </li>
                    <li class="navbar__list-item">
                        <a class="navbar__link" href="./registrarhabitaciones.php">Registrar</a>
                    </li>
                    <li class="navbar__list-item">
                        <a class="navbar__link" href="./listarhabitaciones.php">Buscar</a>
                    </li>
                </ul>
            </nav>
        </header>
        <div class="container-cards">
            <h2 class="container-cards__title">Habitaciones reservadas</h2>
            <?php
            $habitaciones = [
                [
                    'id'                => 1,
                    'numero'            => '111',
                    'tipo_habitacion'   => 'simple',
                    'bano_privado'      => 1,
                    'precio'            => '120.00',
                ],
            ];
            if (count($habitaciones) > 0) :
                foreach ($habitaciones as $habitacion) :
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
            $habitaciones = [
                [
                    'id'                => 1,
                    'numero'            => '111',
                    'tipo_habitacion'   => 'simple',
                    'bano_privado'      => 1,
                    'precio'            => '120.00',
                ],
            ];
            if (count($habitaciones) > 0) :
                foreach ($habitaciones as $habitacion) :
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