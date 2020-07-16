<?php
// var_dump($_GET);
// exit();

include('functions.php');

$user_id = $_GET['user_id'];
$follower_id = $_GET['follower_id'];

$pdo = connect_to_db();

$sql = 'SELECT COUNT(*) FROM followers_table WHERE user_id=:user_id AND follower_id=:follower_id';
// $sql = 'INSERT INTO followers_table(id, user_id, follower_id, created_at)VALUES(NULL,:user_id, :follower_id, sysdate())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':follower_id', $follower_id, PDO::PARAM_INT);
$status = $stmt->execute();


if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    $follower_count = $stmt->fetch();
    // var_dump($follower_count[0]);
    // exit();

    if ($follower_count[0] != 0) {
        $sql = 'DELETE FROM followers_table WHERE user_id=:user_id AND follower_id=:follower_id';
    } else {
        $sql = 'INSERT INTO followers_table(id, user_id, follower_id, created_at)VALUES(NULL, :user_id, :follower_id, sysdate())';
    }

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':follower_id', $follower_id, PDO::PARAM_INT);
    $status = $stmt->execute();

    // データ登録処理後
    if ($status == false) {
        // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
        $error = $stmt->errorInfo();
        echo json_encode(["error_msg" => "{$error[2]}"]);
        exit();
    } else {
        // 正常にSQLが実行された場合は一覧ページファイルに移動し，一覧ページの処理を実行する
        header("Location:home.php");
        exit();
    }
}
