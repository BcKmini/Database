<?php
include 'db_conn.php';

// 검색 키워드 가져오기
$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($conn, $_GET['keyword']) : '';

// SQL 쿼리 작성
$sql = "SELECT * FROM pharmacy_contents WHERE name LIKE '%$keyword%'";
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    // 결과를 배열에 저장
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    echo json_encode($data);
} else {
    echo json_encode([]);
}

// 연결 종료
$conn->close();
?>
