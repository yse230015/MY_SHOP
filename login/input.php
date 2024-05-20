<?php
//TODO: エラーメッセージ
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
    <main class="m-auto w-50">
        <h2 class="p-2 text-center">ログイン</h2>
        <form action="auth.php" method="post">
            <div class="form-floating mt-3">
                <input class="form-control" type="text" name="email" value="<?= @$member['email'] ?>">
                <label class="form-label" for="">Email</label>
                <p class="text-danger"><?= @$errors["email"] ?></p>
            </div>

            <div class="form-floating mt-3">
                <input class="form-control" type="password" name="password" value="<?= @$member['password'] ?>">
                <label class="form-label" for="">パスワード</label>
                <p class="text-danger"><?= @$errors["password"] ?></p>
            </div>

            <div class="text-center mt-3">
                <button class="btn btn-primary w-100 me-1 mb-3">ログイン</button>
                <a href="../regist/" class="btn btn-outline-primary w-100">新規会員登録</a>
            </div>

        </form>
    </main>
</body>

</html>