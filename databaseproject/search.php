<?php
header('Content-Type: application/json');

    $db_host = "localhost";
    $db_user = "IBKCenter";
    $db_password = "0305";
    $db_name = "loginibk";

    $conn = mysqli_connect($db_host, $db_user, $db_password,$db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve search parameters
$keyword = isset($_GET['keyword']) ? $conn->real_escape_string($_GET['keyword']) : '';
$category = isset($_GET['category']) ? $conn->real_escape_string($_GET['category']) : '';

// SQL query
$sql = "
    SELECT 
        d.name,
        d.post_code,
        d.address,
        d.tel,
        d.homepage,
        d.subject,
        d1.Start_Time_Sunday,
        d1.End_Time_Sunday,
        d1.Start_Time_Monday,
        d1.End_Time_Monday,
        d1.Start_Time_Tuesday,
        d1.End_Time_Tuesday,
        d1.Start_Time_Wednesday,
        d1.End_Time_Wednesday,
        d1.Start_Time_Thursday,
        d1.End_Time_Thursday,
        d1.Start_Time_Friday,
        d1.End_Time_Friday,
        d1.Start_Time_Saturday,
        d1.End_Time_Saturday,
        d1.Notice_Holiday,
        d1.Emergencynight
    FROM 
        hospital_data d
    INNER JOIN 
        data2 d1 ON d.name = d1.name
    WHERE 
        (d.name LIKE '%$keyword%' OR d.subject LIKE '%$keyword%')
        AND ('$category' = '' OR d.subject = '$category')
        AND d.name IS NOT NULL
        AND d.name <> ''
";

// Execute query
$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Skip if name is empty or 'null'
        if (empty($row['name']) || strtolower($row['name']) == 'null') {
            continue;
        }
        $data[] = $row;
    }
}

echo json_encode($data);

$conn->close();
?>