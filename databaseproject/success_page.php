<?php
session_start();

// 세션에 저장된 정보를 변수에 할당
$user_type = $_SESSION['user_type'];
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_idnumber = $_SESSION['user_idnumber'];

// user_type을 한글로 변환 및 이미지 파일 설정
switch ($user_type) {
    case 'personal':
        $image_file = 'personal_img.jpg';
        break;
    case 'hospital':
        $image_file = 'hospital_img.jpg';
        break;
    case 'pharmacy':
        $image_file = 'pharmacy_img.jpg';
        break;
    default:
        $image_file = 'default_img.jpg'; // 기본 이미지 설정
}
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/join_selecct.css" rel="stylesheet">
    <link href="css/agree_page.css" rel="stylesheet">
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

    <div class="join_font1">회원가입</div>
    <img src="jpg/success_select.jpg" width="1400" class="member_select_img">
    <br><br><br><br>

    <h2 class="message">회원가입이 완료되었습니다.</h2>
    <div class="information">
        <p class="info"> > 이름: <?php echo htmlspecialchars($user_name); ?></p>
        <p class="info"> > 아이디: <?php echo htmlspecialchars($user_id); ?></p>
        <p class="info"> > 주민등록번호: <?php echo htmlspecialchars($user_idnumber); ?></p>
    </div>

    <div class="user-image">
        <img src="jpg/<?php echo htmlspecialchars($image_file); ?>" alt="User Type Image" class="imgd">
    </div>

    <div class = "homebutton"><a href = "index.php"><img src = "jpg/homebutton.jpg" width = "20%"></a></div>
</body>
</html>
