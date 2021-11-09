<?php

include("Database.php");

require_once './config.php';

$db = new Database(MYSQL['HOST'], MYSQL['USER'], MYSQL['PASSWORD'], MYSQL['DATABASE']);
