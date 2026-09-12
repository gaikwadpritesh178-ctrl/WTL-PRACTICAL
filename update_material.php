<?php

include "db.php";

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

$title = trim($_POST['title'] ?? '');
$subject_name = trim($_POST['subject_name'] ?? '');
$semester = (int) ($_POST['semester'] ?? 0);
$material_type = trim($_POST['material_type'] ?? '');
$uploaded_by = trim($_POST['uploaded_by'] ?? '');

if (!$id || $id < 1 || $title === '' || $subject_name === '' || $semester < 1 || $semester > 8 || $material_type === '' || $uploaded_by === '') {
    die("Please provide valid material information.");
}

$stmt = mysqli_prepare($conn, "UPDATE materials SET title = ?, subject_name = ?, semester = ?, material_type = ?, uploaded_by = ? WHERE id = ?");
mysqli_stmt_bind_param($stmt, "ssissi", $title, $subject_name, $semester, $material_type, $uploaded_by, $id);

if (mysqli_stmt_execute($stmt)) {

    echo "<script>
            alert('Material updated successfully!');
            window.location='index.php';
          </script>";

} else {

    echo "Update failed: " . htmlspecialchars(mysqli_stmt_error($stmt), ENT_QUOTES, 'UTF-8');
}

?>
