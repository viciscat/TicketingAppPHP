<?php

use Util\Database;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Error: missing ID";
    exit;
}
$contractID = $_GET['id'];
$file = Database::get()->execute("SELECT file FROM contracts WHERE id = ?", [$contractID])->fetch()['file'];
if (file_exists($file)) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    readfile($file);
}