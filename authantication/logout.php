<?php
session_start();
require_once __DIR__ . "/../config/function.php";

$obj = new Query();

if (!empty($_COOKIE['remember_token'])) {

    $sql = "DELETE FROM cookies WHERE token = ?";
    $obj->runQuery($sql, [$_COOKIE['remember_token']]);

    setcookie("remember_token", "", time() - 3600, "/");
}

session_destroy();

header("Location: login.php");
exit;

?>