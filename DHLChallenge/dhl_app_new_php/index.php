<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Employee Leave Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="upload-container">
    <div class="header-container">
    <h1>Employee Leave Management System</h1>
    </div>

    <br>
    <br>

    <!-- Upload Form -->
    <h2>Upload Excel File</h2>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <input type="file" name="excelFile" accept=".xlsx" required class="file-input">
        <button type="submit" class="upload-btn">Upload</button>
    </form>

    <!-- Uploaded Files List -->
    <br>
    <br>
    <h2>Uploaded Files</h2>
    <ul class="file-list">
        <?php
        $result = $conn->query("SELECT * FROM uploaded_files ORDER BY uploaded_at DESC");
        while ($row = $result->fetch_assoc()):
        ?>
            <li>
                <a href="index.php?file=<?= urlencode($row['file_name']) ?>">
                    <?= htmlspecialchars($row['file_name']) ?>
                </a>
            </li>
        <?php endwhile; ?>
    </ul>
</div>


    <?php if (isset($_GET['file']) && !empty($_GET['file'])): ?>
        <h2>Leave Applications from: <?= htmlspecialchars($_GET['file']) ?></h2>
        <table border="1">
            <tr>
                <th>No.</th><th>Name</th><th>Staff ID</th><th>Type</th><th>Start</th><th>End</th><th>Status</th><th>Action</th>
            </tr>
            <?php
            $fileName = $_GET['file'];
            $stmt = $conn->prepare("SELECT * FROM leave_applications WHERE file_name = ?");
            $stmt->bind_param("s", $fileName);
            $stmt->execute();
            $result = $stmt->get_result();
            $count = 1;
            while ($row = $result->fetch_assoc()):
            ?>
            <tr>
                <td><?= $count++ ?></td>
                <td><?= htmlspecialchars($row['employee_name']) ?></td>
                <td><?= htmlspecialchars($row['staff_id']) ?></td>
                <td><?= htmlspecialchars($row['leave_type']) ?></td>
                <td><?= htmlspecialchars($row['start_date']) ?></td>
                <td><?= htmlspecialchars($row['end_date']) ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>
                <td>
                    <a href="edit.php?staff_id=<?= $row['staff_id'] ?>&file=<?= urlencode($row['file_name']) ?>" class="edit-btn">Edit</a>
                    <form method="post" action="delete.php" style="display:inline;">
                        <input type="hidden" name="staff_id" value="<?= $row['staff_id'] ?>">
                        <input type="hidden" name="start_date" value="<?= $row['start_date'] ?>">
                        <input type="hidden" name="end_date" value="<?= $row['end_date'] ?>">
                        <input type="hidden" name="file_name" value="<?= $row['file_name'] ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p>Please select a file from Uploaded Files.</p>
    <?php endif; ?>
</body>
</html>
