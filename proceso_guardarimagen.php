<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estilos.css">
    <link rel="icon" href="./favicon.ico">
    <title>Guardar imagen</title>
</head>

<body>
    <div class="container">
        <?php
        if (isset($_POST['nombreimagen'], $_FILES['imagen'], $_POST['idhabitacion'])) :

            $nombreImagen = $_POST['nombreimagen'];
            $imagen = $_FILES['imagen'];
            $idhabitacion = $_POST['idhabitacion'];


            $nombre = $imagen['name'];
            $extension = explode('.', $nombre)[1];
            $tamanio = $imagen['size'];
            $temporal = $imagen['tmp_name'];
            $nuevoNombre = uniqid() . ".$extension";
            $ruta = "./public/images/$idhabitacion";

            if (!file_exists($ruta)) :
                mkdir($ruta, 0777, true);
            endif;

            include('database-init.php');

            if (copy($temporal, "$ruta/$nuevoNombre")) :
                if ($db->storeImageByRoomId($nombreImagen, "$ruta/$nuevoNombre", $idhabitacion)) :
        ?>
                    <div class="alert alert--success">
                        <h4 class="alert-title">Subir imagen</h4>
                        <p class="alert-content">Imagen subida correctamente</p>
                    </div>
                <?php
                else :
                    unlink("$ruta/$nuevoNombre");
                ?>
                    <div class="alert alert--danger">
                        <h4 class="alert-title">Subir imagen</h4>
                        <p class="alert-content">No se puedo subir la imagen</p>
                    </div>
            <?php
                endif;
            endif;

        else :
            ?>
            <div class="alert alert--danger">
                <h4 class="alert-title">Subir imagen</h4>
                <p class="alert-content">Envie todos los datos necesarios</p>
            </div>
        <?php
        endif;
        ?>
        <meta http-equiv="refresh" content="0; url=./habitacion.php?id=<?= $idhabitacion ?>&fechainicio=&fechafin=">
    </div>
</body>

</html>