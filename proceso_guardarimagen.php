<?php
    $nombre=$_POST['nombre'];
    $imagen= addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
    $query ="INSERT INTO imagenes(ruta_imagen,nombre_imagen) VALUES('$nombre','$imagen')";
    $resultado=$conexion->query($query);

    if ($resultado) {
        echo "Si se inserto";
    }else{
        echo "No se inserto";
    }
?>