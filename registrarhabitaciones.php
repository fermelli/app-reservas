<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estilos.css">
    <link rel="stylesheet" href="registrahab.css">
    <link rel="icon" href="./favicon.ico">
    <title>Registrar Habitacion</title>
</head>

<body>
    <?php
    $enlaceActivo = 'registrarhabitaciones.php';
    $esTemaOscuro = TRUE;
    require_once "./commons/header.php";
    ?>
    <div class="container">
        <section class="cuerpo">
            <div class="izquierda"></div>
            <div class="derecha">
                <h1 class="title">REGISTRAR HABITACION</h1>
                <form action="create.php" method="POST">
                    <div class='field'>
                        <label>Numero</label>
                        <input name='numero' type='number' required value="numero" placeholder='Número de habitacion' autocomplete />
                    </div>
                    <div class='field'>
                        <label>Tipo Habitación</label>
                        <select name='tipohabitacion' required>
                            <option selected disabled>Sel. una opción</option>
                            <?php
                            include("database-init.php");
                            $tipos = $db->getRoomTypes();
                            foreach ($tipos as $tipo) { ?>
                                <option value="<?= $tipo; ?>"><?= ucfirst($tipo); ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class='banio'>
                        <label>¿Baño Privado?</label>
                        <div><input name='banio' type='radio' value="1" />Sí</div>
                        <div><input name='banio' type='radio' value="0" />No</div>
                    </div>
                    <div class='field'>
                        <label>Precio</label>
                        <input name='precio' type='number' required placeholder='Precio de Habitación' />
                    </div>
                    <div class='submit'>
                        <button type="submit" name="registrar">Registrar</button>
                    </div>
                </form>

            </div>
        </section>
        <div class="pie"></div>
    </div>
</body>

</html>