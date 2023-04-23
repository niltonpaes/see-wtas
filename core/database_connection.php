<?php

// ******************** MYSQL CONFIGURATION ********************
// --- PC 
// $dsn = "mysql:host=localhost:3306;dbname=seewtas";
// $username = "root";
// $password = "";
// --- MAC
$dsn = "mysql:host=localhost:8889;dbname=seewtas";
$username = "root";
$password = "root";
// --- Hostinger
// $dsn = "mysql:host=127.0.0.1:3306;dbname=u806017736_swtas_ai";
// $username = "u806017736_swtas_ai";
// $password = "slaughter#SQL23";


$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
$pdo = new PDO($dsn, $username, $password, $options);
