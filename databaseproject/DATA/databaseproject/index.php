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
                <h3 class="login-font">LOGIN</h3>
                <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                    <div class="secure"><p style="color: red;">🔏 회원정보가 없습니다.</p></div>
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
