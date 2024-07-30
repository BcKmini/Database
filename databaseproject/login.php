<?php
session_start();
include 'db_conn.php'; // 데이터베이스 연결 설정 파일 포함

if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    session_unset(); // 세션 변수 삭제
    session_destroy(); // 세션 파괴
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // 관리자 로그인 처리
    $query_admin = "SELECT * FROM admin_tbl WHERE admin_id = '$username' AND admin_pw = '$password'";
    $result_admin = mysqli_query($conn, $query_admin);

    if ($result_admin && mysqli_num_rows($result_admin) > 0) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: admin.php');
        exit();
    }

    // 일반 사용자 로그인 처리
    $tables = [
        'personal_tbl' => ['id' => 'p_id', 'pw' => 'p_pw', 'name' => 'p_name', 'mobile' => 'p_mobile'],
        'hospital_tbl' => ['id' => 'h_id', 'pw' => 'h_pw', 'name' => 'h_name', 'mobile' => 'h_mobile', 'approved' => 'h_approved'],
        'pharmacy_tbl' => ['id' => 'ph_id', 'pw' => 'ph_pw', 'name' => 'ph_name', 'mobile' => 'ph_mobile', 'approved' => 'ph_approved']
    ];

    $user_info = null;
    $is_approved = true;
    $user_exists = false;

    foreach ($tables as $table => $columns) {
        $query = "SELECT * FROM $table WHERE {$columns['id']} = '$username' AND {$columns['pw']} = '$password'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_exists = true;
            $user_info = mysqli_fetch_assoc($result);
            if (isset($columns['approved']) && $user_info[$columns['approved']] == 0) {
                $is_approved = false;
                break;
            } else {
                $user_info['type'] = $table; // 사용자 유형 저장
                $user_info['id_column'] = $columns['id'];
                $user_info['name_column'] = $columns['name'];
                $user_info['mobile_column'] = $columns['mobile'];
                break;
            }
        }
    }

    if ($user_info && $is_approved) {
        $_SESSION['user_info'] = $user_info;
        $_SESSION['user_id'] = $user_info[$user_info['id_column']]; // 세션에 user_id 저장
        $_SESSION['user_type'] = $user_info['type']; // 세션에 user_type 저장
        header('Location: login.php'); // 로그인 성공 시 login.php 페이지로 이동
        exit();
    } else {
        if ($user_exists) {
            header('Location: index.php?error=2'); // 승인되지 않은 회원
        } else {
            header('Location: index.php?error=1'); // 회원정보가 없음
        }
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

    <style>
        .outline1, .outline2, .outline3 {
            transition: transform 0.3s ease-in-out; /* 부드러운 확대 효과를 위해 트랜지션 추가 */
        }

        .outline1:hover, .outline2:hover, .outline3:hover {
            transform: scale(1.1); /* 마우스가 올라갔을 때 확대 */
        }

        .join1 a {
        display: inline-block;
        text-decoration: none;
        color: rgb(164, 164, 164); /* 기본 텍스트 색상 */
        transition: transform 0.3s ease-in-out, color 0.3s ease-in-out; /* 트랜지션 추가 */
    }

        .join1 a:hover {
        color: #6799FF; /* 마우스 오버 시 텍스트 색상 */
        transform: scale(1.1); /* 마우스 오버 시 확대 */
    }

    .btn {
            transition: transform 0.3s ease-in-out; /* 버튼에 트랜지션 추가 */
        }

        .btn:hover {
            transform: scale(1.1); /* 버튼 클릭 시 확대 */
        }

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
    <?php
    if (!isset($_SESSION['user_info'])) {
        header('Location: index.php');
        exit();
    }
    ?>
    <header>
        <img src="jpg/real logo.png" class="center-image">
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
    <div>
        <img src="banner.jpg" class="banner-image">
        <div class="login_box">
            <?php if (isset($_SESSION['user_info'])): ?>
                <?php
                $user_info = $_SESSION['user_info'];
                $user_type_label = '';
                if ($user_info['type'] == 'personal_tbl') {
                    $user_type_label = '(개인)';
                } elseif ($user_info['type'] == 'hospital_tbl') {
                    $user_type_label = '(병원)';
                } elseif ($user_info['type'] == 'pharmacy_tbl') {
                    $user_type_label = '(약국)';
                }
                ?>
                <h3 class="login-font3">WELCOME</h3>
                <p class="font_name">ID | &nbsp;<label class="content_font"><?php echo htmlspecialchars($user_info[$user_info['id_column']]); ?></label></p>
                <p class="font_name">NAME | &nbsp;<label class="content_font"><?php echo htmlspecialchars($user_info[$user_info['name_column']] . ' ' . $user_type_label); ?></label> </p>
                <p class="font_name">PHONE |&nbsp;<label class="content_font"><?php echo htmlspecialchars($user_info[$user_info['mobile_column']]); ?></label></p>
                <div class="join1"><a href="access_rv.php">개인정보수정</a></div>
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
            <a href = "find_hospital.html"><img src="jpg/1btn.jpg" width="300px" class="btn1"></a>
        </div>

        <div class="outline2">
            <img src="jpg/2outline.jpg" width="500px">
            <a href = "find_pharmacy.php"><img src="jpg/2btn.jpg" width="300px" class="btn2"></a>
        </div>

        <div class="outline3">
            <img src="jpg/3outline.jpg" width="500px">
            <a href = "review.html"><img src="jpg/3btn.jpg" width="300px" class="btn3"></a>
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


