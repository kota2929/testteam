<?php
/*!
@file edit_product.php
@brief 商品情報編集ページ
@copyright Copyright (c) 2024 Yamanoi Yasushi.
*/

// ライブラリをインクルード
require_once("../common/libs.php");

// 初期化
$product_data = null;

// 商品IDが指定されているか確認
if (isset($_GET['product_id'])) {
    $product_id = intval($_GET['product_id']);

    // データベース接続を試みる 
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_error) {
        die("データベース接続失敗: " . $mysqli->connect_error);
    }

    // 商品情報を取得するクエリを実行
    $query = "SELECT * FROM products WHERE product_id = $product_id";
    $result = $mysqli->query($query);
    
    if ($result) {
        // 商品情報を取得
        $product_data = $result->fetch_assoc();
    } else {
        echo "クエリ実行エラー: " . $mysqli->error . "<br>";
    }

    // 各テーブルのデータを取得するクエリを実行
    $brand_data = get_table_data($mysqli, "blands", "bland_id", "bland_name");
    $genre_data = get_table_data($mysqli, "genres", "genre_id", "genre_name");
    $season_data = get_table_data($mysqli, "seasons", "season_id", "season_name");
    $category_data = get_table_data($mysqli, "categorys", "category_id", "category_name");

    $mysqli->close();
} else {
    echo "商品IDが指定されていません。";
    exit;
}

// テーブルからデータを取得する関数
function get_table_data($mysqli, $table, $id_col, $name_col) {
    $query = "SELECT $id_col, $name_col FROM $table";
    $result = $mysqli->query($query);

    $data = array();
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    } else {
        echo "クエリ実行エラー: " . $mysqli->error . "<br>";
    }
    return $data;
}

// 編集が保存された場合の処理
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // データベース接続を再度試みる
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_error) {
        die("データベース接続失敗: " . $mysqli->connect_error);
    }

    // 入力データを取得
    $product_id = intval($_POST['product_id']);
    $product_name = $mysqli->real_escape_string($_POST['product_name']);
    $product_exp = $mysqli->real_escape_string($_POST['product_exp']);
    $genre_id = intval($_POST['genre_id']);
    $season_id = intval($_POST['season_id']);
    $price = floatval($_POST['product_price']);
    $brand_id = intval($_POST['brand_id']);
    $category_id = intval($_POST['category_id']);

    // UPDATEクエリを準備
    $update_query = "UPDATE products SET 
                        product_name = '$product_name', 
                        product_exp = '$product_exp', 
                        genre_id = $genre_id, 
                        season_id = $season_id, 
                        product_price = $price, 
                        bland_id = $brand_id, 
                        category_id = $category_id 
                    WHERE product_id = $product_id";
    
    // クエリを実行して成功したか否か
    if ($mysqli->query($update_query)) {
        echo "商品情報を更新しました。<br>";
    } else {
        echo "エラー: " . $mysqli->error . "<br>";
    }

    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品情報編集</title>
    <link rel="stylesheet" href="mng.css"> <!-- スタイルシートをリンク -->
    <script src="mng.js" defer></script> <!-- JavaScriptファイルをリンク -->
</head>
<body>
    <!-- コンテンツ -->
    <div class="contents">
        <main class="container mt-4">
            <!-- ページタイトル -->
            <h1>商品情報編集</h1>
            <br>

            <!-- 商品編集フォーム -->
            <?php if ($product_data): ?>
                <form method="post" action="">
                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_data['product_id']); ?>">

                    <label>商品名</label><br>
                    <input name="product_name" size="30" value="<?php echo htmlspecialchars($product_data['product_name']); ?>" required><br><br>

                    <label>商品の説明</label><br>
                    <input name="product_exp" size="30" value="<?php echo htmlspecialchars($product_data['product_exp']); ?>" required><br><br>

                    <label>ジャンル</label><br>
                    <select name="genre_id" required>
                        <option value="">　</option>
                        <?php foreach ($genre_data as $genre): ?>
                            <option value="<?php echo htmlspecialchars($genre['genre_id']); ?>" <?php echo ($product_data['genre_id'] == $genre['genre_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($genre['genre_name']); ?></option>
                        <?php endforeach; ?>
                    </select><br><br>

                    <label>季節</label><br>
                    <select name="season_id" required>
                        <option value="">　</option>
                        <?php foreach ($season_data as $season): ?>
                            <option value="<?php echo htmlspecialchars($season['season_id']); ?>" <?php echo ($product_data['season_id'] == $season['season_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($season['season_name']); ?></option>
                        <?php endforeach; ?>
                    </select><br><br>

                    <label>単価</label><br>
                    <input name="product_price" type="number" step="0.01" size="30" value="<?php echo htmlspecialchars($product_data['product_price']); ?>" required><br><br>

                    <label>ブランド</label><br>
                    <select name="brand_id" required>
                        <option value="">　</option>
                        <?php foreach ($brand_data as $brand): ?>
                            <option value="<?php echo htmlspecialchars($brand['bland_id']); ?>" <?php echo ($product_data['bland_id'] == $brand['bland_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($brand['bland_name']); ?></option>
                        <?php endforeach; ?>
                    </select><br><br>

                    <label>カテゴリー</label><br>
                    <select name="category_id" required>
                        <option value="">　</option>
                        <?php foreach ($category_data as $category): ?>
                            <option value="<?php echo htmlspecialchars($category['category_id']); ?>" <?php echo ($product_data['category_id'] == $category['category_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($category['category_name']); ?></option>
                        <?php endforeach; ?>
                    </select><br><br>

                    <br>
                    <button type="submit" class="btn btn-outline-success">商品情報を更新</button>
                    <br><br>
                    <p><button class="btn btn-outline-success" onclick="history.back(); return false;">戻る</button></p>
                    <br><br>
                </form>
            <?php else: ?>
                <p>商品が見つかりません。</p>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>
