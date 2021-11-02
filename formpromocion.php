<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estilos.css">
    <link rel="icon" href="./favicon.ico">
    <title>Registrar promoción</title>
</head>

<body>
    <div class="container">
        <?php
        $enlaceActivo = null;
        $esTemaOscuro = TRUE;
        require_once "./commons/header.php";
        ?>
        <div class="container-form">
            <form class="form-promo" action="./crearpromocion.php" method="post">
                <div class="form-promo__section">
                    <h2 class="form-promo__title">Datos promoción</h2>
                    <div class="field field--input">
                        <label class="field__label" for="nombre">Nombre</label>
                        <input class="field__input field__input--outline" id="nombre" type="text" name="nombre" placeholder="Nombre" required>
                    </div>
                    <div class="field field--input">
                        <label class="field__label" for="descuento">Descuento (%)</label>
                        <input class="field__input field__input--outline" id="descuento" type="number" name="descuento" placeholder="Descuento" min="1" max="100" step="1" required>
                    </div>
                    <div class="field field--input">
                        <label class="field__label" for="fechainicio">Fecha inicio</label>
                        <input class="field__input field__input--outline" id="fechainicio" type="date" name="fechainicio" required>
                    </div>
                    <div class="field field--input">
                        <label class="field__label" for="fechafin">Fecha fin</label>
                        <input class="field__input field__input--outline" id="fechafin" type="date" name="fechafin" required>
                    </div>
                </div>
                <div class="form-promo__section">
                    <h2 class="form-promo__title">Habitaciones</h2>
                    <?php
                    include('database-init.php');
                    $habitaciones = $db->getRooms([]);
                    if ($habitaciones) :
                        foreach ($habitaciones as $habitacion) :
                    ?>
                            <div class="field field--checkbox my-3">
                                <input class="field__checkbox" id="habitacion<?= $habitacion['id'] ?>" type="checkbox" name="idshabitaciones[]" value="<?= $habitacion['id'] ?>">
                                <label class="field__label field__label--checkbox" for="habitacion<?= $habitacion['id'] ?>">
                                    Habitación #<?= $habitacion['numero'] ?>
                                    <span class="text-small">
                                        <?= ucfirst($habitacion['tipo_habitacion']) ?>, <?= $habitacion['precio'] ?><?= $habitacion['bano_privado'] ? ', baño privado' : '' ?>
                                    </span>
                                </label>
                            </div>
                        <?php
                        endforeach;
                    else :
                        ?>
                        <p>No hay registros</p>
                    <?php
                    endif;
                    ?>
                </div>
                <div class="form-promo__section py-5">
                    <input class="btn btn-primary" type="submit" value="Registrar">
                    <input class="btn btn-secondary" type="reset" value="Restablecer">
                </div>
            </form>
        </div>
    </div>
    <script src="./js/main.js"></script>
</body>

</html>