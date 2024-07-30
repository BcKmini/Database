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

        .join a {
            display: inline-block;
            text-decoration: none;
            color: rgb(164, 164, 164); /* 기본 텍스트 색상 */
            transition: transform 0.3s ease-in-out, color 0.3s ease-in-out; /* 트랜지션 추가 */
        }

        .join a:hover {
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
            <h3 class="login-font">LOGIN</h3>
            <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                <div class="secure">
                    <p style="color: red;">🔏 회원정보가 없습니다.</p>
                </div>
            <?php elseif (isset($_GET['error']) && $_GET['error'] == 2): ?>
                <div class="secure">
                    <p style="color: red;">🔏 승인되지 않은 회원입니다.</p>
                </div>
            <?php endif; ?>
            <form action="login.php" method="post">
                <div class="login-input">
                    <div class="input-box">
                        <input id="username" type="text" name="username" placeholder="UserID" required>
                        <label for="username"></label>
                    </div>

                    <div class="input-box">
                        <input id="password" type="password" name="password" placeholder="PW" required>
                        <label for="password"></label>
                    </div>

                    <div class="join"><a href="join_select.html">JOIN</a></div>
                    <div class="btn-area">
                        <button class="btn" type="submit">LOGIN</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="second_page">
        <img src="jpg/second.jpg" class="second_img">
    </div>

    <div class="outline1">
        <img src="jpg/1outline.jpg" width="500px">
        <a href="find_hospital.html"><img src="jpg/1btn.jpg" width="300px" class="btn1"></a>
    </div>

    <div class="outline2">
        <img src="jpg/2outline.jpg" width="500px">
        <a href="find_pharmacy.php"><img src="jpg/2btn.jpg" width="300px" class="btn2"></a>
    </div>

    <div class="outline3">
        <img src="jpg/3outline.jpg" width="500px">
        <a href="review.html"><img src="jpg/3btn.jpg" width="300px" class="btn3"></a>
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
