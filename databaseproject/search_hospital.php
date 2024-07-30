<?php
include("db_conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hospitalName = $_POST['hospital_name'];
    
    // 병원 이름으로 검색
    $sql = "SELECT address FROM hospital_data WHERE name = '$hospitalName'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $hospitalName);
    $stmt->execute();
    $stmt->bind_result($address);
    $stmt->fetch();
    
    $stmt->close();
    $conn->close();
    
    if ($address) {
        echo "<script>
                document.getElementById('roadAddress').value = '$address';
            </script>";
    } else {
        echo "<script>alert('해당 병원을 찾을 수 없습니다.');</script>";
    }
}
?>

<script>
    window.onload = function() {
        // 검색 결과를 다시 HTML 폼에 반영
        document.getElementById('roadAddress').value = "<?php echo $address; ?>";
    };
</script>


