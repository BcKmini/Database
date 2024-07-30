<?php
session_start();
include 'db_conn.php'; // 데이터베이스 연결 설정 파일 포함

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['approve'])) {
    $userId = $_POST['user_id'];
    $userType = $_POST['user_type'];

    // 사용자 유형에 따라 테이블 및 열 이름 설정
    if ($userType == 'hospital') {
        $table = 'hospital_tbl';
        $idColumn = 'h_id';
        $approvedColumn = 'h_approved';
    } elseif ($userType == 'pharmacy') {
        $table = 'pharmacy_tbl';
        $idColumn = 'ph_id';
        $approvedColumn = 'ph_approved';
    } else {
        $table = '';
        $idColumn = '';
        $approvedColumn = '';
    }

    // 승인 업데이트 쿼리 실행
    if ($table && $idColumn && $approvedColumn) {
        $query = "UPDATE $table SET $approvedColumn = 1 WHERE $idColumn = '$userId'";
        mysqli_query($conn, $query);
    }
}

$query_hospitals = "SELECT * FROM hospital_tbl WHERE h_approved = 0";
$query_pharmacies = "SELECT * FROM pharmacy_tbl WHERE ph_approved = 0";

$result_hospitals = mysqli_query($conn, $query_hospitals);
$result_pharmacies = mysqli_query($conn, $query_pharmacies);
?>

<!DOCTYPE HTML>
<HTML>
<HEAD>
    <meta charset="utf-8">
    <link href="css/style.css?after" rel="stylesheet">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F4F6F9;
            margin: 0;
            padding: 0;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background-color: #007BFF;
            color: white;
        }

        header a {
            color: white;
            text-decoration: none;
            background-color: #DC3545;
            padding: 10px;
            border-radius: 5px;
        }

        h2{
            text-align: center;
            margin-top: 20px;
            color: #FFFFFF;
        }
        h3 {
            text-align: center;
            margin-top: 20px;
            color: #343A40;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #E9ECEF;
        }

        th {
            background-color: #007BFF;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #F8F9FA;
        }

        .btn {
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left : 8px;
            align-items: center;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .download-link {
            text-decoration: none;
            color: #007BFF;
        }

        .download-link:hover {
            text-decoration: underline;
        }
    </style>
</HEAD>
<BODY>
    <header>
        <h2>Admin Panel</h2>
        <a href="admin_logout.php">Logout</a>
    </header>
    <div>
        <h3>Hospital</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Type</th>
                <th>ID Number</th>
                <th>Working Name</th>
                <th>Working Address</th>
                <th>Approve</th>
                <th>Certificate</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result_hospitals)): ?>
                
            <tr>
                <td><?php echo $row['h_id']; ?></td>
                <td><?php echo $row['h_name']; ?></td>
                <td><?php echo $row['h_mobile']; ?></td>
                <td><?php echo $row['h_distingush']; ?></td>
                <td><?php echo $row['h_idnumber']; ?></td>
                <td><?php echo $row['h_workingname']; ?></td>
                <td><?php echo $row['h_workingaddress']; ?></td>
                <td>
                    <form method="post" action="admin.php">
                        <input type="hidden" name="user_id" value="<?php echo $row['h_id']; ?>">
                        <input type="hidden" name="user_type" value="hospital">
                        <button type="submit" name="approve" class="btn">Approve</button>
                    </form>
                </td>
                <td><a href="hospital_certification/<?php echo $row['h_file']; ?>" class="download-link" download>Download</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
<br><br><br><br><br><br><br><br><br><br><br>
        <h3>Pharmacy</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>ID Number</th>
                <th>Working Name</th>
                <th>Working Address</th>
                <th>Approve</th>
                <th>Certificate</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result_pharmacies)): ?>
            <tr>
                <td><?php echo $row['ph_id']; ?></td>
                <td><?php echo $row['ph_name']; ?></td>
                <td><?php echo $row['ph_mobile']; ?></td>
                <td><?php echo $row['ph_idnumber']; ?></td>
                <td><?php echo $row['ph_workingname']; ?></td>
                <td><?php echo $row['ph_workingaddress']; ?></td>
                <td>
                    <form method="post" action="admin.php">
                        <input type="hidden" name="user_id" value="<?php echo $row['ph_id']; ?>">
                        <input type="hidden" name="user_type" value="pharmacy">
                        <button type="submit" name="approve" class="btn">Approve</button>
                    </form>
                </td>
                <td><a href="pharmacy_certification/<?php echo $row['ph_file']; ?>" class="download-link" download>Download</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</BODY>
</HTML>
