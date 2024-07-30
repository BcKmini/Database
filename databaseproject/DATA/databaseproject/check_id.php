<?php
include("db_conn.php");

if(isset($_POST['p_id'])) {
    $p_id = $_POST['p_id'];

    $queries = [
        "SELECT COUNT(*) FROM personal_tbl WHERE p_id = '$p_id'",
        "SELECT COUNT(*) FROM hospital_tbl WHERE h_id = '$p_id'",
        "SELECT COUNT(*) FROM pharmacy_tbl WHERE ph_id = '$p_id'"
    ];

    $isDuplicate = false;
    foreach ($queries as $query) {
        $result = $conn->query($query);
        $count = $result->fetch_row()[0];
        if ($count > 0) {
            $isDuplicate = true;
            break;
        }
    }

    echo json_encode(['isDuplicate' => $isDuplicate]);
}
?>
