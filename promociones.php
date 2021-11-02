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
        <div class="container-promos">
            <?php
            include('database-init.php');
            $promociones = $db->getPromos();
            if ($promociones) :
            ?>
                <table class="table-promos">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre promoción</th>
                            <th>Descuento (%)</th>
                            <th>Inicio de la promo</th>
                            <th>Fin de la promo</th>
                            <th>Habitaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($promociones as $indice => $promocion) :
                        ?>
                            <tr>
                                <td><?= $indice + 1 ?></td>
                                <td><?= $promocion['nombre'] ?></td>
                                <td><?= $promocion['porcentaje_descuento'] ?></td>
                                <td><?= $promocion['fecha_inicio'] ?></td>
                                <td><?= $promocion['fecha_fin'] ?></td>
                                <td>
                                    <ul class="table-promos__list">
                                        <?php
                                        foreach ($promocion['habitaciones'] as $habitacion) :
                                        ?>
                                            <li class="table-promos__list-item">
                                                <a class="table-promos__link" href="./reservacionpromo.php?habitacionid=<?= $habitacion['id'] ?>&promocionid=<?= $promocion['id'] ?>">
                                                    Habitación #<?= $habitacion['numero'] ?>
                                                </a>
                                                <span class="text-small">
                                                    <?= ucfirst($habitacion['tipo_habitacion']) ?>,
                                                    <strong><?= round((1 - ($promocion['porcentaje_descuento'] / 100)) * $habitacion['precio']) . ".00" ?></strong>
                                                    <span class="strikethrough"><?= $habitacion['precio'] ?></span>
                                                    <?= $habitacion['bano_privado'] ? ', baño privado' : '' ?>
                                                </span>
                                            </li>
                                        <?php
                                        endforeach;
                                        ?>
                                    </ul>
                                </td>
                            </tr>
                        <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
            <?php
            endif;
            ?>
        </div>
    </div>
</body>

</html>