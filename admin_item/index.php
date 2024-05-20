<?php
// env.php を読み込み
require_once '../env.php';

// lib/DB.php を読み込み
require_once '../lib/DB.php';

// DBに接続する
$db = new DB();

// items テーブルから商品をすべて取得するSQL
$sql = "SELECT * FROM items;";
$stmt = $db->pdo->prepare($sql);
// SQL実行
$stmt->execute();

// PHPで処理できる商品の配列作成
//$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
$items = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $items[] = $row;
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h2 class="h2">商品⼀覧</h2>
        <table class="table">
            <thead>
                <tr>
                    <th><a class="btn btn-outline-primary" href="input.php">新規</a></th>
                    <th>コード</th>
                    <th>商品名</th>
                    <th>価格</th>
                    <th>在庫数</th>
                    <th>更新⽇</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($items): ?>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><a class="btn btn-sm btn-outline-primary" href="edit.php?id=<?= $item['id'] ?>">編集</a></td>
                        <td><?= $item['code'] ?></td>
                        <td><?= $item['name'] ?></td>
                        <td><?= $item['price'] ?></td>
                        <td><?= $item['stock'] ?></td>
                        <td><?= $item['updated_at'] ?></td>
                    </tr>
                <?php endforeach ?>
                <?php endif ?>
            </tbody>
        </table>
    </div>
</body>

</html>