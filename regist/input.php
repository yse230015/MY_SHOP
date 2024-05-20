<?php
// セッション開始
session_start();

//セッションが空でなければ、前回のデータ取得
if (!empty($_SESSION['my_shop']['regist'])) {
    $regist = $_SESSION['my_shop']['regist'];
}
if (!empty($_SESSION['my_shop']['errors'])) {
    $errors = $_SESSION['my_shop']['errors'];
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
    <main class="container">
        <h2 class="text-center p-3">会員登録</h2>
        <!-- form request confirm.php にデータをPOST送信-->
        <form action="confirm.php" method="post">
            <div>
                <label class="form-label" for="">名前</label>
                <input class="form-control" type="text" name="name" value="<?= @$regist['name'] ?>">
                <label for="" class="text-danger"><?= @$errors['name'] ?></label>
            </div>

            <div>
                <label class="form-label" for="">Email</label>
                <input class="form-control" type="email" name="email" value="<?= @$regist['email'] ?>">
                <label for="" class="text-danger"><?= @$errors['email'] ?></label>
            </div>

            <div>
                <label class="form-label" for="">パスワード</label>
                <input class="form-control" type="password" name="password">
                <label for="" class="text-danger"><?= @$errors['password'] ?></label>
            </div>

            <div class="mt-3 text-center">
                <button class="btn btn-primary">次へ</button>
                <a class="btn btn-outline-primary" href="../login/">ログイン画面へ</a>
            </div>
        </form>
    </main>
</body>

</html>