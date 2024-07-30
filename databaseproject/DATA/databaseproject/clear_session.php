<?php
session_start();
include("db_conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $user_type = $_SESSION['user_type'];

    switch ($user_type) {
        case 'personal':
            $sql = "DELETE FROM personal_tbl WHERE p_id = '$user_id'";
            break;
        case 'hospital':
            $sql = "DELETE FROM hospital_tbl WHERE h_id = '$user_id'";
            break;
        case 'pharmacy':
            $sql = "DELETE FROM pharmacy_tbl WHERE ph_id = '$user_id'";
            break;
        default:
            exit();
    }

    $conn->query($sql);
    mysqli_close($conn);

    session_unset();
    session_destroy();
}
?>
