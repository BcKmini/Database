async function fetchPlacesData() {
    const response = await fetch('leegijungV2.json');
    const data = await response.json();
    const placesData = data.map(item => ({
        place_name: item.hospital_name,
        address_name: `${item.a} ${item.v} ${item.d} ${item.f}`,
        phone: "N/A", // 만약 전화번호 데이터가 있다면 여기에 추가하세요.
        y: item.pa,
        x: item.ap
    }));
    console.log(placesData);
    // 이후 placesData를 사용하여 원하는 작업을 수행하세요.
}

document.addEventListener('DOMContentLoaded', fetchPlacesData);

var map;
var markers = [];
var infowindow;

window.onload = function() {
    var container = document.getElementById('map');
    var options = {
        center: new kakao.maps.LatLng(37.566535, 126.9779692),
        level: 10
    };

    map = new kakao.maps.Map(container, options);
    infowindow = new kakao.maps.InfoWindow({zindex:1});

    // 지도에 표시
    displayPlaces(placesData);

    // Enter 키 이벤트 리스너 추가
    var searchInput = document.getElementById('search-input');
    searchInput.addEventListener('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            showResultsPanel();
        }
    });
};

function showResultsPanel() {
    var category = document.getElementById('category').value;
    var location = document.getElementById('location').value;
    var specialty = document.getElementById('specialty').value;
    if (!category) {
        alert("약국 또는 병원을 선택해주세요.");
        return;
    }
    if (!location) {
        alert("지역을 선택해주세요.");
        return;
    }
    var keyword = document.getElementById('search-input').value;
    searchPlaces(keyword, category, location, specialty);
}

function searchPlaces(keyword, category, location, specialty) {
    var placesService = new kakao.maps.services.Places();
    var query = location + " " + keyword + " " + category;
    if (specialty) {
        query += " " + specialty;
    }
    placesService.keywordSearch(query, function(result, status) {
        if (status === kakao.maps.services.Status.OK) {
            displayPlaces(result);
        } else if (status === kakao.maps.services.Status.ZERO_RESULT) {
            alert('검색 결과가 없습니다.');
        } else if (status === kakao.maps.services.Status.ERROR) {
            alert('검색 중 오류가 발생했습니다.');
        }
    });
}

function displayPlaces(places) {
    removeMarkers();
    var bounds = new kakao.maps.LatLngBounds();
    for (var i = 0; i < places.length; i++) {
        var place = places[i];
        var marker = new kakao.maps.Marker({
            map: map,
            position: new kakao.maps.LatLng(place.y, place.x),
            title: (i + 1).toString() // Adding marker number
        });
        markers.push(marker);
        bounds.extend(new kakao.maps.LatLng(place.y, place.x));

        // Add custom overlay for numbering
        var content = `<div style="padding:5px; background-color:white; border:1px solid black;">${i + 1}</div>`;
        var customOverlay = new kakao.maps.CustomOverlay({
            position: new kakao.maps.LatLng(place.y, place.x),
            content: content
        });
        customOverlay.setMap(map);

        (function(marker, place) {
            kakao.maps.event.addListener(marker, 'click', function() {
                displayInfo(place);
                openReviewForm(place);
            });
        })(marker, place);
    }
    map.setBounds(bounds);
    displayRelatedPlaces(places);
}

function displayInfo(place) {
    var content = '<div style="padding:10px; font-size:12px; display: flex; justify-content: center; align-items: center; flex-direction: column;">' +
                  '<b><a href="reviews.php?place=' + encodeURIComponent(place.place_name) + '">' + place.place_name + '</a></b><br>' +
                  place.address_name + '<br>' +
                  place.phone +
                  '</div>';
    infowindow.setContent(content);
    infowindow.open(map, new kakao.maps.Marker({
        position: new kakao.maps.LatLng(place.y, place.x)
    }));
}

function removeMarkers() {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
    }
    markers = [];
}

function openReviewForm(place) {
    var relatedPanel = document.getElementById('related-results-panel');
    relatedPanel.innerHTML = `
        <h3 style="display: flex; align-items: center;">
            <img src="hos logo.png" alt="${place.place_name}" style="margin-right: 5px; width: 1em; height: 1em;">
            ${place.place_name}
        </h3>
        <img src="back logo.png" alt="Back" class="back-button" onclick="goBack()">
       
        <form id="review-form-ui">
        <input type="hidden" id="modal-place-name" value="${place.place_name}">
        <label for="title">제목:</label><br>
        <input type="text" id="title" name="title"><br>
        <label for="author">이름:</label><br>
        <input type="text" id="author" name="author"><br>
        <label for="date">날짜:</label><br>
        <input type="date" id="date" name="date"><br>
        <label for="content">내용:</label><br>
        <textarea id="content" name="content" rows="4" cols="50"></textarea><br>
        <label for="rating">평점:</label><br>
        <div id="stars">
            <span class="star" data-value="1">★</span>
            <span class="star" data-value="2">★</span>
            <span class="star" data-value="3">★</span>
            <span class="star" data-value="4">★</span>
            <span class="star" data-value="5">★</span>
        </div>
        <input type="hidden" id="rating" name="rating" value="1">
        <button type="button" onclick="submitReview()">리뷰 제출</button>
    </form>
    `;
    document.querySelectorAll('.star').forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-value');
            document.getElementById('rating').value = rating;
            document.querySelectorAll('.star').forEach(s => {
                if (s.getAttribute('data-value') <= rating) {
                    s.classList.add('selected');
                } else {
                    s.classList.remove('selected');
                }
            });
        });
    });
}

function goBack() {
    var relatedPanel = document.getElementById('related-results-panel');
    relatedPanel.innerHTML = '';
    showResultsPanel();
}

function openReviewListForm(place, index) {
    var relatedPanel = document.getElementById('related-results-panel');
    relatedPanel.innerHTML = `
        <h3 style="display: flex; align-items: center;">
            <img src="hos logo.png" alt="${place.place_name}" style="margin-right: 5px; width: 1em; height: 1em;">
            ${place.place_name}
        </h3>
        <img src="back logo.png" alt="Back" class="back-button" onclick="goBack()">
        <div id="review-list">
            <div class="review-item">
                <div class="review-content">
                    <div class="review-header">
                        <span style="flex: 1; text-align: left;"><strong>순번</strong></span>
                        <span style="flex: 1; text-align: left;"><strong>제목</strong></span>
                        <span style="flex: 1; text-align: left;"><strong>작성자</strong></span>
                        <span style="flex: 1; text-align: left;"><strong>날짜</strong></span>
                        <span style="flex: 1; text-align: left;"><strong>평점</strong></span>
                    </div>
                    <div id="review-items" style="flex-direction: column;"></div> <!-- 리뷰 항목이 추가될 곳 -->
                    <div style="position: relative; height: 50px;">
                        <div class="button-container">
                            <button class="custom-button" onclick='openReviewForm(${JSON.stringify(place)})'>
                                <img src="write1 logo.png" alt="write1 logo.png" style="width: 24px; height: 24px;"> 글쓰기
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="pagination" style="text-align: center; margin-top: 20px;">
            <!-- 페이지 번호 동적으로 생성 -->
        </div>
    `;

    fetchReviews(place.place_name); // Fetch and display reviews for the selected place
}

function showPage(pageNumber) {
    currentPage = pageNumber;
    displayReviews();
}

function fetchReviews(place_name) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_reviews.php?place_name=' + encodeURIComponent(place_name), true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            reviews = JSON.parse(xhr.responseText);
            totalPages = Math.ceil(reviews.length / reviewsPerPage);
            displayPagination();
            displayReviews();
        }
    };
    xhr.send();
}

function displayPagination() {
    var pagination = document.getElementById('pagination');
    pagination.innerHTML = '';
    
    for (var i = 1; i <= 10; i++) {
        var pageNumber = document.createElement('span');
        pageNumber.className = 'page-number';
        pageNumber.innerText = i;
        pageNumber.style.marginRight = '5px'; // 페이지 번호 사이에 간격 추가
        pageNumber.onclick = function() {
            showPage(parseInt(this.innerText));
        };
        pagination.appendChild(pageNumber);
    }

    if (totalPages > 10) {
        var moreButton = document.createElement('button');
        moreButton.innerText = 'More';
        moreButton.style.marginLeft = '10px'; // 버튼과 페이지 번호 사이에 간격 추가
        moreButton.onclick = function() {
            displayRemainingPages();
        };
        pagination.appendChild(moreButton);
    }
}

function displayRemainingPages() {
    var pagination = document.getElementById('pagination');
    pagination.innerHTML = '';

    for (var i = 1; i <= totalPages; i++) {
        var pageNumber = document.createElement('span');
        pageNumber.className = 'page-number';
        pageNumber.innerText = i;
        pageNumber.style.marginRight = '5px'; // 페이지 번호 사이에 간격 추가
        pageNumber.onclick = function() {
            showPage(parseInt(this.innerText));
        };
        pagination.appendChild(pageNumber);
    }
}

function displayReviews() {
    var reviewItems = document.getElementById('review-items');
    reviewItems.innerHTML = '';
    var start = (currentPage - 1) * reviewsPerPage;
    var end = Math.min(start + reviewsPerPage, reviews.length);
    for (var i = start; i < end; i++) {
        var review = reviews[i];
        var reviewData = JSON.stringify(review).replace(/"/g, '&quot;');
        var reviewItem = document.createElement('div');
        reviewItem.className = 'review-item';
        reviewItem.innerHTML = `
            <div class="review-header" onclick="openReviewFormReadonly('${reviewData}')">
                <span style="flex: 1; text-align: left;"><strong>${i + 1}</strong></span>
                <span style="flex: 1; text-align: left;"><strong>${review.title}</strong></span>
                <span style="flex: 1; text-align: left;"><strong>${review.author}</strong></span>
                <span style="flex: 1; text-align: left;"><strong>${review.date}</strong></span>
                <span style="flex: 1; text-align: left;"><strong>${review.rating}</strong></span>
            </div>
        `;
        reviewItems.appendChild(reviewItem);
    }
}

var currentPage = 1;
var reviewsPerPage = 10;
var reviews = [];
var totalPages = 0;

function openReviewFormReadonly(reviewData) {
    var review = JSON.parse(reviewData.replace(/&quot;/g, '"')); // JSON 데이터를 다시 파싱

    var relatedPanel = document.getElementById('related-results-panel');
    relatedPanel.innerHTML = `
        <h3 style="display: flex; align-items: center;">
            <img src="hos logo.png" alt="${review.place_name}" style="margin-right: 5px; width: 1em; height: 1em;">
            ${review.place_name}
        </h3>
        <img src="back logo.png" alt="Back" class="back-button" onclick="goBack()">
       
        <form id="review-form-ui">
        <input type="hidden" id="modal-place-name" value="${review.place_name}">
        <label for="title">제목:</label><br>
        <input type="text" id="title" name="title" value="${review.title}" readonly><br>
        <label for="author">이름:</label><br>
        <input type="text" id="author" name="author" value="${review.author}" readonly><br>
        <label for="date">날짜:</label><br>
        <input type="date" id="date" name="date" value="${review.date}" readonly><br>
        <label for="content">내용:</label><br>
        <textarea id="content" name="content" rows="4" cols="50" readonly>${review.content}</textarea><br>
        <label for="rating">평점:</label><br>
        <div id="stars">
            ${getStarsHTML(review.rating)}
        </div>
        <input type="hidden" id="rating" name="rating" value="${review.rating}">
    </form>
    `;
}

function getStarsHTML(rating) {
    let starsHTML = '';
    for (let i = 1; i <= 5; i++) {
        starsHTML += `<span class="star ${i <= rating ? 'selected' : ''}" data-value="${i}">★</span>`;
    }
    return starsHTML;
}

function showReviews() {
    var reviewsList = document.getElementById('reviews-list');
    reviewsList.style.display = 'block';
    fetchReviews(); // PHP로부터 리뷰 목록 불러오기
}

function submitReview() {
    var place_name = document.getElementById('modal-place-name').value;
    var title = document.getElementById('title').value;
    var author = document.getElementById('author').value;
    var date = document.getElementById('date').value;
    var content = document.getElementById('content').value;
    var rating = document.getElementById('rating').value;

    if (!title.trim() || !author.trim() || !date.trim() || !content.trim() || !rating.trim()) {
        alert('모든 빈칸을 작성해주세요.');
        return;
    }

    // PHP로 값 전달
    document.getElementById('form-place-name').value = place_name;
    document.getElementById('form-title').value = title;
    document.getElementById('form-author').value = author;
    document.getElementById('form-date').value = date;
    document.getElementById('form-content').value = content;
    document.getElementById('form-rating').value = rating;

    document.getElementById('review-form').submit();
}

function displayRelatedPlaces(places) {
    var relatedPanel = document.getElementById('related-results-panel');
    relatedPanel.style.display = 'block';
    relatedPanel.innerHTML = ''; // Clear previous results

    places.forEach((place, index) => {
        var item = document.createElement('div');
        item.className = 'related-item';
        item.innerHTML = `
            <div>
                <h4 onclick='openReviewListForm(${JSON.stringify(place)}, ${index + 1})'>${index + 1}. ${place.place_name}</h4>
                <p>주소: ${place.address_name}</p>
                <p>전화번호: ${place.phone}</p>
            </div>
        `;
        relatedPanel.appendChild(item);
    });
}
