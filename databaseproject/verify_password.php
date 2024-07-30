<?php
session_start();
include 'db_conn.php';

if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("로그인 후 이용해 주세요."); window.location.href = "login.php";</script>';
    exit();
}

$user_id = $_SESSION['user_id'];
$action = $_POST['action'] ?? '';
$password = $_POST['password'] ?? '';

// 병원 및 약국 테이블에서 사용자 찾기
$tables = [
    'hospital_tbl' => 'h_pw',
    'pharmacy_tbl' => 'ph_pw'
];

$user_type = '';
$user_found = false;

foreach ($tables as $table => $pw_column) {
    $id_column = ($table === 'hospital_tbl') ? 'h_id' : 'ph_id';
    $sql = "SELECT $pw_column FROM $table WHERE $id_column = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $stmt->bind_result($hashed_password);
        if ($stmt->fetch()) {
            $user_type = ($table === 'hospital_tbl') ? 'hospital' : 'pharmacy';
            if ($action === 'check') {
                echo $user_type;
                $user_found = true;
                break;
            } elseif ($action === 'validate' && $password === $hashed_password) {
                echo 'success';
                $user_found = true;
                break;
            } else {
                echo '비밀번호가 일치하지 않습니다.';
                $user_found = true;
                break;
            }
        }
        $stmt->close();
    }
}

if (!$user_found) {
    echo '사용자 권한이 없습니다.';
}

$conn->close();
?>
