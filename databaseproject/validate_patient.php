<?php
session_start();
include 'db_conn.php';

if (!isset($_SESSION['user_id'])) {
    echo '로그인 후 이용해 주세요.';
    exit();
}
$name = $_POST['p_name'];
$idnumber = $_POST['p_idnumber'];

$sql = "SELECT COUNT(*) FROM personal_tbl WHERE p_name = ? AND p_idnumber = ?";
$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param("ss", $name, $idnumber);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}
$conn->close();
?>
