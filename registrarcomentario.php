<?php

$llaves = ['nombrecompleto', 'valuacion', 'texto', 'codigocaptcha'];
$campos = [];
$errors = [];

foreach ($llaves as $llave) :

    if (isset($_POST[$llave]) && !empty($_POST[$llave])) :
        $campos[$llave] = $_POST[$llave];
    else :
        $errors[] = "Falta el campo: $llave";
    endif;

endforeach;

if (count($errors) == 0) :

    require_once 'securimage.php';

    $image = new Securimage();

    if ($image->check($campos['codigocaptcha'])) :

        include('database-init.php');

        if ($db->storeComment($campos['nombrecompleto'], $campos['valuacion'], $campos['texto'])) :
            echo json_encode([
                'success' => true,
                'mensaje' => 'Se registro el comentario exitosamente',
            ]);
        else :
            echo json_encode([
                'success' => false,
                'mensaje' => 'Registro de datos',
                'errors' => [
                    'No se pudo realizar el registro el comentario',
                ],
            ]);
        endif;
    else :
        echo json_encode([
            'success' => false,
            'mensaje' => 'Error de seguridad',
            'errors' => [
                'El codigocaptcha no coincide',
            ],
        ]);
    endif;
else :

    echo json_encode([
        'success' => false,
        'mensaje' => 'No se enviaron los campos necesarios',
        'errors' => $errors,
    ]);

endif;
