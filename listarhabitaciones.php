<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estilos.css">
    <title>Habitaciones</title>
</head>

<body>
    <div class="container">
        <div class="container-filters">
            <form class="form" action="./listarhabitaciones.php" method="GET">
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
                <input class="btn btn-primary" type="submit" value="Buscar">
                <input class="btn btn-secondary" type="reset" onclick="location.assign('./listarhabitaciones.php')" value="Restablecer">
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
                            <a href="./habitacion?id=<?= $habitacion['id'] ?>" class="card__link">
                                <svg class="card__link-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24px" height="24px">
                                    <path d="M 5 3 C 3.9069372 3 3 3.9069372 3 5 L 3 19 C 3 20.093063 3.9069372 21 5 21 L 19 21 C 20.093063 21 21 20.093063 21 19 L 21 12 L 19 12 L 19 19 L 5 19 L 5 5 L 12 5 L 12 3 L 5 3 z M 14 3 L 14 5 L 17.585938 5 L 8.2929688 14.292969 L 9.7070312 15.707031 L 19 6.4140625 L 19 10 L 21 10 L 21 3 L 14 3 z" />
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
                <div class="alert">No hay registros con los criterios establecidos. Puede <a class="alert__link" href="javascript:location.assign('./listarhabitaciones.php')" title="Restablecer criterios y buscar">restablecer</a> los criterios de búsqueda.</div>
            <?php
            endif;
            ?>
        </div>
    </div>
</body>

</html>