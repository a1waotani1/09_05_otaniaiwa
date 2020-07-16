<?php
// var_dump($_POST);
// exit();
session_start();
include("functions.php");

$pdo = connect_to_db();

$username = $_POST['username'];
$password = $_POST['password'];

$sql = 'SELECT * FROM users_table WHERE username=:username AND password=:password AND is_deleted=0';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$status = $stmt->execute();

// SQL実行時にエラーがある場合
if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
}

$val = $stmt->fetch(PDO::FETCH_ASSOC);

// ユーザ情報が取得できない場合はメッセージを表示
if (!$val) {
    echo "<p>ログイン情報に誤りがあります．</p>";
    echo '<a href="index.html">login</a>';
    exit();
} else {
    $_SESSION = array();
    $_SESSION["session_id"] = session_id();
    $_SESSION["is_admin"] = $val["is_admin"];
    $_SESSION["username"] = $val["username"];
    $_SESSION["id"] = $val["id"];
    header("Location: home.php");
    exit();
}

// データ登録SQL作成
// if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
//     // データ登録SQL作成
//     $stmt->bind_param('s', $_POST['username']);
//     $stmt->execute();
//     //SQLのデータ結果を保存！
//     $stmt->store_result();
//     if ($stmt->num_rows > 0) {
//         $stmt->bind_result($id, $password);
//         $stmt->fetch();
//         //アカウントが登録されていてパスワードの認証を得る！
//         if (password_verify($_POST['password'], $password)) {
//             //認証確認完了！ログインが実行される！
//             //セッションを作成する
//             session_regenerate_id();
//             $_SESSION['loggedin'] = TRUE;
//             $_SESSION['name'] = $_POST['username'];
//             $_SESSION['id'] = $id;
//             header('Location: home.php');
//         } else {
//             echo '間違ったパスワード';
//         }
//     } else {
//         echo '間違ったユーザー名';
//     }

//     $stmt->close();
// }
