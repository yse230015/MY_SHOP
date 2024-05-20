<?php
require_once '../env.php';
require_once '../lib/db.php';

// DB接続
$db = new DB();

// itemsテーブルからレコードを取得
$sql = "SELECT * FROM items;";
$stmt = $db->pdo->prepare($sql);
$stmt->execute();

$items = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $items[] = $row;
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
        <h2 class="p-2 text-center">商品一覧</h2>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php if ($items) : ?>
                <?php foreach ($items as $item) : ?>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= $item['name'] ?></h5>
                                <p class="card-text text-danger">&yen;<?= $item['price'] ?></p>
                                <a href="cart.php?item_id=<?= $item['id'] ?>" class="btn btn-primary">カートに入れる</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </main>
</body>

</html>