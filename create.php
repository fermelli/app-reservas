<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Habitacion</title>
    <link rel="stylesheet" href="/registrahab.css">
</head>

<body>
    <div class="container">
        <?php
        if (isset($_POST['numero'], $_POST['tipohabitacion'],$_POST['banio'],$_POST['precio'])) {
            $numero=$_POST['numero'];
            $tipohabitacion=$_POST['tipohabitacion'];
            $banio=$_POST['banio'];
            $precio=$_POST['precio'];

            include("database-init.php");
            if ($db->storeRoom($numero,$tipohabitacion,$banio,$precio)) {
            ?>
            <div class="contenedor">
            <p style="color: green;">Habitacion Registrada</p>
            </div>
            <?php             
            }else{?>
                <div class="contenedor">
                    <p style="color: red;">No se pudo registrar la habitacion</p>
                </div>
            <?php }
        }else{?>
            <div class="contenedor">
                <p style="color: blue;">Envia todos los prametros necesarios</p>
            </div>
        <?php
        }?>
    </div>
    <meta http-equiv="refresh" content="1; url=registrarhabitaciones.php">
</body>
</html>
