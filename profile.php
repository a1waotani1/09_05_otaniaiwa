<?php
session_start();
include("functions.php");
check_session_id();

$user_id = $_SESSION['id'];
$pdo = connect_to_db();
//ユーザーがログインされてなかったらログインページへ戻す

//データからemailとパスワードを引き出す
// $sql = 'SELECT * FROM users_table';
$sql = 'SELECT * FROM users_table LEFT OUTER JOIN (SELECT follower_id, COUNT(id) AS cnt FROM followers_table GROUP BY follower_id) AS follows
ON users_table.id = follows.follower_id';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
    // fetchAll()関数でSQLで取得したレコードを配列で取得できる
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $output = "";
    // <tr><td>deadline</td><td>todo</td><tr>の形になるようにforeachで順番に$outputへデータを追加
    // `.=`は後ろに文字列を追加する，の意味
    foreach ($result as $record) {
        $output .= "<tr>";
        $output .= "<td>FOLLOWERS{$record["cnt"]}</td >";
        // $output .= "<td><a href='like_create.php?user_id={$user_id}&todo_id={$record["id"]}'>like{$record["cnt"]}</a></td >";
    }
    // $valueの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
    // 今回は以降foreachしないので影響なし
    unset($value);
}
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
                <a href="upload.php"><i class="fas fa-plus-circle"></i></i>アップロード</a>
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
                    <td><?= $_SESSION['username'] ?></td>
                    <td><a href='profile_edit.php?id=<?= $_SESSION['id'] ?>'><button id="edit_username">EDIT USERNAME</button></a></td>
                </tr>
                <tr>
                    <td>フォロワー:</td>
                    <td><?= $output ?></td>
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