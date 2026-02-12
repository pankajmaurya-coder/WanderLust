<?php
require_once __DIR__ . "/../../config/function.php";
$obj = new Query();
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header("Location: list.php?error=invalid_id");
    exit;
}

try {
    $obj->deletedata('hotel', $id);
    header("Location: list.php?success=deleted");
    exit;
} catch (Exception $e) {
    header("Location: list.php?error=delete_failed");
    exit;
}
