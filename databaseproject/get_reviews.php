<?php
include 'db_conn.php';

// GET 데이터 가져오기
$place_name = $_GET['place_name'];

// SQL 쿼리 작성
$sql = "SELECT * FROM reviews WHERE place_name='$place_name'";
$result = $conn->query($sql);

$reviews = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }
} else {
    echo "0 results";
}

echo json_encode($reviews);

// 연결 종료
$conn->close();
?>
