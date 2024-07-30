<?php
include 'db_conn.php'; // 데이터베이스 연결 파일을 포함합니다.

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
    $name = $_POST['name'];

    // SQL 쿼리를 생성합니다.
    $sql = "SELECT address FROM pharmacy_data WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($address);
    $stmt->fetch();

    // 결과를 텍스트 형식으로 반환합니다.
    if ($address) {
        echo $address;
    } else {
        echo 'No address found';
    }

    // 연결을 종료합니다.
    $stmt->close();
    $conn->close();
}
?>
