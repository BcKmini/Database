<?php
include("db_conn.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];

    
    
    // SQL 쿼리 생성
    $sql = "SELECT address FROM hospital_data WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $stmt->bind_result($address);
    $stmt->fetch();

    // 결과를 텍스트 형식으로 반환
    if ($address) {
        echo $address;
    } else {
        echo '';
    }

    // 연결 종료
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Address</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <form id="searchForm">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <input type="submit" value="Search">
    </form>
    <form>
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" readonly>
    </form>

    <script>
        $(document).ready(function() {
            $('#searchForm').on('button', function(e) {
                e.preventDefault();
                var name = $('#name').val();

                $.ajax({
                    url: 'search.php',
                    type: 'POST',
                    data: {name: name},
                    success: function(response) {
                        if (response) {
                            $('#address').val(response);
                        } else {
                            $('#address').val('No address found');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
