<?php
//--------------------------------------------------------------------------------------
/*!
@brief	本体実行（表示前処理）
@return	なし
*/
//--------------------------------------------------------------------------------------
class Test{
public function execute(){

// データベース接続を試みる 
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($mysqli->connect_error) {
    die("データベース接続失敗: " . $mysqli->connect_error);
} else {
    echo "データベース接続成功<br>";
}

// blandsテーブルからbland_idが1のbrand_nameを取得するクエリを実行
$query = "SELECT product_name FROM products WHERE product_id = 1";
$result = $mysqli->query($query);

if ($result) {
    if ($row = $result->fetch_assoc()) {
        $brand_name = $row['product_name'];
        echo "プロダクト名: " . htmlspecialchars($brand_name) . "<br>";
    } else {
        echo "データが見つかりません<br>";
    }
} else {
    echo "クエリ実行エラー: " . $mysqli->error . "<br>";
}


    // データベースから情報を取得するクエリを作成
    $sql = "SELECT * FROM products";

    // 取得した情報をテーブル形式で表示
    if ($result->num_rows > 0) {
        // データがある場合はテーブルを表示
        echo "<table border='1'>";
        echo "<tr><th>商品No.</th><th>商品名</th><th>担当者</th><th>日時</th><th>操作</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["product_id"]. "</td>";
            echo "<td>" . $row["product_name"]. "</td>";
            echo "<td>" . $row["product_exp"]. "</td>";
            echo "<td>" . $row["product_price"]. "</td>";
            echo "<td><button type='button' onclick='window.location.href=\"#\"' class='btn btn-outline-success'>未実装</button></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        // データがない場合はメッセージを表示
        echo "0件の結果";
    }
    
    // データベース接続を閉じる
    $mysqli->close();
}
}
?>