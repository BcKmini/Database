
<?php
include ('db_conn.php');

if (isset($_POST['submit'])) {
    if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
        // 파일 이름 가져오기
        $fileName = $_FILES['file']['name'];

        // 파일 이름을 데이터베이스에 저장하는 SQL 쿼리
        $sql = "INSERT INTO test_file_tbl (file_name) VALUES (?)";

        // 준비된 문장을 사용하여 SQL 쿼리 실행
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $fileName);

        if ($stmt->execute()) {
            echo "File name '$fileName' has been successfully saved to the database.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // 준비된 문장과 데이터베이스 연결 닫기
        $stmt->close();
    } else {
        echo "No file uploaded or there was an upload error.";
    }
}

// 데이터베이스 연결 닫기
$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <title>File Upload</title>
</head>
<body>
    <form action=" " method="post" enctype="multipart/form-data">
        <label for="file">Choose a file:</label>
        <input type="file" name="file" id="file">
        <input type="submit" name="submit" value="Upload">
    </form>
</body>
</html>

