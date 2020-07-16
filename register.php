<?php
include('functions.php');

// データ受け取り
$username = $_POST["username"];
$password = $_POST["password"];

$pdo = connect_to_db();

$sql = 'SELECT COUNT(*) FROM users_table WHERE username=:username';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
}

if ($stmt->fetchColumn() > 0) {
    // usernameが1件以上該当した場合はエラーを表示して元のページに戻る
    // $count = $stmt->fetchColumn();
    echo "<p>すでに登録されているユーザです．</p>";
    echo '<a href="index.html">login</a>';
    exit();
}

// ユーザ登録SQL作成
// `created_at`と`updated_at`には実行時の`sysdate()`関数を用いて実行時の日時を入力する
$sql = 'INSERT INTO users_table(id, username, password, is_admin, is_deleted, created_at, updated_at) VALUES(NULL, :username, :password, 0, 0, sysdate(), sysdate())';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
    header("Location:index.html");
    exit();
}


// $DATABASE_HOST = 'localhost';
// $DATABASE_USER = 'root';
// $DATABASE_PASS = '';
// $DATABASE_NAME = 'gsacf_d06_05';
// $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
// if (mysqli_connect_errno()) {
//     // DB接続に失敗した場合はここでエラーを出力し，以降の処理を中止する
//     exit('Failed to connect to MySQL: ' . mysqli_connect_error());
// }

// if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
//     exit('入力してください！');
// }
// //登録欄が空じゃないか確認する
// if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
//     //一つ以上の欄が空だったらメッセージを表示する
//     exit('登録欄を入力してください');
// }

// 同じユーザー名を持っているアカウントがあるか確認する
// if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
//     $stmt->bind_param('s', $_POST['username']);
//     $stmt->execute();
//     $stmt->store_result();
//     if ($stmt->num_rows > 0) {
//         //同じユーザー名のアカウントがあるなら
//         echo 'このユーザー名はもう存在します、違うユーザー名を選択してください';
//     } else {
//         // ユーザー名が存在しない場合
//         if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, activation_code) VALUES (?, ?, ?, ?)')) {
//             //データベースでパスワードを表示したくないので、hashを使う
//             $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
//             $uniqid = uniqid();
//             $stmt->bind_param('ssss', $_POST['username'], $password, $_POST['email'], $uniqid);
//             $stmt->execute();
//             $from    = 'noreply@yourdomain.com';
//             $subject = 'Account Activation Required';
//             $headers = 'From: ' . $from . "\r\n" . 'Reply-To: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion() . "\r\n" . 'MIME-Version: 1.0' . "\r\n" . 'Content-Type: text/html; charset=UTF-8' . "\r\n";
//             $activate_link = 'http://yourdomain.com/phplogin/activate.php?email=' . $_POST['email'] . '&code=' . $uniqid;
//             $message = '<p>Please click the following link to activate your account: <a href="' . $activate_link . '">' . $activate_link . '</a></p>';
//             mail($_POST['email'], $subject, $message, $headers);
//             echo 'Please check your email to activate your account!';
//         } else {
//             echo 'Could not prepare statement!';
//         }
//     }
//     $stmt->close();
// } else {

//     echo 'Could not prepare statement!';
// }
// $con->close();
