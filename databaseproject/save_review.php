<?php
include 'db_conn.php';

// POST 데이터 수집 및 유효성 검사
$place_name = isset($_POST['place_name']) ? trim($_POST['place_name']) : '';
$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$author = isset($_POST['author']) ? trim($_POST['author']) : '';
$date = isset($_POST['date']) ? trim($_POST['date']) : '';
$content = isset($_POST['content']) ? trim($_POST['content']) : '';
$rating = isset($_POST['rating']) ? intval($_POST['rating']) : 0;

// 유효성 검사
$errors = [];
if (empty($place_name)) $errors[] = "Place name is required.";
if (empty($title)) $errors[] = "Title is required.";
if (empty($author)) $errors[] = "Author is required.";
if (empty($date)) $errors[] = "Date is required.";
if (empty($content)) $errors[] = "Content is required.";
if ($rating < 1 || $rating > 5) $errors[] = "Rating must be between 1 and 5.";

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
    $conn->close();
    exit();
}

// 현재 최대 order 값 가져오기
$sql = "SELECT MAX(`order`) AS max_order FROM reviews WHERE place_name=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $place_name);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$max_order = isset($row['max_order']) ? $row['max_order'] : 0;
$new_order = $max_order + 1;

// Prepared Statements를 사용하여 SQL 인젝션 방지
$stmt = $conn->prepare("INSERT INTO reviews (`order`, place_name, title, author, date, content, rating) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("isssssi", $new_order, $place_name, $title, $author, $date, $content, $rating);

// 쿼리 실행 및 결과 처리
if ($stmt->execute() === TRUE) {
    echo "리뷰 제출 완료";
} else {
    echo "Error: " . $stmt->error;
}

// 자원 해제
$stmt->close();
$conn->close();
?>