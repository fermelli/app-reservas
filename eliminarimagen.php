<?php

if (isset($_POST['idhabitacion'])) :
    $idHabitacion = $_POST['idhabitacion'];
    if (isset($_POST['idimagen'])) :
        include('database-init.php');

        $idImagen = $_POST['idimagen'];
        $db->deleteImageById($idImagen);
    endif;

?>
    <meta http-equiv="refresh" content="0; url=./habitacion.php?id=<?= $idHabitacion ?>&fechainicio=&fechafin=">
<?php
else :
?>
    <meta http-equiv="refresh" content="0; url=./listarhabitaciones.php">
<?php
endif;
