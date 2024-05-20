<?php
// セッション開始
session_start();
session_regenerate_id(true);

if (!empty($_GET['item_id'])) {
    removeCartItem($_GET['item_id']);
}

// リダイレクト
header('Location: cart.php');

function removeCartItem($item_id)
{
    // もし指定の商品IDのセッションがあれば削除
    if (!empty($_SESSION['my_shop']['cart_items'][$item_id])) {
        unset($_SESSION['my_shop']['cart_items'][$item_id]);
    }
}