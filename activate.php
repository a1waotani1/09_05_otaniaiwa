<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'gsacf_d06_05';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
    // DB接続に失敗した場合はここでエラーを出力し，以降の処理を中止する
    exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
//emailと認証コードがもう存在するかを確認する
if (isset($_GET['email'], $_GET['code'])) {
    if ($stmt = $con->prepare('SELECT * FROM accounts WHERE email = ? AND activation_code = ?')) {
        $stmt->bind_param('ss', $_GET['email'], $_GET['code']);
        $stmt->execute();
        //結果をデータベースに保存する
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            // e-mail と認証コードを持ってるアカウのとが存在する
            if ($stmt = $con->prepare('UPDATE accounts SET activation_code = ? WHERE email = ? AND activation_code = ?')) {
                //新しい認証コードをactivatedに帰る
                $newcode = 'activated';
                $stmt->bind_param('sss', $newcode, $_GET['email'], $_GET['code']);
                $stmt->execute();
                echo 'Your account is now activated, you can now login!<br><a href="index.html">Login</a>';
            }
        } else {
            echo 'The account is already activated or doesn\'t exist!';
        }
    }
}
if ($account['activation_code'] == 'activated') {
    // アカウントが確認できたらホームページへ移動する
} else {
    //アカウントが確認できなかったらエラーを表示する
}
