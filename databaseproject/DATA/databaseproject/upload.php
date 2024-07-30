<!DOCTYPE HTML>
<HTML>
    <HEAD>
        <meta charset="utf-8">
        <link href = "css/style.css" rel = "stylesheet">
        <link href = "css/testcheck.css?after" rel = "stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Do+Hyeon&display=swap" rel="stylesheet">
        
        <title>IBK CENTER</title>
        
        </style>
    </HEAD>

    <BODY>
        <header>
        <img src = "jpg/real logo.png" class = "center-image">
        
        <h2 class = "con-min-width">
            <div class = "con">
                <nav class = "menu-bar_box1">
                    <ul>
                        <li><a href ="find_hospital.html" class = "block">병원찾기</a></li>
                        <li><a href ="#" class = "block">약국찾기</a></li>
                        <li class = "tem"><a href ="#" class = "block">정보조회</a></li>
                        <li><a href ="#" class = "block">방문후기</a></li>
                        <li><a href ="#" class = "block">개인정보수정</a></li>
                    </ul>
                </nav>  
            </div>
        </h2>
        <hr class = "hr_style">
        </header>
        <div class = "join_font">정보 업로드</div>
        <div class = "layout">
            <p class = "input_font1">환자 이름 &nbsp; &nbsp;| &nbsp; &nbsp; 임회연</p><br><br>

            <p class = "input_font2">환자 주민등록번호 &nbsp; &nbsp;| &nbsp; &nbsp; 020305-1234567</p>

            <p class = "input_font3">환자 전화번호 &nbsp; &nbsp;| &nbsp; &nbsp; 010-5485-4583</p>

            <div class = "upload">
                <label class = "label" for = "input">
                    <div class="upload_file" id = "drop_zone">
                    <img src ="jpg/upload.png" class ="upload_img">
                    <div class ="upload_font" id = "upload_message">
                        <h3>Upload your files or click here!</h3></div>
                    </div>
                    <div class="file_list" id="file_list"></div>
                </label>
                
                <input type ="file" class = "file_upload" id = "input" accept=".pdf,image/*" required = "true" multiple = "true" hidden="true" name = "h_file">
                <div class = "btn_img"><img src = "jpg/save_btn.jpg" width ="200" ></div>
            </div>
        </div>
    </BODY>
</HTML>

<script>
    const dropZone = document.getElementById('drop_zone');
    const fileInput = document.getElementById('input');
    const fileList = document.getElementById('file_list');
    const uploadMessage = document.getElementById('upload_message');

    dropZone.addEventListener('dragover', (event) => {
        event.preventDefault();
        dropZone.style.borderColor = '#000';
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.style.borderColor = '#d4d4d4';
    });

    dropZone.addEventListener('drop', (event) => {
        event.preventDefault();
        dropZone.style.borderColor = '#d4d4d4';
        const files = event.dataTransfer.files;
        handleFiles(files);
    });

    fileInput.addEventListener('change', () => {
        const files = fileInput.files;
        handleFiles(files);
    });

    function handleFiles(files) {
        fileList.style.display = 'none'; // Hide the file list
        uploadMessage.innerHTML = '';
        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const listItem = document.createElement('div');
            listItem.textContent = `File: ${file.name}`;
            // No need to append the list item to fileList

            // Display the file name in the upload message area
            if (i === 0) {
                uploadMessage.innerHTML = `<h3>${file.name}</h3>`;
            }
        }
    }
</script>
