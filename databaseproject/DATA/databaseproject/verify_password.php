<?php
session_start();
include 'db_conn.php'; // 데이터베이스 연결 설정 파일 포함

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];

    if (isset($_SESSION['user_info']) && $_SESSION['user_info']['type'] === 'hospital_tbl') {
        $username = $_SESSION['user_info'][$_SESSION['user_info']['id_column']];

        // 병원 회원의 비밀번호 확인
        $query = "SELECT * FROM hospital_tbl WHERE h_id = '$username' AND h_pw = '$password'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo 'success';
        } else {
            echo 'failure';
        }
    } else {
        echo 'failure';
    }
}
?>
