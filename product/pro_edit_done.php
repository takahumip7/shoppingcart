<?php
session_start();
session_regenerate_id(true);
if (isset($_SESSION['login'])==false) {
    echo 'ログインされていません。'."<br>";
    echo '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
    exit();
}else{
    echo $_SESSION['staff_name'] . "さんログイン中<br>";
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ろくまる農園</title>
</head>

<body>
    <?php

    try {
        require_once('../common/common.php');

        $post = sanitize($_POST);
        $pro_id = $post['id'];
        $pro_name = $post['name'];
        $pro_price = $post['price'];
        $pro_gazou_name_old = $post['gazou_name_old'];
        $pro_gazou_name = $post['gazou_name'];

        // 接続するデータベースの情報
        $dsn = 'mysql:dbname=shop; host=localhost';
        $user = 'root';
        $password = 'root';

        // データベースに接続開始
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //登録
        $sql = 'UPDATE mst_product SET NAME=?,PRICE=?,GAZOU=? WHERE ID=?';
        $stmt = $pdo->prepare($sql);
        $data[] = $pro_name;
        $data[] = $pro_price;
        $data[] = $pro_gazou_name;
        $data[] = $pro_id;
        $stmt->execute($data);

        $pdo = null;

        if ($pro_gazou_name_old != $pro_gazou_name) {

            if ($pro_gazou_name_old != '') {
                unlink('./gazou/' . $pro_gazou_name_old);
            }
        }

        echo '修正しました。<br>';
    } catch (Exception $e) {
        echo "ただいま障害により大変ご迷惑をおかけしております。";
        exit;
    }

    ?>

    <a href="pro_list.php">戻る</a>

</body>

</html>