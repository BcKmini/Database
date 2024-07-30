<?php
$servername = "localhost";
$username = "IBKCenter";
$password = "0305";
$dbname = "loginibk";


// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 오류 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

// Prepared Statements를 사용하여 SQL 인젝션 방지
$stmt = $conn->prepare("INSERT INTO reviews (place_name, title, author, date, content, rating) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssi", $place_name, $title, $author, $date, $content, $rating);

// 쿼리 실행 및 결과 처리
if ($stmt->execute() === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

// 자원 해제
$stmt->close();
$conn->close();
?>
