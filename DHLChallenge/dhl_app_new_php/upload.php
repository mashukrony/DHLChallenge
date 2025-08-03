<?php
require 'vendor/autoload.php';
require 'db.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

if (isset($_FILES['excelFile']) && $_FILES['excelFile']['error'] == 0) {
    $file = $_FILES['excelFile'];
    $fileName = basename($file['name']);

    // Check if the file already exists in the database
    $checkSql = "SELECT id FROM uploaded_files WHERE file_name = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("s", $fileName);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<p>File already exists!</p>";
        exit;
    }

    // Save file entry in uploaded_files
    $insertFile = $conn->prepare("INSERT INTO uploaded_files (file_name, uploaded_at) VALUES (?, NOW())");
    $insertFile->bind_param("s", $fileName);
    $insertFile->execute();

    // Load Excel
    $spreadsheet = IOFactory::load($file['tmp_name']);
    $worksheet = $spreadsheet->getActiveSheet();
    $rows = $worksheet->toArray();

    unset($rows[0]); // remove header

    $success = 0;
    $fail = 0;

    foreach ($rows as $row) {
        $employee_name = trim($row[0]);
        $staff_id = trim($row[1]);
        $leave_type = trim($row[2]);
        $start_date = date('Y-m-d', strtotime($row[3]));
        $end_date = date('Y-m-d', strtotime($row[4]));
        $status = trim($row[5]);

        if (!$employee_name || !$staff_id || !$leave_type || !$start_date || !$end_date || !$status) {
            $fail++;
            continue;
        }

        $checkSql = "SELECT * FROM leave_applications WHERE staff_id = ? AND start_date = ? AND end_date = ? AND file_name = ?";
        $stmt = $conn->prepare($checkSql);
        $stmt->bind_param("ssss", $staff_id, $start_date, $end_date, $fileName);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            $insertSql = "INSERT INTO leave_applications (employee_name, staff_id, leave_type, start_date, end_date, status, file_name) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertSql);
            $insertStmt->bind_param("sssssss", $employee_name, $staff_id, $leave_type, $start_date, $end_date, $status, $fileName);

            if ($insertStmt->execute()) {
                $success++;
            } else {
                $fail++;
            }
        } else {
            $fail++;
        }

        $stmt->close();
    }

    echo "<p>Upload complete. Success: $success, Failed: $fail</p>";
    echo "<p><a href='index.php'>Go Back</a></p>";
} else {
    echo "No file uploaded or an error occurred.";
}
?>
