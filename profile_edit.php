<?php
session_start();
include("functions.php");
check_session_id();
$id = $_GET["id"];

$pdo = connect_to_db();
$sql = 'SELECT * FROM users_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    // 正常にSQLが実行された場合は指定の11レコードを取得
    // fetch()関数でSQLで取得したレコードを取得できる
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>プロフィールページ（編集画面）</title>
    <link href="stylesheet.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>

<body class="loggedin">
    <div class="header-img">
        <nav class="navtop">
            <div>
                <h1>travelist.</h1>
                <a href="profile.php"><i class="fas fa-user-circle"></i>プロフィール</a>
                <a href="#"><i class="fas fa-plus-circle"></i></i>アップロード</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i>ログアウト</a>
            </div>
        </nav>
    </div>
    <div class="content">
        <h2>プロフィールページ（編集画面）</h2>
        <div>
            <p>アカウント情報は以下に記載されています:</p>
            <form action="profile_update.php" method="POST">
                <table>

                    <tr>
                        <td>新しいユーザー名:</td>
                        <td><input type="text" name="username" value="<?= $_SESSION['username'] ?>"></td>
                    </tr>
                    <tr>
                        <td>パスワード:</td>
                        <td><?= $password ?></td>
                    </tr>
                    <tr>
                        <td>メールアドレス:</td>
                        <td><?= $email ?></td>
                    </tr>
                    <tr>
                        <td><input type="submit" id="submit2" value="保存する"></td>
                    </tr>
                    <input type="hidden" name="id" value="<?= $_SESSION['id'] ?>">
                </table>
            </form>
        </div>
    </div>
    </div>
</body>

</html>