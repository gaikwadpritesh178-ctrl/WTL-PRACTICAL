<?php

include "db.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    header("Location: index.php");
    exit;
}

// First get file path
$stmt = mysqli_prepare($conn, "SELECT file_path FROM materials WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$row = mysqli_fetch_assoc($result);

if ($row) {

    // Delete database record
    $delete_stmt = mysqli_prepare($conn, "DELETE FROM materials WHERE id = ?");
    mysqli_stmt_bind_param($delete_stmt, "i", $id);
    mysqli_stmt_execute($delete_stmt);

    // Delete physical file
    if (file_exists($row['file_path'])) {
        unlink($row['file_path']);
    }
}

header("Location: index.php");

?>
