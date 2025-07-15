<?php
$db_hostname = '';
$db_username = '';
$db_password = '';
$db_database = '';

try {
    $conn = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);
} catch (mysqli_sql_exception) {
    echo "connection failed";
}
