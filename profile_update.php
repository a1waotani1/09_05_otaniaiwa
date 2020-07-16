<?php
session_start();
include("functions.php");
check_session_id();


$id = $_POST['id'];
$username = $_POST['username'];

$pdo = connect_to_db();

$sql = 'UPDATE users_table SET username=:username, updated_at=sysdate() WHERE id=:id';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    // 正常にSQLが実行された場合は一覧ページファイルに移動し，一覧ページの処理を実行する
    header("Location:profile.php");
    exit();
}


// if (isset($_POST['username'])) {
//     if ($stmt = $con->prepare("SELECT username FROM accounts WHERE username='$username'")); {
//         $stmt->execute();
//     }
//     $stmt->store_result();
//     if ($stmt->num_rows > 0) {
//         $stmt = $con->prepare("UPDATE accounts SET username='$newusername' WHERE id='$id'");
//         $status = $stmt->execute();
//     }
// } else {
//     echo 'error';
// }

// if ($status = false) {
//     echo 'error';
// } else {
//     header('Location: profile.php');
// }
