<?php
// env.php を読み込み
require_once '../env.php';

// lib/DB.php を読み込み
require_once '../lib/DB.php';

// セッション開始
session_start();
session_regenerate_id(true);

// item_id パラメータがあればカート追加
if (isset($_GET['item_id'])) {
    // 商品IDの取得
    $item_id = intval($_GET['item_id']); // IDが整数であることを確認
    // カートに追加
    addCart($item_id);
}

// カートデータの取得
$cart_items = loadCartItems();

function addCart($item_id)
{
    // DBに接続する
    $db = new DB();

    // DBから items.id を使って商品の取得
    $sql = "SELECT * FROM items WHERE id = :id;";
    $stmt = $db->pdo->prepare($sql);
    $stmt->execute(['id' => $item_id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    // 商品があればセッションに登録
    if ($item) {
        if (!isset($_SESSION['my_shop']['cart_items'])) {
            $_SESSION['my_shop']['cart_items'] = [];
        }
        if (isset($_SESSION['my_shop']['cart_items'][$item_id])) {
            $_SESSION['my_shop']['cart_items'][$item_id]['quantity']++;
        } else {
            $_SESSION['my_shop']['cart_items'][$item_id] = $item;
            $_SESSION['my_shop']['cart_items'][$item_id]['quantity'] = 1;
        }
    }
}

function loadCartItems()
{
    if (!empty($_SESSION['my_shop']['cart_items'])) {
        return $_SESSION['my_shop']['cart_items'];
    }
    return [];
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ショッピングカート</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <main class="container">
        <h2 class="p-2 text-center">ショッピングカート</h2>

        <div>
            <a href="./">商品一覧</a>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php if ($cart_items) : ?>
                <?php 
                $total = 0;
                foreach ($cart_items as $cart_item) : 
                    $subtotal = $cart_item['price'] * $cart_item['quantity'];
                    $total += $subtotal;
                ?>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($cart_item['name']) ?></h5>
                                <p class="card-text">数量: <?= htmlspecialchars($cart_item['quantity']) ?></p>
                                <p class="card-text text-danger">価格: &yen;<?= htmlspecialchars($cart_item['price']) ?></p>
                                <p class="card-text text-danger">小計: &yen;<?= htmlspecialchars($subtotal) ?></p>
                                <p class="card-text">
                                    <a href="remove.php?item_id=<?= htmlspecialchars($cart_item['id']) ?>">削除</a>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">合計金額: &yen;<?= htmlspecialchars($total) ?></h5>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <p>カートに商品がありません。</p>
            <?php endif ?>
        </div>
    </main>
</body>

</html>