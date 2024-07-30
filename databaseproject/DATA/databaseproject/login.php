<?php
session_start();
include 'db_conn.php'; // 데이터베이스 연결 설정 파일 포함

if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    session_destroy();
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 테이블 목록
    $tables = [
        'personal_tbl' => ['id' => 'p_id', 'pw' => 'p_pw', 'name' => 'p_name', 'mobile' => 'p_mobile'],
        'hospital_tbl' => ['id' => 'h_id', 'pw' => 'h_pw', 'name' => 'h_name', 'mobile' => 'h_mobile'],
        'pharmacy_tbl' => ['id' => 'ph_id', 'pw' => 'ph_pw', 'name' => 'ph_name', 'mobile' => 'ph_mobile']
    ];

    $user_info = null;

    foreach ($tables as $table => $columns) {
        $query = "SELECT * FROM $table WHERE {$columns['id']} = '$username' AND {$columns['pw']} = '$password'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $user_info = mysqli_fetch_assoc($result);
            $user_info['type'] = $table; // 사용자 유형 저장
            $user_info['id_column'] = $columns['id'];
            $user_info['name_column'] = $columns['name'];
            $user_info['mobile_column'] = $columns['mobile'];
            break;
        }   
    }

    if ($user_info) {
        $_SESSION['user_info'] = $user_info;
        header('Location: login.php'); // 로그인 성공 시 login.php 페이지로 이동
        exit();
    } else {
        header('Location: index.php?error=1'); // 로그인 실패 시 index.html 페이지로 이동
        exit();
    }
}
?>

<!DOCTYPE HTML>
<HTML>
<HEAD>
    <meta charset="utf-8">
    <link href="css/style.css?after" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Do+Hyeon&display=swap" rel="stylesheet">
    <title>IBK CENTER</title>
</HEAD>

<BODY>
    <header>
        <img src="jpg/real logo.png" class="center-image">
        <h2 class="con-min-width">
            <div class="con">
                <nav class="menu-bar_box1">
                    <ul>
                        <li><a href="find_hospital.html" class="block">병원찾기</a></li>
                        <li><a href="#" class="block">약국찾기</a></li>
                        <li><a href="check_information.php" class="block">정보조회</a></li>
                        <li><a href="#" class="block">방문후기</a></li>
                        <li><a href="#" class="block">개인정보수정</a></li>
                    </ul>
                </nav>
            </div>
        </h2>
        <hr class="hr_style">
    </header>
    <div>
        <img src="banner.jpg" class="banner-image">
        <div class="login_box">
            <?php if (isset($_SESSION['user_info'])): ?>
                <?php $user_info = $_SESSION['user_info']; ?>
                <h3 class="login-font3">WELCOME</h3>
                <p class="font_name">ID | &nbsp;<label class="content_font"><?php echo htmlspecialchars($user_info[$user_info['id_column']]); ?></label></p>
                <p class="font_name">NAME | &nbsp;<label class="content_font"><?php echo htmlspecialchars($user_info[$user_info['name_column']]); ?></label> </p>
                <p class="font_name">PHONE |&nbsp;<label class="content_font"><?php echo htmlspecialchars($user_info[$user_info['mobile_column']]); ?></label></p>
                <div class="join1"><a href="join_select.html">개인정보수정</a></div>
                <div class="btn-area1">
                    <form action="login.php" method="get">
                        <input type="hidden" name="logout" value="1">
                        <button class="btn" type="submit">LOGOUT</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="second_page">
        <img src="jpg/second.jpg" class="second_img">
    </div>
    <div class="outline1">
        <img src="jpg/1outline.jpg" width="500px">
        <img src="jpg/1btn.jpg" width="300px" class="btn1">
    </div>
    <div class="outline2">
        <img src="jpg/2outline.jpg" width="500px">
        <img src="jpg/2btn.jpg" width="300px" class="btn2">
    </div>
    <div class="outline3">
        <img src="jpg/3outline.jpg" width="500px">
        <img src="jpg/3btn.jpg" width="300px" class="btn3">
    </div>
    <br><br><br><br><br><br><br><br>
    <footer>
        <div class="container">
            <img src="jpg/footerimg.jpg" width="100%" class="footimg">
            <div class="contact"></div>
        </div>
    </footer>
</BODY>
</HTML>
