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
//データからemailとパスワードを引き出す
$stmt = $con->prepare('SELECT password, email FROM accounts WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>プロフィールページ</title>
    <link href="stylesheet.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>

<body class="loggedin">
    <div class="header-img">
        <nav class="navtop">
            <div>
                <h1>travelist.</h1>
                <a href="profile.php"><i class="fas fa-user-circle"></i>プロフィール</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i>ログアウト</a>
            </div>
        </nav>
    </div>
    <div class="content">
        <h2>プロフィールページ</h2>
        <div>
            <p>アカウント情報は以下に記載されています:</p>
            <table>
                <tr>
                    <td>ユーザー名:</td>
                    <td><?= $_SESSION['name'] ?></td>
                </tr>
                <tr>
                    <td>パスワード:</td>
                    <td><?= $password ?></td>
                </tr>
                <tr>
                    <td>メールアドレス:</td>
                    <td><?= $email ?></td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>