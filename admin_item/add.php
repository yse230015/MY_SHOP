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

// items テーブルにレコードを挿入するSQL
$sql = "INSERT INTO items (code, name, price, stock)
        VALUES (:code, :name, :price, :stock);
        ";

// データベースに登録
$stmt = $db->pdo->prepare($sql);

try {
    $stmt->execute($posts);
} catch (\Throwable $th) {
    // 予期せぬエラーの場合は、入力画面にリダイレクト
    header('Location: input.php');
    exit;
}

// 成功の場合は、一覧画面にリダイレクト
header('Location: ./');
?>
a
