<?php
include 'db.php';

$sql = "SELECT * FROM uploaded_files ORDER BY uploaded_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Uploaded Files</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Uploaded Excel Files</h2>
    <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li>
                <a href="index.php?file_id=<?= $row['id'] ?>">
                    <?= htmlspecialchars($row['file_name']) ?>
                </a> (Uploaded at: <?= $row['uploaded_at'] ?>)
            </li>
        <?php endwhile; ?>
    </ul>

    <a href="upload.php">Upload another file</a>
</body>
</html>
