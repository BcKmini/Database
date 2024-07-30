
<?php
session_start();

$error = "";
$phone_number = "";

function fetchPatientData($name, $idnumber) {
    include 'db_conn.php';
    $sql = "SELECT p_mobile FROM personal_tbl WHERE p_name = ? AND p_idnumber = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ss", $name, $idnumber);
        $stmt->execute();
        $stmt->bind_result($phone_number);
        $stmt->fetch();
        $stmt->close();
    } else {
        $GLOBALS['error'] = "Failed to prepare the SQL statement.";
    }
    $conn->close();
    return $phone_number;
}

function uploadFilesAndSaveToDB($name, $idnumber) {
    include 'db_conn.php';
    $targetDir = "prescription/";
    $fileNames = array_filter($_FILES['h_file']['name']);
    if(!empty($fileNames)){
        foreach($_FILES['h_file']['name'] as $key=>$val){
            $fileName = basename($_FILES['h_file']['name'][$key]);
            $targetFilePath = $targetDir . $fileName;

            if(move_uploaded_file($_FILES['h_file']['tmp_name'][$key], $targetFilePath)){
                $sql = "UPDATE personal_tbl SET p_prescription = ? WHERE p_name = ? AND p_idnumber = ?";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("sss", $fileName, $name, $idnumber);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    return "Failed to prepare the SQL statement for file update.";
                }
            } else {
                return "Failed to upload file.";
            }
        }
    }
    $conn->close();
    return "";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['h_file'])) {
        $name = $_POST['p_name'];
        $idnumber = $_POST['p_idnumber'];
        $error = uploadFilesAndSaveToDB($name, $idnumber);
        $phone_number = fetchPatientData($name, $idnumber);
        if ($error == "") {
            header("Location: check_information.php"); // Redirect to the previous page
            exit();
        }
    } else {
        $name = $_POST['p_name'];
        $idnumber1 = $_POST['p_idnumber1'];
        $idnumber2 = $_POST['p_idnumber2'];
        $idnumber = $idnumber1 . '-' . $idnumber2;
        $phone_number = fetchPatientData($name, $idnumber);
    }
} else {
    $error = "Invalid request method.";
}
?>

<!DOCTYPE HTML>
<HTML>
    <HEAD>
        <meta charset="utf-8">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/testcheck.css?after" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Do+Hyeon&display=swap" rel="stylesheet">
        
        <title>IBK CENTER</title>
        <style>
            .menu-bar_box1 a {
                text-decoration: none;
                color: black; /* 기본 링크 색상 */
                transition: color 0.3s ease-in-out; /* 트랜지션 추가 */
            }

            .menu-bar_box1 a:hover {
                color: #4374D9; /* 마우스 오버 시 링크 색상 */
            }
        </style>
    </HEAD>

    <BODY>
        <header>
        <a href="login.php"><img src="jpg/real logo.png" class="center-image"></a>
        
        <h2 class="con-min-width">
            <div class="con">
                <nav class="menu-bar_box1">
                    <ul>
                    <li><a href="find_hospital.html" class="block">병원찾기</a></li>
                            <li><a href="find_pharmacy.php" class="block">약국찾기</a></li>
                            <li><a href="check_information.php" class="block">정보조회</a></li>
                            <li><a href="review.html" class="block">방문후기</a></li>
                            <li><a href="access_rv.php" class="block">개인정보수정</a></li>
                    </ul>
                </nav>  
            </div>
        </h2>
        <hr class="hr_style">
        </header>
        <div class="join_font">정보 업로드</div>
        <div class="layout">
            <?php if (!empty($error)): ?>
                <p class="error_message"><?= htmlspecialchars($error) ?></p>
            <?php else: ?>
                <form id="uploadForm" method="post" action="upload.php" enctype="multipart/form-data">
                    <div class="input_font4">환자 이름 &nbsp; &nbsp;| &nbsp; &nbsp;  <?= htmlspecialchars($name) ?></div><br><br>
                    <input type="hidden" name="p_name" value="<?= htmlspecialchars($name) ?>">
                    <input type="hidden" name="p_idnumber" value="<?= htmlspecialchars($idnumber) ?>">
                    <div class="input_font5">환자 주민등록번호 &nbsp; &nbsp;| &nbsp; &nbsp; <?= htmlspecialchars($idnumber) ?></div><br><br>
                    <div class="input_font5">환자 전화번호 &nbsp; &nbsp;| &nbsp; &nbsp; <?= htmlspecialchars($phone_number) ?></div>
                    <div class="upload">
                        <label class="label" for="input">
                            <div class="upload_file" id="drop_zone">
                                <img src="jpg/upload.png" class="upload_img">
                                <div class="upload_font" id="upload_message">
                                    <h3>Upload your files or click here!</h3>
                                </div>
                            </div>
                            <div class="file_list" id="file_list"></div>
                        </label>
                        
                        <input type="file" class="file_upload" id="input" accept=".pdf,image/*" required multiple hidden name="h_file[]">
                        <div class="btn_img"><img src="jpg/save_btn.jpg" width="200" id="saveBtn" class = "cursord"></div>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </BODY>
</HTML>

<script>
const dropZone = document.getElementById('drop_zone');
const fileInput = document.getElementById('input');
const fileList = document.getElementById('file_list');
const uploadMessage = document.getElementById('upload_message');
const saveBtn = document.getElementById('saveBtn');
const uploadForm = document.getElementById('uploadForm');

dropZone.addEventListener('dragover', (event) => {
    event.preventDefault();
    dropZone.style.borderColor = '#000';
});

dropZone.addEventListener('dragleave', () => {
    dropZone.style.borderColor = '#d4d4d4';
});

dropZone.addEventListener('drop', (event) => {
    event.preventDefault();
    dropZone.style.borderColor = '#d4d4d4';
    const files = event.dataTransfer.files;
    handleFiles(files);
    fileInput.files = files; // Update file input to include dropped files
});

fileInput.addEventListener('change', () => {
    const files = fileInput.files;
    handleFiles(files);
});

function handleFiles(files) {
    fileList.style.display = 'none'; // Hide the file list
    uploadMessage.innerHTML = '';
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        const listItem = document.createElement('div');
        listItem.textContent = `File: ${file.name}`;
        // No need to append the list item to fileList

        // Display the file name in the upload message area
        if (i === 0) {
            uploadMessage.innerHTML = `<h3>${file.name}</h3>`;
        }
    }
}

saveBtn.addEventListener('click', () => {
    uploadForm.submit();
});
</script>
