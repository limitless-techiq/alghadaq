<?php
require_once 'pdoconfig.php';

try {
$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
} catch (PDOException $pe) {
die ("");
}