<?php
session_start();
//ユーザーがログインされてなかったらログインページへ戻す
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.html');
    exit;
}

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'gsacf_d06_05';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$id = $_SESSION['id'];
$username = $_SESSION['name'];
$newusername = $_POST['newusername'];


if (isset($_POST['username'])) {
    if ($stmt = $con->prepare("SELECT username FROM accounts WHERE username='$username'")); {
        $stmt->execute();
    }
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt = $con->prepare("UPDATE accounts SET username='$newusername' WHERE id='$id'");
        $status = $stmt->execute();
    }
} else {
    echo 'error';
}

if ($status = false) {
    echo 'error';
} else {
    header('Location: profile.php');
}
