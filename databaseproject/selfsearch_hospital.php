<?php
include ("db_conn.php");

session_start();

$hospitalName = $_POST["hospitalName"];
echo($hospitalName);