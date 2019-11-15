<?php
require 'inc/functions.php';
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$page = 'Delete Entry';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
}
if (delete_entry($id)) {
    echo 'Successfully deleted entry.';
    header('refresh: 1; url = index.php');
} else {
    echo 'Unable to delete entry. Try again.';
    header('refresh: 1; url = detail.php?id="' . $id . '"');
}
include 'inc/header.php';
include 'inc/footer.php';