<?php

require_once './config.php';

$enlaces = [
    [
        'nombre'   => 'habitaciones.php',
        'texto'     => 'Habitaciones',
    ],
    [
        'nombre'   => 'registrarhabitaciones.php',
        'texto'     => 'Registrar',
    ],
    [
        'nombre'   => 'listarhabitaciones.php',
        'texto'     => 'Buscar',
    ],
];
?>
<header class="navbar <?= $esTemaOscuro  ? 'navbar--dark' : '' ?>">
    <div class="navbar__container-logo">
        <a href="#" class="navbar__logo-link">
            <img class="navbar__logo" src="./logo.png" alt="Logo">
        </a>
    </div>
    <nav class="navbar__menu">
        <ul class="navbar__list">
            <?php
            foreach ($enlaces as $enlace) :
            ?>
                <li class="navbar__list-item">
                    <a class="navbar__link <?= $enlace['nombre'] == $enlaceActivo ? "navbar__link--active" : "" ?>" href="<?= APP_URL . "/{$enlace['nombre']}" ?>">
                        <?= $enlace['texto'] ?>
                    </a>
                </li>
            <?php
            endforeach;
            ?>
        </ul>
    </nav>
</header>