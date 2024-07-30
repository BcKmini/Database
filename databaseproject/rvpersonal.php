<?php
session_start();
include("db_conn.php");

$p_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $p_name = $_POST['p_name'];
    $p_sex = $_POST['p_sex'];
    $p_pw = $_POST['p_pw']; // 비밀번호 필드 추가
    $p_idnumber_sets = $_POST['p_idnumber'];
    $p_idnumber = implode("-", $p_idnumber_sets);
    $p_mobile_sets = $_POST['p_mobile'];
    $p_mobile = implode("-", $p_mobile_sets);
    $p_height = $_POST['p_height'];
    $p_weight = $_POST['p_weight'];
    $p_adressnumber = $_POST['p_adressnumber'];
    $p_roadaddress = $_POST['p_roadaddress'];
    $p_jibunaddress = $_POST['p_jibunaddress'];
    $p_detailaddress = $_POST['p_detailaddress'];
    $p_disease = $_POST['p_disease'];
    $p_hospitalname = $_POST['p_hospitalname'];
    $p_hospitaladdress = $_POST['hospital_address'];
    $p_protectorname = $_POST['p_protectorname'];
    $p_protectorrelation = $_POST['p_protectorrelation'];
    $p_protectoridnumber_sets = $_POST['p_protectoridnumber'];
    $p_protectoridnumber = implode("-", $p_protectoridnumber_sets);
    $p_protectormobile_sets = $_POST['p_protectormobile'];
    $p_protectormobile = implode("-", $p_protectormobile_sets);

    $required_fields = [
        '이름을 입력해주세요' => $p_name,
        '성별을 선택해주세요' => $p_sex,
        '전화번호를 입력해주세요' => $p_mobile,
        '주민등록번호를 입력해주세요' => $p_idnumber,
    ];

    foreach ($required_fields as $field => $value) {
        if (empty($value)) {
            echo "<script>alert('" . $field . "'); window.history.back();</script>";
            exit();
        }
    }

    // 비밀번호를 입력했는지 확인
    if (!empty($p_pw)) {
        $sql = "UPDATE personal_tbl SET 
            p_name = '$p_name', p_sex = '$p_sex', p_pw = '$p_pw', 
            p_idnumber = '$p_idnumber', p_mobile = '$p_mobile', p_height = '$p_height', p_weight = '$p_weight', 
            p_adressnumber = '$p_adressnumber', p_roadaddress = '$p_roadaddress', p_jibunaddress = '$p_jibunaddress', p_detailaddress = '$p_detailaddress', 
            p_disease = '$p_disease', p_hospitalname = '$p_hospitalname', p_hospitaladdress = '$p_hospitaladdress', 
            p_protectorname = '$p_protectorname', p_protectorrelation = '$p_protectorrelation', 
            p_protectoridnumber = '$p_protectoridnumber', p_protectormobile = '$p_protectormobile' 
        WHERE p_id = '$p_id'";
    } else {
        $sql = "UPDATE personal_tbl SET 
            p_name = '$p_name', p_sex = '$p_sex', 
            p_idnumber = '$p_idnumber', p_mobile = '$p_mobile', p_height = '$p_height', p_weight = '$p_weight', 
            p_adressnumber = '$p_adressnumber', p_roadaddress = '$p_roadaddress', p_jibunaddress = '$p_jibunaddress', p_detailaddress = '$p_detailaddress', 
            p_disease = '$p_disease', p_hospitalname = '$p_hospitalname', p_hospitaladdress = '$p_hospitaladdress', 
            p_protectorname = '$p_protectorname', p_protectorrelation = '$p_protectorrelation', 
            p_protectoridnumber = '$p_protectoridnumber', p_protectormobile = '$p_protectormobile' 
        WHERE p_id = '$p_id'";
    }

    if ($conn->query($sql) === TRUE) {
        // 세션 데이터 업데이트
        $_SESSION['user_info']['p_name'] = $p_name;
        $_SESSION['user_info']['p_mobile'] = $p_mobile;
        header("Location: login.php");
        exit();
    } else {
        echo "실패: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    // 기존 데이터를 불러오기 위한 SQL 쿼리
    $sql = "SELECT * FROM personal_tbl WHERE p_id = '$p_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $p_name = $row['p_name'];
        $p_sex = $row['p_sex'];
        $p_idnumber = explode("-", $row['p_idnumber']);
        $p_mobile = explode("-", $row['p_mobile']);
        $p_height = $row['p_height'];
        $p_weight = $row['p_weight'];
        $p_adressnumber = $row['p_adressnumber'];
        $p_roadaddress = $row['p_roadaddress'];
        $p_jibunaddress = $row['p_jibunaddress'];
        $p_detailaddress = $row['p_detailaddress'];
        $p_disease = $row['p_disease'];
        $p_hospitalname = $row['p_hospitalname'];
        $p_hospitaladdress = $row['p_hospitaladdress'];
        $p_protectorname = $row['p_protectorname'];
        $p_protectorrelation = $row['p_protectorrelation'];
        $p_protectoridnumber = explode("-", $row['p_protectoridnumber']);
        $p_protectormobile = explode("-", $row['p_protectormobile']);
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
    <link href="css/style.css" rel="stylesheet">
    <link href="css/rvpersonal.css" rel="stylesheet">
    <link href="css/join_selecct.css" rel="stylesheet">
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
        <div class="join_font1">정보수정 - 개인</div>
        <div class="join_border">
            <div class="input_personal">
                <p class="personal_information">개인정보 | &nbsp;Personal </p>
                <div class="textForm">
                    <form action="" method="post" id="searchForm">
                        <p class="input_font">이름<br>
                            <input name="p_name" type="text" class="form_design" value="<?php echo htmlspecialchars($p_name); ?>"></p>

                        <div class="radio-wrapper">
                            <input type="radio" name="p_sex" id="male" value="male" <?php echo ($p_sex == 'male') ? 'checked' : ''; ?>>
                            <label for="male" class="box">남</label>
                        </div>
                    
                        <div class="radio-wrapper">
                            <input type="radio" name="p_sex" id="female" value="female" <?php echo ($p_sex == 'female') ? 'checked' : ''; ?>>
                            <label for="female" class="box">여</label>
                        </div>
                        <br><br><br>

                        <p class="input_font">아이디<br>
                            <input name="p_id" id="p_id" type="text" class="form_design" value="<?php echo htmlspecialchars($p_id); ?>" readonly>
                        </p>

                        <p class="input_font_pw">비밀번호<br>
                            <input name="p_pw" type="password" class="pw_design"></p>
                        <br>

                        <p class="input_font">주민등록번호<br>
                            <input name="p_idnumber[]" type="text" class="ID_form_design" maxlength="6" value="<?php echo htmlspecialchars($p_idnumber[0]); ?>">&nbsp;-&nbsp;
                            <input name="p_idnumber[]" type="text" class="ID_form_design" maxlength="7" value="<?php echo htmlspecialchars($p_idnumber[1]); ?>"></p>
                        <br>

                        <p class="input_font">전화번호<br>
                            <input name="p_mobile[]" type="text" class="mobile_form_design" maxlength="3" value="<?php echo htmlspecialchars($p_mobile[0]); ?>">&nbsp;-&nbsp;
                            <input name="p_mobile[]" type="text" class="mobile_form_design" maxlength="4" value="<?php echo htmlspecialchars($p_mobile[1]); ?>">&nbsp;-&nbsp;
                            <input name="p_mobile[]" type="text" class="mobile_form_design" maxlength="4" value="<?php echo htmlspecialchars($p_mobile[2]); ?>"></p>
                        <br>
                        <p class="input_font">키 &nbsp;|&nbsp; 몸무게<br>
                            <input name="p_height" type="text" class="body_design" value="<?php echo htmlspecialchars($p_height); ?>">cm &nbsp;/&nbsp;
                            <input name="p_weight" type="text" class="body_design" value="<?php echo htmlspecialchars($p_weight); ?>">kg</p>
                        <br>

                        <p class="input_font">주소<br>
                            <input type="text" class="postcode_style" id="sample4_postcode" name="p_adressnumber" value="<?php echo htmlspecialchars($p_adressnumber); ?>">
                            <div class="post_btn"><input type="button" onclick="sample4_execDaumPostcode()" class="post_btn_style" value="도로명주소찾기"></div>
                            <input type="text" id="sample4_roadAddress" class="road_address1" placeholder="도로명주소" name="p_roadaddress" value="<?php echo htmlspecialchars($p_roadaddress); ?>"><br>
                            <input type="text" id="sample4_jibunAddress" class="road_address" placeholder="지번주소" name="p_jibunaddress" value="<?php echo htmlspecialchars($p_jibunaddress); ?>">
                            <input type="text" id="sample4_detailAddress" class="road_address" placeholder="상세주소" name="p_detailaddress" value="<?php echo htmlspecialchars($p_detailaddress); ?>">
                        </p>
                    </div>
                </div>

                <div class="disease">
                    <p class="personal_information">진료정보 | &nbsp;Medical </p>
                    <div class="textForm">
                        <p class="input_font">기존 질병<br>
                            <input name="p_disease" type="text" class="disease_form" value="<?php echo htmlspecialchars($p_disease); ?>">
                        </p>
                        <br><br>
                        <p class="hospital_name">병원 이름<br>
                            <input name="p_hospitalname" type="text" class="disease_form" id="p_hospitalname" value="<?php echo htmlspecialchars($p_hospitalname); ?>">
                        </p>
                        <div class="hos_add"><input type="button" class="post_btn_style" value="병원주소찾기" onclick="findHospitalAddress()"></div>
                        <input type="text" id="hospital_address" class="hos_add1" placeholder="도로명주소" name="hospital_address" value="<?php echo htmlspecialchars($p_hospitaladdress); ?>" readonly><br>
                    </div>
                </div>

                <div class="protecter">
                    <p class="personal_information">보호자정보 | &nbsp;Protector </p>
                    <div class="textForm">
                        <p class="input_font">보호자이름<br>
                            <input name="p_protectorname" type="text" class="form_design" value="<?php echo htmlspecialchars($p_protectorname); ?>"></p>

                        <p class="relationship">관계<br>
                            <select class="select_relation" name="p_protectorrelation">
                                <option value="부" <?php echo ($p_protectorrelation == '부') ? 'selected' : ''; ?>>부</option>
                                <option value="모" <?php echo ($p_protectorrelation == '모') ? 'selected' : ''; ?>>모</option>
                                <option value="친구" <?php echo ($p_protectorrelation == '친구') ? 'selected' : ''; ?>>친구</option>
                                <option value="애인" <?php echo ($p_protectorrelation == '애인') ? 'selected' : ''; ?>>애인</option>
                                <option value="배우자" <?php echo ($p_protectorrelation == '배우자') ? 'selected' : ''; ?>>배우자</option>
                            </select>
                        </p>
                        <br>
                        <p class="input_font">보호자 주민등록번호<br>
                            <input name="p_protectoridnumber[]" type="text" class="ID_form_design" maxlength="6" value="<?php echo htmlspecialchars($p_protectoridnumber[0]); ?>">&nbsp;-&nbsp;
                            <input name="p_protectoridnumber[]" type="text" class="ID_form_design" maxlength="7" value="<?php echo htmlspecialchars($p_protectoridnumber[1]); ?>"></p>
                        <br>
                        <p class="input_font">보호자 전화번호<br>
                            <input name="p_protectormobile[]" type="text" class="mobile_form_design" maxlength="3" value="<?php echo htmlspecialchars($p_protectormobile[0]); ?>">&nbsp;-&nbsp;
                            <input name="p_protectormobile[]" type="text" class="mobile_form_design" maxlength="4" value="<?php echo htmlspecialchars($p_protectormobile[1]); ?>">&nbsp;-&nbsp;
                            <input name="p_protectormobile[]" type="text" class="mobile_form_design" maxlength="4" value="<?php echo htmlspecialchars($p_protectormobile[2]); ?>"></p>
                    </div>
                </div>
                <input type="submit" id="submitBtn" style="display:none;">
            </form>
        </div>

        <div class = "btn_save">
            <a href="#" id="imageLink"><img src="jpg/save_btn.jpg" width="200"></a>
        </div>
        <br><br><br><br>
    </header>
</body>
</html>

<script>
function findHospitalAddress() {
    var hospitalName = document.getElementById('p_hospitalname').value;

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

document.getElementById('p_id').addEventListener('input', function() {
    var p_id = this.value;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "check_id.php", true);
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
    xhr.send("p_id=" + encodeURIComponent(p_id));
});
</script>
<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

<script>
function sample4_execDaumPostcode() {
    new daum.Postcode({
        oncomplete: function(data) {
            var roadAddr = data.roadAddress;
            var extraRoadAddr = '';

            if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
                extraRoadAddr += data.bname;
            }
            if (data.buildingName !== '' && data.apartment === 'Y') {
                extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
            }
            if (extraRoadAddr !== '') {
                extraRoadAddr = ' (' + extraRoadAddr + ')';
            }

            document.getElementById('sample4_postcode').value = data.zonecode;
            document.getElementById("sample4_roadAddress").value = roadAddr;
            document.getElementById("sample4_jibunAddress").value = data.jibunAddress;

            if (roadAddr !== '') {
                document.getElementById("sample4_extraAddress").value = extraRoadAddr;
            } else {
                document.getElementById("sample4_extraAddress").value = '';
            }

            var guideTextBox = document.getElementById("guide");
            if (data.autoRoadAddress) {
                var expRoadAddr = data.autoRoadAddress + extraRoadAddr;
                guideTextBox.innerHTML = '(예상 도로명 주소 : ' + expRoadAddr + ')';
                guideTextBox.style.display = 'block';

            } else if (data.autoJibunAddress) {
                var expJibunAddr = data.autoJibunAddress;
                guideTextBox.innerHTML = '(예상 지번 주소 : ' + expJibunAddr + ')';
                guideTextBox.style.display = 'block';
            } else {
                guideTextBox.innerHTML = '';
                guideTextBox.style.display = 'none';
            }
        }
    }).open();
}

document.getElementById('imageLink').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('submitBtn').click();
});
</script>
