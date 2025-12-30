
<?php

if (!defined('HOST')) define('HOST', 'localhost');
if (!defined('USER')) define('USER', 'root');
if (!defined('PASS')) define('PASS', '');
if (!defined('DB')) define('DB', 'pfc');

$connection = new mysqli(HOST, USER, PASS, DB);
if ($connection->connect_errno) {
    echo "Problème de connexion : " . $connection->connect_error;
    exit(0);
}
?>