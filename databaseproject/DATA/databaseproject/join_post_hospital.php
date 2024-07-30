<?php
include("db_conn.php");

$h_distingush = $_POST['h_distingush'];
$h_name = $_POST['h_name'];
$h_sex = $_POST['h_sex'];
$h_id = $_POST['h_id'];
$h_pw = $_POST['h_pw'];

$h_idnumber_sets = $_POST['h_idnumber'];
$h_idnumber = implode("-", $h_idnumber_sets);

$h_mobile_sets = $_POST['h_mobile'];
$h_mobile = implode("-", $h_mobile_sets);

$h_major = $_POST['h_major'];

/*gpt 코드*/
$h_workingname = $_POST['h_workingname'];
$h_workingaddress = $_POST['h_workingaddress'];

// 파일 업로드 처리
$upload_dir = './hospital_certification/';
$file_tmp = $_FILES['hospital_certification']['tmp_name'];
$file_ext = pathinfo($_FILES['hospital_certification']['name'], PATHINFO_EXTENSION);

// 파일을 새로운 이름으로 저장 (예: h_name-h_num.확장자)
$new_file_name = $h_name . '-' . $h_id . '.' . $file_ext;
$file_path = $upload_dir . $new_file_name;

// 파일을 지정된 경로에 저장
if (move_uploaded_file($file_tmp, $file_path)) {
    // SQL 쿼리 작성
    $sql = "INSERT INTO hospital_tbl(
        h_distingush, h_name, h_id, h_pw, h_sex, h_idnumber, h_mobile, h_major, h_file
    ) VALUES (
        '$h_distingush', '$h_name', '$h_id', '$h_pw', '$h_sex', '$h_idnumber', '$h_mobile', '$h_major', '$file_path'
    )";

    // 쿼리 실행
    if ($conn->query($sql) === TRUE) {
        // 데이터가 성공적으로 저장된 경우 리디렉션
        header("Location: agree.html");
        exit();
    } else {
        echo "Error: " .mysqli_error($conn);
    }
} else {
    echo "File upload failed.";
}

// 연결 종료
mysqli_close($conn);