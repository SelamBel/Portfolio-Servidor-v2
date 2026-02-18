<?php

// Cambiar a "db" en casa, "localhost" en clase
define('DB_HOST', 'db');
define('DB_NAME', 'portfolio');
define('DB_PORT', 3306);
define('DB_USER', 'root');
// Cambiar a "root" en casa, vacio en clase
define('DB_PASS', 'root');
define('DB_CHARSET', 'utf8mb4');

function conectarBD() {
    try {
        $dsn = "mysql:host=" . DB_HOST .
               ";port=" . DB_PORT .
               ";dbname=" . DB_NAME .
               ";charset=" . DB_CHARSET;

        $conexion = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        
        return $conexion;

    } catch (PDOException $e) {
        error_log('Error de conexión BD: ' . $e->getMessage());
        return null;
    }
}