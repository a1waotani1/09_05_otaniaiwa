<?php
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'gsacf_d06_05';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // DB接続に失敗した場合はここでエラーを出力し，以降の処理を中止する
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
//データをちゃんと入力してるか確認！
if (!isset($_POST['username'], $_POST['password'])) {
    // もし確認できなかったら〜 :(
    exit('ユーザー名とパスワードを入力してくだいさい！');
}
// データ登録SQL作成
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
    // データ登録SQL作成
    $stmt->bind_param('s', $_POST['username']);
    $stmt->execute();
    //SQLのデータ結果を保存！
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        //アカウントが登録されていてパスワードの認証を得る！
        if (password_verify($_POST['password'], $password)) {
            //認証確認完了！ログインが実行される！
            //セッションを作成する
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            header('Location: home.php');
        } else {
            echo '間違ったパスワード';
        }
    } else {
        echo '間違ったユーザー名';
    }

    $stmt->close();
}
