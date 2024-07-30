<?php
session_start();
?>

<!DOCTYPE HTML>
<HTML>
    <HEAD>
        <meta charset="utf-8">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/check_information.css" rel="stylesheet">
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
                        <li><a href="#" class="block">정보조회</a></li>
                        <li><a href="#" class="block">방문후기</a></li>
                        <li><a href="#" class="block">개인정보수정</a></li>
                    </ul>
                </nav>
            </div>
        </h2>
        <hr class="hr_style">
        </header>

        <div class="join_font">정보 조회 / 정보 업로드</div>
        <div class="layout">
            <div class="scrolly explain" tabindex="0">
                <br>
                <i>이 페이지는 병원 및 약국의 인증된 회원만 접근할 수 있습니다. <br>
                    환자의 개인 정보를 유출할 경우, 이는 심각한 법적 문제로 이어질 수 있으며, 관련 법규에 따라 엄격한 법적 제재를 받을 수 있습니다. <br>
                    환자의 민감한 정보를 보호하는 것은 매우 중요한 의무이므로, 정보 보안에 만전을 기해 주시기 바랍니다.
                    이러한 의무를 준수하지 않을 경우, 법적 책임을 져야 할 수 있음을 명심해 주시기 바랍니다.</i>
                    <br><br><br><br>
                    <h3>| 정보 조회 방법 (병원, 약국 회원 접근 가능) |</h3>
                    <p>환자의 이름과 주민등록 번호를 입력한 후 정보 조회 버튼을 클릭한다.<br>
                    환자의 이름, 주민등록번호, 전화번호, 키, 몸무게, 주소, 가지고 있는 지병, 자주 방문하는 병원의 이름과 주소, 환자 보호자의 이름, 관계, 보호자의 주민등록번호, 전화번호 등이 있으며
                    환자의 처방전이 있다.<br>
                    환자의 처방전에는 환자가 진료를 본 후에 업로드 된 것이며 처방전 부분이 공란이라면 이미 처방이 완료된 것이다.<br>
                    만일 공란이 아니고 환자가 직접 처방을 받으러 왔다면 약사는 처방 시 처방 완료 버튼을 클릭해야한다.<br>
                    처리 완료는 환자가 처방전을 남용하는 것을 방지하기 위함이다.<br>
                    </p>
                    <br><br>
                    <h3>| 정보 업로드 방법 (병원 회원만 접근 가능) |</h3>
                    <p>환자의 이름과 주민등록 번호를 입력한 후 정보 업로드 버튼을 클릭한다<br>
                    버튼을 클릭한 후에는 환자의 정보가 나오고 환자의 처방전을 업로드 할 수 있는 칸이 존재한다.<br>
                    환자의 정보를 처방전 칸에 업로드 한 후 저장하기 버튼을 누르면 후에 약사가 환자 정보 조회 시 환자의 처방전을 다운받고 처방할 수 있다<br>
                    정보 업로드 시 병원 회원만 할 수 있도록 구현되어있어 약사는 이 페이지를 접근하지 못한다.<br>
                    약사가 약을 처방할 수 없게하기 위함이다.
                    </p>
            </div>

            <form method="post" action="check_information.php">
                <p class="input_font1">환자 이름 &nbsp; &nbsp;| &nbsp; &nbsp;
                <input type="text" name="p_name" class="input_name"></p>
                <br><br><br><br>

                <p class="input_font2">환자 주민등록번호 &nbsp; &nbsp;| &nbsp; &nbsp;
                    <input type="text" name="p_idnumber[]" class="input_number"> - <input type="text" name="p_idnumber[]" class="input_number"></p>
                <input type="submit" id="submitBtn" style="display: none;" >

                <div class="upload_btn">
                    <a href="#" id="uploadLink"><img src="jpg/upload_btn.jpg" width="200" ></a>
                    <a href="search.html" id="imageLink"><img src="jpg/search_btn.jpg" width="200" ></a>
                </div>
            </form>
        </div>
    </BODY>
</HTML>

<script>
document.getElementById('imageLink').addEventListener('click', function(event) {
    event.preventDefault(); // 링크 기본 동작 막기
    document.getElementById('submitBtn').click(); // 숨겨진 서브밋 버튼 클릭
});

document.getElementById('uploadLink').addEventListener('click', function(event) {
    event.preventDefault(); // 링크 기본 동작 막기
    var pw = prompt("비밀번호를 입력하세요:");
    if (pw) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "verify_password.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                if (this.responseText === 'success') {
                    window.location.href = 'upload.php';
                } else {
                    alert('비밀번호가 일치하지 않습니다.');
                }
            }
        };
        xhr.send("password=" + encodeURIComponent(pw));
    }
});
</script>
