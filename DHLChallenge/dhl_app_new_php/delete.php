<?php
include 'db.php';

if ($_POST) {
    $staff_id = $_POST['staff_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $file_name = $_POST['file_name'];

    $stmt = $conn->prepare("DELETE FROM leave_applications WHERE staff_id=? AND start_date=? AND end_date=? AND file_name=?");
    $stmt->bind_param("ssss", $staff_id, $start_date, $end_date, $file_name);
    $stmt->execute();
    $stmt->close();
}

header("Location: index.php?file=" . urlencode($file_name));
exit();
?>
