<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estilos.css">
    <link rel="icon" href="./favicon.ico">
    <title>Promociones</title>
</head>

<body>
    <div class="container">
        <?php
        $enlaceActivo = 'promociones.php';
        $esTemaOscuro = TRUE;
        require_once "./commons/header.php";
        ?>
        <div class="container-actions">
            <a class="btn-link btn-link--primary" href="./formpromocion.php">Crear promoción</a>
        </div>
    </div>
</body>

</html>