<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = $_POST['file'];
    $original_staff_id = $_POST['original_staff_id'];
    $original_start_date = $_POST['original_start_date'];
    $original_end_date = $_POST['original_end_date'];

    $employee_name = $_POST['employee_name'];
    $staff_id = $_POST['staff_id'];
    $leave_type = $_POST['leave_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];

    $sql = "UPDATE leave_applications SET employee_name=?, staff_id=?, leave_type=?, start_date=?, end_date=?, status=? 
            WHERE staff_id=? AND start_date=? AND end_date=? AND file_name=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssss", $employee_name, $staff_id, $leave_type, $start_date, $end_date, $status, $original_staff_id, $original_start_date, $original_end_date, $file);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php?file=" . urlencode($file));
    exit();
}

$file = $_GET['file_name'];
$staff_id = $_GET['staff_id'];
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];

$sql = "SELECT * FROM leave_applications WHERE staff_id=? AND start_date=? AND end_date=? AND file_name=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $staff_id, $start_date, $end_date, $file);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Leave</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Edit Leave for <?= htmlspecialchars($data['employee_name']) ?></h2>
    <form method="post">
        <input type="hidden" name="file" value="<?= htmlspecialchars($file) ?>">
        <input type="hidden" name="original_staff_id" value="<?= $staff_id ?>">
        <input type="hidden" name="original_start_date" value="<?= $start_date ?>">
        <input type="hidden" name="original_end_date" value="<?= $end_date ?>">

        <label>Name: <input type="text" name="employee_name" value="<?= $data['employee_name'] ?>"></label><br>
        <label>Staff ID: <input type="text" name="staff_id" value="<?= $data['staff_id'] ?>"></label><br>
        <label>Leave Type: <input type="text" name="leave_type" value="<?= $data['leave_type'] ?>"></label><br>
        <label>Start Date: <input type="date" name="start_date" value="<?= $data['start_date'] ?>"></label><br>
        <label>End Date: <input type="date" name="end_date" value="<?= $data['end_date'] ?>"></label><br>
        <label>Status: <input type="text" name="status" value="<?= $data['status'] ?>"></label><br>
        <button type="submit">Update</button>
    </form>
</body>
</html>
