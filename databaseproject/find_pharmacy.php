

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="css/style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Do+Hyeon&display=swap" rel="stylesheet">
    <title>IBK CENTER</title>
    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=70ab7cbd67d92a1dbb0af5041b49ffd8&libraries=services"></script>
    <style>
        #container {
            display: flex;
        }
        #map {
            width: 890px;
            height: 600px;
            left: 50px;
            position: absolute;
            margin-top : 120px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            border: 1px solid #ccc;
        }
        #results {
            position: absolute;
            right: 40px;
            width: 850px;
            height: 630px;
            margin-top : 51px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            overflow-y: auto;
            padding: 20px;
            z-index: 10;
            border: 1px solid #ccc;
            font-family: 'Do Hyeon', sans-serif;
            border-radius: 5px;
        }

        #search-bar {
            margin-bottom: 10px;
        }
        #searchBox {
            position: absolute;
            margin-top: 47px;
            left: 50px;
            width: 870px;
            height: 40px;
            display: flex;
            align-items: center;
            background: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            z-index: 10;
        }
        #keyword {
            width: 900px;
            height: 30px;
            padding: 5px;
            font-size: 16px;
            border: 1px solid #ddd;
            margin-right: 5px;
        }

        body, ul, li {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .center-image {
            float: left;
            display: block;
            margin-left: 20px;
            margin-top: 10px;
            width: 23%;
        }

        .con-min-width {
            width: 1185px;
            padding: 35px;
            text-align: center;
        }

        .con {
            width: 920px;
            margin-left: 80%;
            margin-top: 12px;
            margin-right: auto;
        } 

        .menu-bar_box1 > ul > li {
            display: inline-block;
        }

        .menu-bar_box1 > ul > li > a {
            display: block;
            font-family: "고딕체";
            font-size: 21px;
            padding: 24px 40px;
        }

        .menu-bar_box1 > ul {
            text-align: center;
        }

        .hr_style {
            border: 3px solid #C6E2EE;
            margin-top: -3%;
        }
        
        .font {
            font-size: 20px;
        }

        .highlight {
            font-size: 32px;
            width : 50%;
            margin-top : -60px;
            position : absolute;
            margin-left : 70px;
        }

        .no-results {
            color: grey;
            font-weight: bold;
            font-size: 30px;
            position: absolute;
            top: 520px;
            right: 222px;
            z-index: 15;
        }
        .resultbox{
            margin-top: 5px;
            background: rgba(255, 255, 255, 0.8);
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            z-index: 10;
        }

    </style>

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
    </header>

    <div id="searchBox">
        <input type="text" id="keyword" placeholder="약국 검색">
        <button onclick="searchPlaces()"><img src="jpg/searchlogo.png" height="35px" width="35px"></button>
    </div>
    <div id="container">
        <div id="map"></div>
        <div id="results"></div>
        <div id="no-results" class="no-results">검색창을 이용하시면 정보가 나옵니다.</div>
    </div>

    <script>
        var mapContainer = document.getElementById('map'),
            mapOption = {
                center: new kakao.maps.LatLng(37.5665, 126.9780), // 서울시청 좌표
                level: 5
            };

        var map = new kakao.maps.Map(mapContainer, mapOption);
        var markers = [];
        var geocoder = new kakao.maps.services.Geocoder();

        function clearMarkers() {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            markers = [];
        }
search
        function formatTime(time) {
            if (time === '정보없음') return time;
            let formattedTime = time.replace(/(\d{1,2})(\d{2})/, "$1:$2");
            return formattedTime;
        }

        function displayResults(data) {
            var resultsContainer = document.getElementById('results');
            resultsContainer.innerHTML = '';

            if (data.length === 0) {
                document.getElementById('no-results').style.display = 'block';
            } else {
                document.getElementById('no-results').style.display = 'none';
            }

            data.forEach((place, index) => {
                var startTimeMonday = formatTime(place.start_time_monday || '정보없음');
                var endTimeMonday = formatTime(place.end_time_monday || '정보없음');
                var startTimeTuesday = formatTime(place.start_time_tuesday || '정보없음');
                var endTimeTuesday = formatTime(place.end_time_tuesday || '정보없음');
                var startTimeWednesday = formatTime(place.start_time_wednesday || '정보없음');
                var endTimeWednesday = formatTime(place.end_time_wednesday || '정보없음');
                var startTimeThursday = formatTime(place.start_time_thursday || '정보없음');
                var endTimeThursday = formatTime(place.end_time_thursday || '정보없음');
                var startTimeFriday = formatTime(place.start_time_friday || '정보없음');
                var endTimeFriday = formatTime(place.end_time_friday || '정보없음');
                var startTimeSaturday = formatTime(place.start_time_saturday || '정보없음');
                var endTimeSaturday = formatTime(place.end_time_saturday || '정보없음');

                if (place.name) {  // null 값 검증
                    var div = document.createElement('div');
                    div.className = 'font';
                    div.innerHTML = `<div class="resultbox">
                                    <img src="jpg/pharmacylogo.jpg" width="70px" height="70px"> 
                                    <div class="highlight">&nbsp;${place.name}</div><br><br>
                                    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp주소 | (${place.post_code || '정보없음'}) ${place.address || '정보없음'}<br><br><br>
                                    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp전화번호 | ${place.tel || '정보없음'}<br><br><br>
                                    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp영업 시간 |<br>
                                   &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;[월요일] | ${startTimeMonday || '정보없음'} ~ ${endTimeMonday || '정보없음'}<br><br>
                                    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;[화요일] | ${startTimeTuesday || '정보없음'} ~ ${endTimeTuesday || '정보없음'}<br><br>
                                   &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;[수요일] | ${startTimeWednesday || '정보없음'} ~ ${endTimeWednesday || '정보없음'}<br><br>
                                    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;[목요일] | ${startTimeThursday || '정보없음'} ~ ${endTimeThursday || '정보없음'}<br><br>
                                    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;[금요일] | ${startTimeFriday || '정보없음'} ~ ${endTimeFriday || '정보없음'}<br><br>
                                    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;[토요일] | ${startTimeSaturday || '정보없음'} ~ ${endTimeSaturday || '정보없음'}<br><br><br>
                                    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp공휴일 휴무 | ${place.holiday || '정보없음'}<br><br>
                                    </div>`;

                    // 첫 번째 약국의 위치로 지도 중심 이동 및 마커 표시
                    geocoder.addressSearch(place.address, function(result, status) {
                        if (status === kakao.maps.services.Status.OK) {
                            var markerPosition = new kakao.maps.LatLng(result[0].y, result[0].x);
                            if (index === 0) {
                                map.setCenter(markerPosition);
                            }
                            var markerImage = new kakao.maps.MarkerImage('jpg/hos marker.png', new kakao.maps.Size(70, 70));
                            var marker = new kakao.maps.Marker({
                                position: markerPosition,
                                image: markerImage
                            });
                            marker.setMap(map);
                            markers.push(marker);

                            // 마커 클릭 이벤트 추가
                            kakao.maps.event.addListener(marker, 'click', function() {
                                resultsContainer.innerHTML = ''; // 결과 초기화
                                resultsContainer.appendChild(div); // 클릭된 약국 정보 표시
                            });
                        } else {
                            console.error('Geocode was not successful for the following reason: ' + status);
                        }
                    });

                    // 클릭 시 지도 중심 이동
                    div.querySelector('.highlight').onclick = function() {
                        geocoder.addressSearch(place.address, function(result, status) {
                            if (status === kakao.maps.services.Status.OK) {
                                var markerPosition = new kakao.maps.LatLng(result[0].y, result[0].x);
                                map.setCenter(markerPosition);
                                clearMarkers();  // 이전 마커 제거
                                var markerImage = new kakao.maps.MarkerImage('jpg/hos marker.png', new kakao.maps.Size(70, 70));
                                var marker = new kakao.maps.Marker({
                                    position: markerPosition,
                                    image: markerImage
                                });
                                marker.setMap(map);
                                markers.push(marker);

                                // 마커 클릭 이벤트 추가
                                kakao.maps.event.addListener(marker, 'click', function() {
                                    resultsContainer.innerHTML = ''; // 결과 초기화
                                    resultsContainer.appendChild(div); // 클릭된 약국 정보 표시
                                });
                            } else {
                                console.error('Geocode was not successful for the following reason: ' + status);
                            }
                        });
                    };

                    resultsContainer.appendChild(div);
                }
            });
        }

        function searchPlaces() {
            var keyword = document.getElementById('keyword').value;

            if (!keyword.trim()) {
                alert('약국 이름을 입력하세요!');
                return;
            }

            console.log('검색어:', keyword);

            fetch('search1.php?keyword=' + encodeURIComponent(keyword))
                .then(response => response.json())
                .then(data => {
                    console.log('검색 결과:', data);
                    clearMarkers();
                    displayResults(data);
                })
                .catch(error => console.error('Error fetching data:', error));
        }
    </script>
</body>
</html>
