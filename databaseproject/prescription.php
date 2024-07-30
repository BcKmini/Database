<?php
session_start();
$patient_info = isset($_SESSION['patient_info']) ? $_SESSION['patient_info'] : null;
?>

<!DOCTYPE HTML>
<HTML>
    <HEAD>
        <meta charset="utf-8">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/check_information.css?after" rel="stylesheet">
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
            <?php if ($patient_info): ?>
                <div class="patient-info">
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($patient_info["p_name"]); ?></p>
                    <p><strong>Sex:</strong> <?php echo htmlspecialchars($patient_info["p_sex"]); ?></p>
                    <p><strong>Mobile:</strong> <?php echo htmlspecialchars($patient_info["p_mobile"]); ?></p>
                    <p><strong>Height:</strong> <?php echo htmlspecialchars($patient_info["p_height"]); ?></p>
                    <p><strong>Weight:</strong> <?php echo htmlspecialchars($patient_info["p_weight"]); ?></p>
                    <p><strong>Address Number:</strong> <?php echo htmlspecialchars($patient_info["p_adressnumber"]); ?></p>
                    <p><strong>Road Address:</strong> <?php echo htmlspecialchars($patient_info["p_roadaddress"]); ?></p>
                    <p><strong>Jibun Address:</strong> <?php echo htmlspecialchars($patient_info["p_jibunaddress"]); ?></p>
                    <p><strong>Detail Address:</strong> <?php echo htmlspecialchars($patient_info["p_detailaddress"]); ?></p>
                    <p><strong>Disease:</strong> <?php echo htmlspecialchars($patient_info["p_disease"]); ?></p>
                    <p><strong>Hospital Name:</strong> <?php echo htmlspecialchars($patient_info["p_hospitalname"]); ?></p>
                    <p><strong>Hospital Address:</strong> <?php echo htmlspecialchars($patient_info["p_hospitaladdress"]); ?></p>
                    <p><strong>Protector Name:</strong> <?php echo htmlspecialchars($patient_info["p_protectorname"]); ?></p>
                    <p><strong>Protector Relation:</strong> <?php echo htmlspecialchars($patient_info["p_protectorrelation"]); ?></p>
                    <p><strong>Protector ID Number:</strong> <?php echo htmlspecialchars($patient_info["p_protectoridnumber"]); ?></p>
                    <p><strong>Protector Mobile:</strong> <?php echo htmlspecialchars($patient_info["p_protectormobile"]); ?></p>
                </div>
            <?php else: ?>
                <p>No patient information found.</p>
            <?php endif; ?>
        </div>
    </BODY>
</HTML>
