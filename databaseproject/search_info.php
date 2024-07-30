<?php
session_start();
include 'db_conn.php';

// URL 매개변수로 전달된 환자 이름과 주민등록번호를 가져옵니다.
$p_name = isset($_GET['p_name']) ? $_GET['p_name'] : '';
$p_idnumber1 = isset($_GET['p_idnumber1']) ? $_GET['p_idnumber1'] : '';
$p_idnumber2 = isset($_GET['p_idnumber2']) ? $_GET['p_idnumber2'] : '';
$p_idnumber = $p_idnumber1 . '-' . $p_idnumber2;

$patient_info = null; // 초기화

if ($p_name && $p_idnumber) {
    // 데이터베이스에서 환자의 정보를 조회합니다.
    $sql = "SELECT * FROM personal_tbl WHERE p_name = ? AND p_idnumber = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ss", $p_name, $p_idnumber);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $patient_info = $result->fetch_assoc();
        } else {
            $error_message = "환자의 정보를 찾을 수 없습니다.";
        }
        $stmt->close();
    } else {
        $error_message = "데이터베이스 조회 중 오류가 발생했습니다.";
    }
} else {
    $error_message = "유효한 환자 정보가 제공되지 않았습니다.";
}
$conn->close();
?>

<!DOCTYPE HTML>
<HTML>
    <HEAD>
        <meta charset="utf-8">
        <link href = "css/style.css" rel = "stylesheet">
        <link href = "css/testcheck.css?after" rel = "stylesheet">
        <link href = "css/testsearchinfo.css?after" rel = "stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Do+Hyeon&display=swap" rel="stylesheet">
        
        <title>IBK CENTER</title>
        <script>
        function deletePrescription(p_id) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_prescription.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    if (xhr.responseText === "success") {
                        console.log("처방전이 삭제되었습니다.");
                    } else {
                        console.log("처방전 삭제 중 오류가 발생했습니다: " + xhr.responseText);
                    }
                }
            };
            xhr.send("p_id=" + p_id);
        }

        function handlePrescriptionDownload(prescription, p_id) {
            if (prescription) {
                deletePrescription(p_id);
                window.location.href = "http://localhost/databaseproject/prescription/" + encodeURIComponent(prescription);
            } else {
                alert("처방전이 존재하지 않습니다.");
            }
        }
        </script>

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
        
        <h2 class = "con-min-width">
            <div class = "con">
                <nav class = "menu-bar_box1">
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
        <hr class = "hr_style">
        </header>
        <div class = "join_font">정보 조회</div>
        <div class = "layout">
            <?php if (isset($patient_info) && $patient_info): ?>
                <div class = "left">
                    <p class = "input_font1">환자 이름 &nbsp; &nbsp;| &nbsp; &nbsp; <?php echo htmlspecialchars($patient_info['p_name']); ?></p>
                    <p class = "input_font2">환자 주민등록번호 &nbsp; &nbsp;| &nbsp; &nbsp; <?php echo htmlspecialchars($patient_info['p_idnumber']); ?></p>
                    <p class = "input_font2">환자 전화번호 &nbsp; &nbsp;| &nbsp; &nbsp; <?php echo htmlspecialchars($patient_info['p_mobile']); ?></p>
                    <p class = "input_font2">환자 키 / 몸무게 &nbsp; &nbsp;| &nbsp; &nbsp; <?php echo htmlspecialchars($patient_info['p_height']); ?>cm &nbsp;/&nbsp; <?php echo htmlspecialchars($patient_info['p_weight']); ?>kg</p>
                    <p class = "input_font2">환자 주소 &nbsp; &nbsp;| &nbsp; &nbsp; (<?php echo htmlspecialchars($patient_info['p_adressnumber']); ?>) <?php echo htmlspecialchars($patient_info['p_roadaddress']); ?></p>
                </div>
                <div class = "rigth">
                    <p class = "input_font1">기존 질병 &nbsp; &nbsp;| &nbsp; &nbsp; <?php echo htmlspecialchars($patient_info['p_disease']); ?></p>
                    <p class = "input_font3"> 방문 병원 / 주소  &nbsp; &nbsp;| &nbsp; &nbsp; <?php echo htmlspecialchars($patient_info['p_hospitalname']); ?>&nbsp;/&nbsp; <?php echo htmlspecialchars($patient_info['p_hospitaladdress']); ?></p>
                    <p class = "input_font3">보호자 이름 &nbsp; &nbsp;| &nbsp; &nbsp; <?php echo htmlspecialchars($patient_info['p_protectorname']); ?> (<?php echo htmlspecialchars($patient_info['p_protectorrelation']); ?>)</p>
                    <p class = "input_font3">보호자 주민등록번호 &nbsp; &nbsp;| &nbsp; &nbsp; <?php echo htmlspecialchars($patient_info['p_protectoridnumber']); ?></p>
                    <p class = "input_font3">보호자 연락처 &nbsp; &nbsp;| &nbsp; &nbsp; <?php echo htmlspecialchars($patient_info['p_protectormobile']); ?></p>
                </div>
                <div class = "pre_img">
                    <a href="javascript:void(0);"  onclick="handlePrescriptionDownload('<?php echo htmlspecialchars($patient_info['p_prescription']); ?>', '<?php echo htmlspecialchars($patient_info['p_id']); ?>')" download>
                        <img src="jpg/prescription_btn.jpg" width="290">
                    </a>
                </div>
            <?php else: ?>
                <p>echo '<script>alert("환자의 정보가 없습니다."); window.location.href = "check_information.php";</script>';</p>
            <?php endif; ?>
            <div class = "back_btn">
                <a href = "check_information.php"><img src = "jpg/back_btn.jpg" width = "200"></a>
            </div>
        </div>
    </BODY>
</HTML>
