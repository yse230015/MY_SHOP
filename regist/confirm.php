<?php
// env.php を読み込み
require_once '../env.php';

// lib/DB.php を読み込み
require_once '../lib/DB.php';

// POSTリクエストでなければ何も表示しない
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit;
}

// セッション開始
session_start();
// セッションハイジャック対策
session_regenerate_id(true);

// セッションにPOSTデータを登録
$_SESSION['my_shop']['regist'] = $_POST;

// POSTデータ受信（サニタイズ）
$post = sanitize($_POST);

//バリデーション（データチェック）
if (isset($_SESSION['my_shop']['errors'])) {
    unset($_SESSION['my_shop']['errors']);
}
$errors = validate($post);

// Email重複チェック
// usersテーブルに指定のEmailアドレスがあるかどうか検索SQL
$sql = "SELECT * FROM users WHERE email = '{$post['email']}';";

// データベースに接続
$db = new DB();
$stmt = $db->pdo->prepare($sql);
$stmt->execute();

// データ取得
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if ($user) $errors['email'] = "Emailは既に登録されています";


if ($errors) {
    $_SESSION['my_shop']['errors'] = $errors;
    header('Location: input.php');
    exit;
}

/**
 * サニタイズ
 */
function sanitize($array)
{
    if (!is_array($array)) return [];
    foreach ($array as $key => $value) {
        $array[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
    return $array;
}


function validate($posts)
{
    // Validation
    $errors = [];
    if (empty($posts['name'])) {
        $errors['name'] = '名前を入力してください';
    }
    if (empty($posts['email'])) {
        $errors['email'] = 'メールアドレスを入力してください';
    }

    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]{6,12}$/';
    if (empty($posts['password'])) {
        $errors['password'] = 'パスワードを入力してください';
    } elseif (!preg_match($pattern, $posts['password'])) {
        //$errors['password'] = 'パスワードは6文字以上12文字以内の半角英数で入力してください。（大文字、文字含む）';
    }
    return $errors;
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
    <main class="m-auto w-50">
        <h2 class="p-2 text-center">会員登録確認</h2>
        <form action="add.php" method="post">
            <div class="form-group mt-3">
                <label class="form-label" for="">氏名</label>
                <p><?= $post["name"] ?></p>
            </div>

            <div class="form-group mt-3">
                <label class="form-label" for="">Email</label>
                <p><?= $post["email"] ?></p>
            </div>

            <div class="d-flex mt-3">
                <button class="btn btn-primary w-50 me-1">登録</button>
                <a href="./input.php" class="btn btn-outline-primary w-50">戻る</a>
            </div>
        </form>
    </main>
</body>

</html>