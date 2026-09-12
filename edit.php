<?php

include "db.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
       header("Location: index.php");
       exit;
}

$stmt = mysqli_prepare($conn, "SELECT * FROM materials WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$row = mysqli_fetch_assoc($result);

if (!$row) {
       header("Location: index.php");
       exit;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Material</title>
</head>

<body>

<h1>Edit Material</h1>

<form action="update_material.php" method="POST">

    <input type="hidden" name="id"
           value="<?php echo $row['id']; ?>">

       <label for="title">Title:</label>
    <input type="text"
           id="title"
           name="title"
           value="<?php echo htmlspecialchars($row['title']); ?>"
           required>

    <br><br>

       <label for="subject_name">Subject:</label>
    <input type="text"
           id="subject_name"
           name="subject_name"
           value="<?php echo htmlspecialchars($row['subject_name']); ?>"
           required>

    <br><br>

    <label>Semester:</label>

       <select id="semester"
           name="semester"
           required>
              <?php for ($semester = 1; $semester <= 8; $semester++) { ?>
                     <option value="<?php echo $semester; ?>" <?php echo (int) $row['semester'] === $semester ? 'selected' : ''; ?>>Semester <?php echo $semester; ?></option>
              <?php } ?>
       </select>

       <br><br>

    <label>Material Type:</label>

       <select id="material_type" name="material_type" required>
              <?php foreach (['Notes', 'Question Paper', 'Assignment', 'PPT', 'Book'] as $type) { ?>
                     <option value="<?php echo htmlspecialchars($type, ENT_QUOTES, 'UTF-8'); ?>" <?php echo $row['material_type'] === $type ? 'selected' : ''; ?>><?php echo htmlspecialchars($type, ENT_QUOTES, 'UTF-8'); ?></option>
              <?php } ?>
       </select>

    <br><br>

       <label for="uploaded_by">Uploaded By:</label>

    <input type="text"
           id="uploaded_by"
           name="uploaded_by"
           value="<?php echo htmlspecialchars($row['uploaded_by']); ?>"
           required>

    <br><br>

    <button type="submit">
        Update Material
    </button>

</form>

<br>

<a href="index.php">Back</a>

</body>

</html>
