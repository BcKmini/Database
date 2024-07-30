<?php
include 'db_conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $p_id = isset($_POST['p_id']) ? $_POST['p_id'] : '';

    if ($p_id) {
        $sql = "UPDATE personal_tbl SET p_prescription = NULL WHERE p_id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("s", $p_id);
            if ($stmt->execute()) {
                echo "success";
            } else {
                echo "데이터베이스 업데이트 중 오류가 발생했습니다.";
            }
            $stmt->close();
        } else {
            echo "데이터베이스 준비 중 오류가 발생했습니다.";
        }
    } else {
        echo "유효한 환자 ID가 제공되지 않았습니다.";
    }
}
$conn->close();
?>
    