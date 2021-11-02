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
        <?php
        if (isset($_POST['idshabitaciones'])) :
            if (isset($_POST['nombre'], $_POST['descuento'], $_POST['fechainicio'], $_POST['fechafin'])) :

                $nombre = $_POST['nombre'];
                $descuento = $_POST['descuento'];
                $fechaInicio = $_POST['fechainicio'];
                $fechaFin = $_POST['fechafin'];
                $idsHabitaciones = $_POST['idshabitaciones'];
                include('database-init.php');
                try {
                    if ($idPromo = $db->storePromo($nombre, $descuento, $fechaInicio, $fechaFin, $idsHabitaciones)) :

        ?>
                        <div class="alert alert--success">
                            <h4 class="alert-title">Registro de promociones</h4>
                            <p class="alert-content">Promoción registrada correctamente</p>
                        </div>
                    <?php
                    else :
                    ?>
                        <div class="alert alert--danger">
                            <h4 class="alert-title">Registro de promociones</h4>
                            <p class="alert-content">No se puedo registrar la promoción</p>
                        </div>
                <?php
                    endif;
                } catch (\Throwable $th) {
                    echo "Error: {$th->getMessage()}";
                }

            else :
                ?>
                <div class="alert alert--danger">
                    <h4 class="alert-title">Registro de promociones</h4>
                    <p class="alert-content">Envie todos los datos necesarios</p>
                </div>
            <?php
            endif;
        else :
            ?>
            <div class="alert alert--danger">
                <h4 class="alert-title">Registro de promociones</h4>
                <p class="alert-content">Seleccione al menos una habitacion para registrar en la promoción</p>
            </div>
        <?php
        endif;
        ?>
        <meta http-equiv="refresh" content="1; url=./promociones.php">
    </div>
</body>

</html>