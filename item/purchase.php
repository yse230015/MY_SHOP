<?php
// env.php を読み込み
require_once '../env.php';

// lib/DB.php を読み込み
require_once '../lib/DB.php';

// セッション開始
session_start();
session_regenerate_id(true);

// POSTリクエストでなければ何も表示しない
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit;
}

// ユーザチェック
$user = loadUser();
if (!$user) {
    header('Location: ../login/');
    exit;
}

// 商品カート
$cart_items = loadCartItems();
if (!$cart_items) {
    header('Location: cart.php');
    exit;
}

// 購入
$errors = purchase($user, $cart_items);
if ($errors) {
    header('Location: cart.php');
    exit;
} else {
    header('Location: purchase_complete.php');
    exit;
}

function purchase($user, $cart_items)
{
    if (!$user) return;
    if (!$cart_items) return;

    // データベースに接続
    $db = new DB();

    foreach ($cart_items as $cart_item) {
        // SQLのデータ
        $data['user_id'] = $user['id'];
        $data['item_id'] = $cart_item['id'];
        $data['amount'] = 1;
        $data['total_price'] = $cart_item['price'] * 1;

        // items テーブルにレコードを挿入するSQL
        $sql = "INSERT INTO user_items 
            (user_id, item_id, amount, total_price)
            VALUES (:user_id, :item_id, :amount, :total_price);";

        // データベースに登録
        $stmt = $db->pdo->prepare($sql);
        $result = $stmt->execute($data);

        //TODO エラー
        if ($result !== true) {
            $errors['cart_item'] = "購入エラー";
        }
    }
    return $errors;
}

function loadCartItems()
{
    if (!empty($_SESSION['my_shop']['cart_items'])) {
        return $_SESSION['my_shop']['cart_items'];
    }
}

function loadUser()
{
    if (!empty($_SESSION['my_shop']['user'])) {
        return $_SESSION['my_shop']['user'];
    }
}