<?php

$host = "localhost";
$db_name = "dbmeeting";
$username = "bif2webscriptinguser";
$password = "bif2021";

try {
    $db = new PDO("mysql:host={$host};dbname={$db_name};charset=UTF8", $username, $password);
} catch (PDOException $hata) {
    echo "Connection error #10001<br /> " . $hata->getMessage() . "<br />";
    die();
}
?>
