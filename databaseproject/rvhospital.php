<?php
session_start();
include("db_conn.php");

$h_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $h_distingush = $_POST['h_distingush'];
    $h_name = $_POST['h_name'];
    $h_sex = $_POST['h_sex'];
    $h_pw = $_POST['h_pw'];

    $h_idnumber_sets = $_POST['h_idnumber'];
    $h_idnumber = implode("-", $h_idnumber_sets);

    $h_mobile_sets = $_POST['h_mobile'];
    $h_mobile = implode("-", $h_mobile_sets);

    $h_major = $_POST['h_major'];
    $h_workingname = $_POST['h_workingname'];
    $h_workingaddress = $_POST['hospital_address'];

    $required_fields = [
        '이름을 입력해주세요' => $h_name,
        '성별을 선택해주세요' => $h_sex,
        '전화번호를 입력해주세요' => $h_mobile,
        '주민등록번호를 입력해주세요' => $h_idnumber,
    ];

    foreach ($required_fields as $field => $value) {
        if (empty($value)) {
            echo "<script>alert('" . $field . "'); window.history.back();</script>";
            exit();
        }
    }

    // Update SQL query
    if (!empty($h_pw)) {
        $sql = "UPDATE hospital_tbl SET 
            h_distingush = '$h_distingush', h_name = '$h_name', h_sex = '$h_sex', h_pw = '$h_pw', 
            h_idnumber = '$h_idnumber', h_mobile = '$h_mobile', h_major = '$h_major', 
            h_workingname = '$h_workingname', h_workingaddress = '$h_workingaddress' 
        WHERE h_id = '$h_id'";
    } else {
        $sql = "UPDATE hospital_tbl SET 
            h_distingush = '$h_distingush', h_name = '$h_name', h_sex = '$h_sex', 
            h_idnumber = '$h_idnumber', h_mobile = '$h_mobile', h_major = '$h_major', 
            h_workingname = '$h_workingname', h_workingaddress = '$h_workingaddress' 
        WHERE h_id = '$h_id'";
    }

    if ($conn->query($sql) === TRUE) {
        $_SESSION['user_info']['h_name'] = $h_name;
        $_SESSION['user_info']['h_mobile'] = $h_mobile;
        $_SESSION['user_info']['h_idnumber'] = $h_idnumber;
        header("Location: login.php");
        exit();
    } else {
        echo "실패: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    // 기존 데이터를 불러오기 위한 SQL 쿼리
    $sql = "SELECT * FROM hospital_tbl WHERE h_id = '$h_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $h_distingush = $row['h_distingush'];
        $h_name = $row['h_name'];
        $h_sex = $row['h_sex'];
        $h_idnumber = explode("-", $row['h_idnumber']);
        $h_mobile = explode("-", $row['h_mobile']);
        $h_major = $row['h_major'];
        $h_workingname = $row['h_workingname'];
        $h_workingaddress = $row['h_workingaddress'];
    } else {
        echo "유효한 사용자 정보가 없습니다.";
        exit();
    }
}
?>


<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <link href="css/style.css?after" rel="stylesheet">
    <link href="css/rvhospital.css" rel="stylesheet">
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
</head>

<body> 
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

    <div class="join_font1">정보수정 - 병원</div>
    <br><br>

    <div class="join_border">
        <!--환자의 개인정보 입력칸-->
        <div class="input_personal">
            <p class="personal_information">개인정보 | &nbsp;Personal </p>

            <div class="textForm">
                <form id="joinForm" action="" method="POST">
                <p class="input_font">구분<br>
                    <select name="h_distingush" class="select_disting">
                        <option value="doctor" <?php echo ($h_distingush == 'doctor') ? 'selected' : ''; ?>>의사</option>
                        <option value="nurse" <?php echo ($h_distingush == 'nurse') ? 'selected' : ''; ?>>간호사</option>
                    </select>
                </p>
                <br><br><br><br><br><br>
            
                <p class="input_font">이름<br>
                    <input name="h_name" type="text" class="form_design" value="<?php echo htmlspecialchars($h_name); ?>"></p>

                <!--성별 선택-->
                <div class="radio-wrapper">
                    <input type="radio" name="h_sex" id="male" value="male" <?php echo ($h_sex == 'male') ? 'checked' : ''; ?>>
                    <label for="male" class="box">남</label>
                </div>
                
                <div class="radio-wrapper">
                    <input type="radio" name="h_sex" id="female" value="female" <?php echo ($h_sex == 'female') ? 'checked' : ''; ?>>
                    <label for="female" class="box">여</label>
                </div>
                <br><br>
                <br><br>

                <p class="input_font">아이디<br>
                    <input name="h_id" id="h_id" type="text" class="form_design" value="<?php echo htmlspecialchars($h_id); ?>" readonly></p>
                
                <p class="input_font_pw">비밀번호<br>
                    <input name="h_pw" type="password" class="pw_design"></p>
                <br><br>

                <p class="input_font">주민등록번호<br>
                    <input name="h_idnumber[]" type="text" class="ID_form_design" maxlength="6" value="<?php echo htmlspecialchars($h_idnumber[0]); ?>">&nbsp;-&nbsp;
                    <input name="h_idnumber[]" type="text" class="ID_form_design" maxlength="7" value="<?php echo htmlspecialchars($h_idnumber[1]); ?>"></p>
                <br>

                
                <br>
            </div>
    
        </div>

        <div class="certification_layout">  
        <p class="input_font">전화번호<br>
                    <input name="h_mobile[]" type="text" class="mobile_form_design" maxlength="3" value="<?php echo htmlspecialchars($h_mobile[0]); ?>">&nbsp;-&nbsp;
                    <input name="h_mobile[]" type="text" class="mobile_form_design" maxlength="4" value="<?php echo htmlspecialchars($h_mobile[1]); ?>">&nbsp;-&nbsp;
                    <input name="h_mobile[]" type="text" class="mobile_form_design" maxlength="4" value="<?php echo htmlspecialchars($h_mobile[2]); ?>"></p>
                <br>

                <p class="input_font">전공분야<br>
                    <input name="h_major" type="text" class="major_select" value="<?php echo htmlspecialchars($h_major); ?>">
                </p>
            
        </div>

        <div class="working">
            <p class="personal_information">근무지 | &nbsp;Workplace </p>
            <p class="hospital_name">병원 이름<br>
            <input name="h_workingname" type="text" class="disease_form" id="h_workingname" value="<?php echo htmlspecialchars($h_workingname); ?>">
            </p>
            <div class="hos_add"><input type="button" class="post_btn_style" value="병원주소찾기" onclick="findHospitalAddress()"></div>
            <input type="text" id="hospital_address" class="hos_add1" placeholder="도로명주소" name="hospital_address" readonly value="<?php echo htmlspecialchars($h_workingaddress); ?>"><br>
        </div>
        
        <input type="submit" id="submitBtn" style="display: none;">
        </form>
    </div>

    <div class = "btn_save">
            <a href="#" id="imageLink"><img src="jpg/save_btn.jpg" width="200"></a>
        </div>

    <br><br><br><br>
</body>
</html>

<script>
function findHospitalAddress() {
    var hospitalName = document.getElementById('h_workingname').value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "sssss.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            var address = this.responseText;
            document.getElementById('hospital_address').value = address;
        }
    }
    xhr.send("name=" + encodeURIComponent(hospitalName));
}

document.getElementById('imageLink').addEventListener('click', function(event) {
    event.preventDefault(); // 링크 기본 동작 막기
    document.querySelector('form').submit(); // 폼 제출
});
</script>
