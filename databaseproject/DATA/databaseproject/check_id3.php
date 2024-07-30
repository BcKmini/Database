<?php
include("db_conn.php");

if(isset($_POST['ph_id'])) {
    $ph_id = $_POST['ph_id'];

    $queries = [
        "SELECT COUNT(*) FROM personal_tbl WHERE p_id = ?",
        "SELECT COUNT(*) FROM hospital_tbl WHERE h_id = ?",
        "SELECT COUNT(*) FROM pharmacy_tbl WHERE ph_id = ?"
    ];

    $isDuplicate = false;
    foreach ($queries as $query) {
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $ph_id);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        if ($count > 0) {
            $isDuplicate = true;
            break;
        }
        $stmt->close();
    }

    echo json_encode(['isDuplicate' => $isDuplicate]);
    $conn->close();
}
?>
