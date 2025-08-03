<?php
include 'db.php';

// Get POST values
$original_staff_id = $_POST['original_staff_id'];
$original_start_date = $_POST['original_start_date'];
$original_end_date = $_POST['original_end_date'];

$employee_name = $_POST['employee_name'];
$staff_id = $_POST['staff_id'];
$leave_type = $_POST['leave_type'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$status = $_POST['status'];

// Update the record
$sql = "UPDATE leave_applications 
        SET employee_name=?, staff_id=?, leave_type=?, start_date=?, end_date=?, status=?
        WHERE staff_id=? AND start_date=? AND end_date=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssss", $employee_name, $staff_id, $leave_type, $start_date, $end_date, $status, $original_staff_id, $original_start_date, $original_end_date);

if ($stmt->execute()) {
    header("Location: index.php");
    exit;
} else {
    echo "Failed to update record.";
}
?>
