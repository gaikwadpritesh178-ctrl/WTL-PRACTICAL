<?php

include "db.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

$title = trim($_POST['title'] ?? '');
$subject_name = trim($_POST['subject_name'] ?? '');
$semester = (int) ($_POST['semester'] ?? 0);
$material_type = trim($_POST['material_type'] ?? '');
$uploaded_by = trim($_POST['uploaded_by'] ?? '');

if ($title === '' || $subject_name === '' || $semester < 1 || $semester > 8 || $material_type === '' || $uploaded_by === '') {
    die("Please complete all required fields.");
}

if (!isset($_FILES['material_file']) || $_FILES['material_file']['error'] !== UPLOAD_ERR_OK) {
    die("Please select a valid file.");
}

$file_name = $_FILES['material_file']['name'];
$file_tmp = $_FILES['material_file']['tmp_name'];

$allowed_extensions = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx', 'zip'];
$extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

if (!in_array($extension, $allowed_extensions, true)) {
    die("Unsupported file type.");
}

$upload_folder = "uploads/";

if (!is_dir($upload_folder) && !mkdir($upload_folder, 0777, true)) {
    die("Unable to create the uploads folder.");
}

$new_file_name = bin2hex(random_bytes(8)) . "." . $extension;

$file_path = $upload_folder . $new_file_name;

if (move_uploaded_file($file_tmp, $file_path)) {

        $stmt = mysqli_prepare($conn, "INSERT INTO materials (title, subject_name, semester, material_type, uploaded_by, file_path) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssisss", $title, $subject_name, $semester, $material_type, $uploaded_by, $file_path);

        if (mysqli_stmt_execute($stmt)) {

        $material_id = mysqli_insert_id($conn);
        header("Location: index.php?uploaded=1&id=" . $material_id);
        exit;

    } else {

        echo "Database Error: " . htmlspecialchars(mysqli_stmt_error($stmt), ENT_QUOTES, 'UTF-8');
    }

} else {

    echo "File upload failed.";
}

?>
