<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("db_conn.php");

    $ph_name = $_POST['ph_name'];
    $ph_sex = $_POST['ph_sex'];
    $ph_id = $_POST['ph_id'];
    $ph_pw = $_POST['ph_pw'];

    $ph_idnumber_sets = $_POST['ph_idnumber'];
    $ph_idnumber = implode("-", $ph_idnumber_sets);

    $ph_mobile_sets = $_POST['ph_mobile'];
    $ph_mobile = implode("-", $ph_mobile_sets);

    $ph_workingname = $_POST['ph_workingname'];
    $ph_workingaddress = $_POST['phospital_address'];


    $required_fields = [
        '이름을 입력해주세요' => $ph_name,
        '성별을 선택해주세요' => $ph_sex,
        '전화번호를 입력해주세요' => $ph_mobile,
        '아이디를 입력해주세요' => $ph_id,
        '비밀번호를 입력해주세요' => $ph_pw,
        '주민등록번호를 입력해주세요' => $ph_idnumber,
    ];

    foreach ($required_fields as $field => $value) {
        if (empty($value)) {
            echo "<script>alert('" . $field . "'); window.history.back();</script>";
            exit();
        }
    }

    // Check if the upload directory exists and is writable
    $upload_dir = 'pharmacy_certification/';
    if (!is_dir($upload_dir) || !is_writable($upload_dir)) {
        echo "<script>alert('업로드 디렉토리가 존재하지 않거나 쓰기 권한이 없습니다.'); window.history.back();</script>";
        exit();
    }

    // Check if file was uploaded
    if (isset($_FILES['h_file']) && $_FILES['h_file']['error'] == 0) {
        $h_file = $_FILES['h_file']['name'];
        $upload_file = $upload_dir . basename($h_file);

        // Debugging information
        echo "<script>console.log('파일명: $h_file');</script>";

        if (move_uploaded_file($_FILES['h_file']['tmp_name'], $upload_file)) {
            // File successfully uploaded
            $_SESSION['uploaded_file'] = $upload_file;
            echo "<script>console.log('파일 업로드 성공: $upload_file');</script>";
        } else {
            echo "<script>alert('파일 업로드에 실패했습니다.'); window.history.back();</script>";
            exit();
        }
    } else {
        if (!isset($_SESSION['uploaded_file'])) {
            $upload_errors = [
                UPLOAD_ERR_INI_SIZE => '업로드한 파일이 너무 큽니다.',
                UPLOAD_ERR_FORM_SIZE => '업로드한 파일이 양식을 초과했습니다.',
                UPLOAD_ERR_PARTIAL => '파일이 부분적으로만 업로드되었습니다.',
                UPLOAD_ERR_NO_FILE => '파일이 업로드되지 않았습니다.',
                UPLOAD_ERR_NO_TMP_DIR => '임시 폴더가 없습니다.',
                UPLOAD_ERR_CANT_WRITE => '디스크에 파일을 쓸 수 없습니다.',
                UPLOAD_ERR_EXTENSION => 'PHP 확장에 의해 파일 업로드가 중지되었습니다.'
            ];
            

            $error_message = $upload_errors[$_FILES['h_file']['error']] ?? '파일 업로드 중 알 수 없는 오류가 발생했습니다.';
            echo "<script>alert('{$error_message}'); window.history.back();</script>";
            exit();
        } else {
            $upload_file = $_SESSION['uploaded_file'];
        }
    }


 

    $sql = "INSERT INTO pharmacy_tbl (
        ph_name, ph_sex, ph_id, ph_pw, ph_idnumber, ph_mobile, ph_file, ph_workingname, ph_workingaddress
    ) VALUES (
       '$ph_name', '$ph_sex', '$ph_id', '$ph_pw', '$ph_idnumber', '$ph_mobile', 
        '$h_file', '$ph_workingname', '$ph_workingaddress'
    )";

if ($conn->query($sql) === TRUE) {
    $_SESSION['user_id'] = $ph_id;
    $_SESSION['user_type'] = 'pharmacy';
    $_SESSION['user_name'] = $ph_name;
    $_SESSION['user_idnumber'] = $ph_idnumber;
    header("Location: agree_page.html");
    exit();
} else {
    echo "실패: " . mysqli_error($conn);
}

mysqli_close($conn);
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <link href="css/style.css?after" rel="stylesheet">
    <link href="css/join_pharmacy.css?after" rel="stylesheet">
    <link href="css/join_selecct.css?after" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Do+Hyeon&display=swap" rel="stylesheet">
    <title>IBK CENTER</title>
</head>

<body> 
    <a href="index.php"><img src="jpg/real logo.png" class="center-image"></a>
    
    <h2 class="con-min-width">
        <div class="con">
            <nav class="menu-bar_box1">
                <ul>
                    <li><a href="#" class="block">병원찾기</a></li>
                    <li><a href="#" class="block">약국찾기</a></li>
                    <li><a href="#" class="block">정보조회</a></li>
                    <li><a href="#" class="block">방문후기</a></li>
                    <li><a href="#" class="block">개인정보수정</a></li>
                </ul>
            </nav>
        </div>
    </h2>

    <hr class="hr_style">

    <div class="join_font1">회원가입</div>

    <img src="jpg/input_select.jpg" width="1400" class="member_select_img">
    <br><br><br><br>

    <div class="join_border">
        <div class="input_personal">
            <p class="personal_information">개인정보 | &nbsp;Personal </p>

            <div class="textForm">
                <form id="joinForm" action="" method="POST" enctype="multipart/form-data">
                
                <p class="input_font">이름<br>
                    <input name="ph_name" type="text" class="form_design"></p>

                <div class="radio-wrapper">
                    <input type="radio" name="ph_sex" id="male" value="male">
                    <label for="male" class="box">남</label>
                </div>
                
                <div class="radio-wrapper">
                    <input type="radio" name="ph_sex" id="female" value="female">
                    <label for="female" class="box">여</label>
                </div>
                <br><br>
                <br><br>

                <p class="input_font">아이디 &nbsp;<span id="id_check_message" style="color:red; display:none;">중복된 아이디입니다.</span><br>
                    <input name="ph_id" id="ph_id" type="text" class="form_design"></p>
                
                <p class="input_font_pw">비밀번호<br>
                    <input name="ph_pw" type="password" class="pw_design"></p>
                <br><br>

                <p class="input_font">주민등록번호<br>
                    <input name="ph_idnumber[]" type="text" class="ID_form_design" maxlength="6">&nbsp;-&nbsp;<input name="ph_idnumber[]" type="text" class="ID_form_design" maxlength="7"></p>
                <br>

                <p class="input_font">전화번호<br>
                    <input name="ph_mobile[]" type="text" class="mobile_form_design" maxlength="3">&nbsp;-&nbsp;
                    <input name="ph_mobile[]" type="text" class="mobile_form_design" maxlength="4">&nbsp;-&nbsp;
                    <input name="ph_mobile[]" type="text" class="mobile_form_design" maxlength="4"></p>
                <br>
            </div>
    
        </div>

        <div class="certification_layout">
            <p class="personal_information">면허증 | &nbsp;License </p>

            <label class="label" for="input">
                <div class="upload_file" id="drop_zone">
                    <img src="jpg/upload.png" class="upload_img">
                    <div class="upload_font" id="upload_message">
                        <h3>Upload your files or click here!</h3>
                    </div>
                </div>
                <div class="file_list" id="file_list"></div>
            </label>
            
            <input type="file" class="file_upload" id="input" accept=".pdf,image/*" required name="h_file">
        </div>

        <div class="working">
            <p class="personal_information">근무지 | &nbsp;Workplace </p>
            <p class="hospital_name">약국 이름<br>
                <input name="ph_workingname" type="text" class="disease_form" id="ph_workingname">
            </p>
            <div class="hos_add"><input type="button" class="post_btn_style" value="약국주소찾기" onclick="findHospitalAddress()"></div>
            <input type="text" id="phospital_address" class="hos_add1" placeholder="도로명주소" name="phospital_address" readonly><br>
        </div>
        
        <input type="submit" id="submitBtn" style="display: none;">
        </form>
    </div>

    <div class="btn_style3">
        <a href="join_select.html"><img src="jpg/pre_btn.jpg" width="100"></a>
        <a href="#" id="imageLink"><img src="jpg/next-btn.jpg" width="100"></a>
    </div>

    <br><br><br><br>
</body>
</html>

<script>
function findHospitalAddress() {
    var hospitalName = document.getElementById('ph_workingname').value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "ssssss.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            var address = this.responseText;
            document.getElementById('phospital_address').value = address;
        }
    }
    xhr.send("name=" + encodeURIComponent(hospitalName));
}

document.getElementById('ph_id').addEventListener('input', function() {
    var ph_id = this.value;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "check_id3.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            var response = JSON.parse(this.responseText);
            var message = document.getElementById('id_check_message');
            if (response.isDuplicate) {
                message.style.display = 'inline';
            } else {
                message.style.display = 'none';
            }
        }
    };
    xhr.send("ph_id=" + encodeURIComponent(ph_id));
});

const dropZone = document.getElementById('drop_zone');
const fileInput = document.getElementById('input');
const fileList = document.getElementById('file_list');
const uploadMessage = document.getElementById('upload_message');

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
    fileInput.files = files; // Assign files to file input
    handleFiles(files);
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
        if (i === 0) {
            uploadMessage.innerHTML = `<h3>${file.name}</h3>`;
        }
    }
}

document.getElementById('imageLink').addEventListener('click', function(event) {
    event.preventDefault();
    document.querySelector('form').submit();
});
</script>
