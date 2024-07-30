<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    echo "<script>alert('로그인 후 이용해주세요.'); window.location.href = 'login.php';</script>";
    exit();
}

$user_type = $_SESSION['user_type'];


switch ($user_type) {
    case 'personal_tbl':
        header("Location: rvpersonal.php");
        break;
    case 'hospital_tbl':
        header("Location: rvhospital.php");
        break;
    case 'pharmacy_tbl':
        header("Location: rvpharmacy.php");
        break;
    default:
        echo "<script>alert('알 수 없는 사용자 유형입니다.'); window.location.href = 'login.php';</script>";
        exit();
}
?>
