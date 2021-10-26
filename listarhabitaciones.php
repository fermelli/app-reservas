<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estilos.css">
    <link rel="icon" href="./favicon.ico">
    <title>Habitaciones</title>
</head>

<body>
    <div class="container">
        <header class="navbar">
            <div class="navbar__container-logo">
                <a href="#" class="navbar__logo-link">
                    <img class="navbar__logo" src="./logo.png" alt="Logo">
                </a>
            </div>
            <nav class="navbar__menu">
                <ul class="navbar__list">
                    <li class="navbar__list-item">
                        <a class="navbar__link" href="./habitaciones.php">Habitaciones</a>
                    </li>
                    <li class="navbar__list-item">
                        <a class="navbar__link" href="./registrarhabitaciones.php">Registrar</a>
                    </li>
                    <li class="navbar__list-item">
                        <a class="navbar__link navbar__link--active" href="./listarhabitaciones.php">Buscar</a>
                    </li>
                </ul>
            </nav>
        </header>
        <div class="container-filters">
            <form class="form" action="./listarhabitaciones.php" method="GET">
                <div class="container-inputs">
                    <div class="container-inputs__section">
                        <div class="field field--input">
                            <label class="field__label" for="preciomax">Precio máximo</label>
                            <input class="field__input" id="preciomax" type="number" name="preciomax" placeholder="Precio máximo" min="0" max="9999.99" step="0.01" value="<?= isset($_GET['preciomax']) ? $_GET['preciomax'] : '' ?>">
                        </div>
                        <div class="field field--select">
                            <label class="field__label" for="tipohabitacion">Tipo de habitación</label>
                            <select class="field__select" id="tipohabitacion" name="tipohabitacion">
                                <option class="field__option" value="" selected>Todos los tipos</option>
                                <?php
                                include('database-init.php');
                                $roomTypes = $db->getRoomTypes();
                                foreach ($roomTypes as $roomType) :
                                ?>
                                    <option class="field__option" value="<?= $roomType ?>" <?= isset($_GET['tipohabitacion']) && $_GET['tipohabitacion'] == $roomType ? 'selected' : '' ?>>
                                        <?= ucfirst($roomType) ?>
                                    </option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="field field--checkbox">
                            <input class="field__checkbox" id="banoprivado" type="checkbox" name="banoprivado" value="1" <?= isset($_GET['banoprivado']) ? 'checked' : '' ?>>
                            <label class="field__label field__label--checkbox" for="banoprivado">Baño privado</label>
                        </div>
                    </div>
                    <div class="container-inputs__section">
                        <?php
                        $fechaInicio = isset($_GET['fechas'][0]) ? $_GET['fechas'][0] : '';
                        $fechaFin = isset($_GET['fechas'][1]) ? $_GET['fechas'][1] : '';
                        ?>
                        <div class="field field--input">
                            <label class="field__label" for="fechainicio">Fecha inicio</label>
                            <input class="field__input" id="fechainicio" type="date" name="fechas[0]" placeholder="Precio máximo" value="<?= $fechaInicio ?>">
                        </div>
                        <div class="field field--input">
                            <label class="field__label" for="fechafin">Fecha fin</label>
                            <input class="field__input" id="fechafin" type="date" name="fechas[1]" placeholder="Precio máximo" value="<?= $fechaFin ?>">
                        </div>
                    </div>
                </div>
                <div class="container-actions">
                    <input class="btn btn-primary" type="submit" value="Buscar">
                    <input class="btn btn-secondary" type="reset" onclick="location.assign('./listarhabitaciones.php')" value="Restablecer">
                </div>
            </form>
        </div>
        <div class="container-cards">
            <?php
            $filtros = $_GET;
            $habitaciones = $db->getRooms($filtros);
            if (count($habitaciones) > 0) :
                foreach ($habitaciones as $habitacion) :
                    $priceArray = explode(".", $habitacion['precio']);
            ?>
                    <div class="card">
                        <div class="card__head">
                            <h2 class="card__title">#<?= $habitacion['numero'] ?></h2>
                            <a href="./habitacion.php?id=<?= $habitacion['id'] ?>&fechainicio=<?= $fechaInicio ?>&fechafin=<?= $fechaFin ?>" class="card__link">
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
                <div class="alert-no-records">No hay registros con los criterios establecidos. Puede <a class="alert-no-records__link" href="javascript:location.assign('./listarhabitaciones.php')" title="Restablecer criterios y buscar">restablecer</a> los criterios de búsqueda.</div>
            <?php
            endif;
            ?>
        </div>
    </div>
    <script src="./js/main.js"></script>
</body>

</html>