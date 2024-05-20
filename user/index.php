<?php
// セッション開始
session_start();
session_regenerate_id(true);

// セッションからユーザを取得
$user = $_SESSION['my_shop']['user'];

//ユーザがログイン済みでなければ（セッションにユーザデータがない）ログインにリダイレクト
if (!$user) {
    header('Location: ../login/');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h2>User Home</h2>
        <nav class="mb-3">
            <a class="" href="../item/cart.php">ショッピングカート</a>
            |
            <a class="" href="purchase_history.php">購入履歴</a>
            |
            <a class="" href="logout.php">ログアウト</a>
        </nav>
        <div class="mt-3">
            <p><?= $user['name'] ?>さん、ようこそ</p>
        </div>
    </div>
</body>

</html>