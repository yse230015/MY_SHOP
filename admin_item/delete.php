<?php 
// env.php を読み込み
require_once '../env.php';

// lib/DB.php を読み込み
require_once '../lib/DB.php';

// POSTリクエストでなければ何も表示しない
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit;
}

// データベースに接続
$db = new DB();
// POSTデータ取得（サニタイズ）
$posts = $db->sanitize($_POST);

// items テーブルに指定したIDでレコードを削除するSQL
$sql = "DELETE FROM items WHERE id = :id;";

// データベースに登録
$stmt = $db->pdo->prepare($sql);
$stmt->execute($posts);

// 成功の場合は、一覧画面にリダイレクト
header('Location: ./');
?>