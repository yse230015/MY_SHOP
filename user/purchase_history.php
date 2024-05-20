<?php
require_once '../env.php';
require_once '../lib/db.php';

// セッション開始
session_start();
session_regenerate_id(true);

// ユーザ取得
$user = loadUser();

if (!$user) {
    header('Location: ../login/');
    exit;
}

// DB接続
$db = new DB();

// itemsテーブルからレコードを取得
$sql = "SELECT user_items.*, items.* FROM user_items 
    JOIN items
    ON user_items.item_id = items.id
    WHERE user_items.user_id = :user_id;";

$stmt = $db->pdo->prepare($sql);
$stmt->execute(['user_id' => $user['id']]);

$user_items = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $user_items[] = $row;
}

function loadUser()
{
    if (!empty($_SESSION['my_shop']['user'])) {
        return $_SESSION['my_shop']['user'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>


<body>
    <main class="container">
        <h2 class="p-2 text-center">購入履歴</h2>

        <nav class="mb-3">
            <a class="" href="../item/cart.php">ショッピングカート</a>
            |
            <a class="" href="purchase_history.php">購入履歴</a>
            |
            <a class="" href="logout.php">ログアウト</a>
        </nav>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php if ($user_items) : ?>
                <?php foreach ($user_items as $user_item) : ?>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <p class="card-text text-mute"><?= $user_item['created_at'] ?></p>
                                <h5 class="card-title"><?= $user_item['name'] ?></h5>
                                <p class="card-text">
                                    <span>&yen;<?= $user_item['price'] ?></span>
                                    <span><?= $user_item['amount'] ?>個</span>
                                </p>
                                <p class="card-text">
                                    <span class="fw-bold">小計</span>
                                    <span>&yen;<?= $user_item['total_price'] ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </main>
</body>

</html>