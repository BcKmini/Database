<?php
session_start();
include("db_conn.php");

$ph_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ph_name = $_POST['ph_name'];
    $ph_sex = $_POST['ph_sex'];
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
        '주민등록번호를 입력해주세요' => $ph_idnumber,
    ];

    foreach ($required_fields as $field => $value) {
        if (empty($value)) {
            echo "<script>alert('" . $field . "'); window.history.back();</script>";
            exit();
        }
    }

    // Update SQL query
    if (!empty($ph_pw)) {
        $sql = "UPDATE pharmacy_tbl SET 
            ph_name = '$ph_name', ph_sex = '$ph_sex', ph_pw = '$ph_pw', 
            ph_idnumber = '$ph_idnumber', ph_mobile = '$ph_mobile', 
            ph_workingname = '$ph_workingname', ph_workingaddress = '$ph_workingaddress' 
        WHERE ph_id = '$ph_id'";
    } else {
        $sql = "UPDATE pharmacy_tbl SET 
            ph_name = '$ph_name', ph_sex = '$ph_sex', 
            ph_idnumber = '$ph_idnumber', ph_mobile = '$ph_mobile', 
            ph_workingname = '$ph_workingname', ph_workingaddress = '$ph_workingaddress' 
        WHERE ph_id = '$ph_id'";
    }

    if ($conn->query($sql) === TRUE) {
        $_SESSION['user_info']['ph_name'] = $ph_name;
        $_SESSION['user_info']['ph_mobile'] = $ph_mobile;
        $_SESSION['user_info']['ph_idnumber'] = $ph_idnumber;
        header("Location: login.php");
        exit();
    } else {
        echo "실패: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    // 기존 데이터를 불러오기 위한 SQL 쿼리
    $sql = "SELECT * FROM pharmacy_tbl WHERE ph_id = '$ph_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $ph_name = $row['ph_name'];
        $ph_sex = $row['ph_sex'];
        $ph_idnumber = explode("-", $row['ph_idnumber']);
        $ph_mobile = explode("-", $row['ph_mobile']);
        $ph_workingname = $row['ph_workingname'];
        $ph_workingaddress = $row['ph_workingaddress'];
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
    <link href="css/rvpharmacy.css?after" rel="stylesheet">
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

    <div class="join_font1">정보수정 - 약국</div>
    <br><br>

    <div class="join_border">
        <!--환자의 개인정보 입력칸-->
        <div class="input_personal">
            <p class="personal_information">개인정보 | &nbsp;Personal </p>

            <div class="textForm">
                <form id="joinForm" action="" method="POST">
               
                <br><br><br><br><br><br>
            
                <p class="input_font">이름<br>
                    <input name="ph_name" type="text" class="form_design" value="<?php echo htmlspecialchars($ph_name); ?>"></p>

                <!--성별 선택-->
                <div class="radio-wrapper">
                    <input type="radio" name="ph_sex" id="male" value="male" <?php echo ($ph_sex == 'male') ? 'checked' : ''; ?>>
                    <label for="male" class="box">남</label>
                </div>
                
                <div class="radio-wrapper">
                    <input type="radio" name="ph_sex" id="female" value="female" <?php echo ($ph_sex == 'female') ? 'checked' : ''; ?>>
                    <label for="female" class="box">여</label>
                </div>
                <br><br>
                <br><br>

                <p class="input_font">아이디<br>
                    <input name="ph_id" id="ph_id" type="text" class="form_design" value="<?php echo htmlspecialchars($ph_id); ?>" readonly></p>
                
                <p class="input_font_pw">비밀번호<br>
                    <input name="ph_pw" type="password" class="pw_design"></p>
                <br><br>

                <p class="input_font">주민등록번호<br>
                    <input name="ph_idnumber[]" type="text" class="ID_form_design" maxlength="6" value="<?php echo htmlspecialchars($ph_idnumber[0]); ?>">&nbsp;-&nbsp;
                    <input name="ph_idnumber[]" type="text" class="ID_form_design" maxlength="7" value="<?php echo htmlspecialchars($ph_idnumber[1]); ?>"></p>
                <br>

                <p class="input_font">전화번호<br>
                    <input name="ph_mobile[]" type="text" class="mobile_form_design" maxlength="3" value="<?php echo htmlspecialchars($ph_mobile[0]); ?>">&nbsp;-&nbsp;
                    <input name="ph_mobile[]" type="text" class="mobile_form_design" maxlength="4" value="<?php echo htmlspecialchars($ph_mobile[1]); ?>">&nbsp;-&nbsp;
                    <input name="ph_mobile[]" type="text" class="mobile_form_design" maxlength="4" value="<?php echo htmlspecialchars($ph_mobile[2]); ?>"></p>
                <br>
                <br>
            </div>
    
        </div>

        <div class="certification_layout">  
         <p class="personal_information">근무지 | &nbsp;Workplace </p>
            <p class="hospital_name">약국 이름<br>
            <input name="ph_workingname" type="text" class="disease_form" id="ph_workingname" value="<?php echo htmlspecialchars($ph_workingname); ?>">
            </p>
            <div class="hos_add"><input type="button" class="post_btn_style" value="약국주소찾기" onclick="findHospitalAddress()"></div>
            <input type="text" id="phospital_address" class="hos_add1" placeholder="도로명주소" name="phospital_address" readonly value="<?php echo htmlspecialchars($ph_workingaddress); ?>"><br>
            
        </div>

        <div class="working">
           
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

document.getElementById('imageLink').addEventListener('click', function(event) {
    event.preventDefault();
    document.querySelector('form').submit();
});
</script>
