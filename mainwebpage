<?php
include "db.php";

$result = mysqli_query($conn, "SELECT * FROM materials ORDER BY id DESC");

if (!$result) {
    die("Unable to load materials: " . mysqli_error($conn));
}

$uploaded_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$upload_success = isset($_GET['uploaded']) && $_GET['uploaded'] === '1' && $uploaded_id;
$uploaded_material = null;

if ($upload_success) {
    $uploaded_material_result = mysqli_query($conn, "SELECT title, subject_name, semester, material_type, uploaded_by FROM materials WHERE id = " . $uploaded_id);
    $uploaded_material = $uploaded_material_result ? mysqli_fetch_assoc($uploaded_material_result) : null;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Study Material Management</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<main class="page-shell">

<header class="page-header">
    <div>
        <p class="eyebrow">Campus library / 2026</p>
        <h1>Study Material <span>Library</span></h1>
        <p class="intro">Keep your course resources organised, searchable, and ready for the next study session.</p>
    </div>
    <div class="header-mark" aria-hidden="true">SM</div>
</header>

<section class="upload-section">
    <div class="section-heading">
        <div>
            <p class="section-kicker">Add to your collection</p>
            <h2>Upload material</h2>
        </div>
        <span class="step-label">01 / 02</span>
    </div>

<form action="save_material.php" method="POST" enctype="multipart/form-data">

    <div class="form-grid">
        <div class="field field-wide">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" placeholder="e.g. Operating Systems — Unit 3" required>
        </div>

        <div class="field">
            <label for="subject_name">Subject</label>
            <input type="text" id="subject_name" name="subject_name" placeholder="e.g. Computer Science" required>
        </div>

        <div class="field">
            <label for="semester">Semester</label>
            <select id="semester" name="semester" required>
                <option value="">Select semester</option>
                <option value="1">Semester 1</option>
                <option value="2">Semester 2</option>
                <option value="3">Semester 3</option>
                <option value="4">Semester 4</option>
                <option value="5">Semester 5</option>
                <option value="6">Semester 6</option>
                <option value="7">Semester 7</option>
                <option value="8">Semester 8</option>
            </select>
        </div>

        <div class="field">
            <label for="material_type">Material type</label>
            <select id="material_type" name="material_type" required>
                <option value="">Select type</option>
                <option value="Notes">Notes</option>
                <option value="Question Paper">Question Paper</option>
                <option value="Assignment">Assignment</option>
                <option value="PPT">PPT</option>
                <option value="Book">Book</option>
            </select>
        </div>

        <div class="field">
            <label for="uploaded_by">Uploaded by</label>
            <input type="text" id="uploaded_by" name="uploaded_by" placeholder="Your name" required>
        </div>

        <div class="field field-wide file-field">
            <label for="material_file">Material file</label>
            <input type="file" id="material_file" name="material_file" accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip" required>
            <small>PDF, Word, PowerPoint, Excel, or ZIP · 10 MB recommended maximum</small>
        </div>
    </div>

    <label class="confirm-field">
        <input type="checkbox" name="confirm_information" value="1" required>
        I confirm that the uploaded material information is correct.
    </label>

    <button type="submit"><span>Upload material</span><strong>→</strong></button>

</form>
</section>

<section class="library-section">
    <div class="section-heading library-heading">
        <div>
            <p class="section-kicker">Your shared resources</p>
            <h2>Uploaded materials</h2>
        </div>
        <span class="step-label">02 / 02</span>
    </div>

<?php if ($uploaded_material) { ?>
    <p id="materialsStatus">
        <span class="status-dot"></span> Material uploaded successfully:
        <strong><?php echo htmlspecialchars($uploaded_material['title']); ?></strong>
        for <?php echo htmlspecialchars($uploaded_material['subject_name']); ?>,
        Semester <?php echo htmlspecialchars($uploaded_material['semester']); ?>,
        <?php echo htmlspecialchars($uploaded_material['material_type']); ?>,
        uploaded by <?php echo htmlspecialchars($uploaded_material['uploaded_by']); ?>.
    </p>
<?php } else { ?>
    <p id="materialsStatus">Upload a material using the form above. Your saved information will appear here.</p>
<?php } ?>

<div class="table-wrap">
<table>

    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Subject</th>
        <th>Semester</th>
        <th>Type</th>
        <th>Uploaded By</th>
        <th>File</th>
        <th>Actions</th>
    </tr>

<?php if (mysqli_num_rows($result) === 0) { ?>
    <tr>
        <td colspan="8">No materials uploaded yet. Complete the form above to add your first material.</td>
    </tr>
<?php } else { ?>
<?php while ($row = mysqli_fetch_assoc($result)) { ?>

    <tr>

        <td><?php echo $row['id']; ?></td>

        <td><?php echo htmlspecialchars($row['title']); ?></td>

        <td><?php echo htmlspecialchars($row['subject_name']); ?></td>

        <td><?php echo htmlspecialchars($row['semester']); ?></td>

        <td><?php echo htmlspecialchars($row['material_type']); ?></td>

        <td><?php echo htmlspecialchars($row['uploaded_by']); ?></td>

        <td>
            <a href="<?php echo $row['file_path']; ?>" target="_blank">
                View File
            </a>
        </td>

        <td>
            <a href="edit.php?id=<?php echo $row['id']; ?>">
                Edit
            </a>

            |

            <a href="delete_material.php?id=<?php echo $row['id']; ?>"
               onclick="return confirm('Are you sure you want to delete this material?');">
                Delete
            </a>
        </td>

    </tr>

<?php } ?>
<?php } ?>

</table>
</div>

</section>
</main>

</body>
</html>
