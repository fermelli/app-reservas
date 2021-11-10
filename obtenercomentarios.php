<?php

include('database-init.php');

echo json_encode([
    'success' => true,
    'mensaje' => 'Comentarios recuperados',
    'data' => $db->getComments(),
]);
