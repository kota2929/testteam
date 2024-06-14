<?php
/*!
@file item-edit-delete.php
@brief 商品情報編集ページ
*/

// ライブラリをインクルード
require_once("../common/libs.php");

$err_array = array();
$err_flag = 0;
$page_obj = null;

//--------------------------------------------------------------------------------------
/// 本体ノード
//--------------------------------------------------------------------------------------
class cmain_node extends cnode
{
    //--------------------------------------------------------------------------------------
    /*!
    @brief コンストラクタ
    */
    //--------------------------------------------------------------------------------------
    public function __construct()
    {
        //親クラスのコンストラクタを呼ぶ
        parent::__construct();
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief 本体実行（表示前処理）
    @return なし
    */
    //--------------------------------------------------------------------------------------
    public function execute()
    {
        // 更新・削除処理を実行
        $this->update_or_delete();
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief 構築時の処理(継承して使用)
    @return なし
    */
    //--------------------------------------------------------------------------------------
    public function create()
    {
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief 更新または削除処理
    */
    //--------------------------------------------------------------------------------------
    public function update_or_delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
            // データベース接続を試みる 
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($mysqli->connect_error) {
                die("データベース接続失敗: " . $mysqli->connect_error);
            }

            $product_id = intval($_POST['product_id']);
            
            if (isset($_POST['update'])) {
                // 更新処理
                $product_name = $mysqli->real_escape_string($_POST['product_name']);
                $product_exp = $mysqli->real_escape_string($_POST['product_exp']);
                $genre_id = intval($_POST['genre_id']);
                $season_id = intval($_POST['season_id']);
                $price = floatval($_POST['product_price']);
                $brand_id = intval($_POST['brand_id']);
                $category_id = intval($_POST['category_id']);

                $update_query = "UPDATE products SET 
                                    product_name = '$product_name', 
                                    product_exp = '$product_exp', 
                                    genre_id = $genre_id, 
                                    season_id = $season_id, 
                                    product_price = $price, 
                                    bland_id = $brand_id, 
                                    category_id = $category_id 
                                WHERE product_id = $product_id";

                if ($mysqli->query($update_query)) {
                    echo "商品情報を更新しました。<br>";
                } else {
                    echo "エラー: " . $mysqli->error . "<br>";
                }
            } elseif (isset($_POST['delete'])) {
                // 削除処理
                $delete_query = "DELETE FROM products WHERE product_id = $product_id";
                if ($mysqli->query($delete_query)) {
                    echo "商品を削除しました。<br>";
                } else {
                    echo "エラー: " . $mysqli->error . "<br>";
                }
            }

            $mysqli->close();
        }
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief 表示(継承して使用)
    @return なし
    */
    //--------------------------------------------------------------------------------------
    public function display()
    {
        if (!isset($_GET['product_id'])) {
            echo "商品IDが指定されていません。";
            exit;
        }

        $product_id = intval($_GET['product_id']);

        // データベース接続を試みる 
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_error) {
            die("データベース接続失敗: " . $mysqli->connect_error);
        }

        // 商品情報を取得するクエリを実行
        $query = "SELECT * FROM products WHERE product_id = $product_id";
        $result = $mysqli->query($query);

        if (!$result) {
            die("クエリ実行エラー: " . $mysqli->error);
        }

        $product_data = $result->fetch_assoc();

        // 各テーブルのデータを取得する
        $brand_data = $this->get_table_data($mysqli, "blands", "bland_id", "bland_name");
        $genre_data = $this->get_table_data($mysqli, "genres", "genre_id", "genre_name");
        $season_data = $this->get_table_data($mysqli, "seasons", "season_id", "season_name");
        $category_data = $this->get_table_data($mysqli, "categorys", "category_id", "category_name");

        $mysqli->close();

        //PHPブロック終了
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
            <div class="center">
                <?php if ($product_data) : ?>
                    <!-- 更新用フォーム -->
                    <form method="post" action="">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_data['product_id']); ?>">

                        <label>商品名</label><br>
                        <input name="product_name" size="30" value="<?php echo htmlspecialchars($product_data['product_name']); ?>" required><br><br>

                        <label>商品の説明</label><br>
                        <input name="product_exp" size="30" value="<?php echo htmlspecialchars($product_data['product_exp']); ?>" required><br><br>

                        <label>ジャンル</label><br>
                        <select name="genre_id" required>
                            <option value="">　</option>
                            <?php foreach ($genre_data as $genre) : ?>
                                <option value="<?php echo htmlspecialchars($genre['genre_id']); ?>" <?php echo ($product_data['genre_id'] == $genre['genre_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($genre['genre_name']); ?></option>
                            <?php endforeach; ?>
                        </select><br><br>

                        <label>季節</label><br>
                        <select name="season_id" required>
                            <option value="">　</option>
                            <?php foreach ($season_data as $season) : ?>
                                <option value="<?php echo htmlspecialchars($season['season_id']); ?>" <?php echo ($product_data['season_id'] == $season['season_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($season['season_name']); ?></option>
                            <?php endforeach; ?>
                        </select><br><br>

                        <label>単価</label><br>
                        <input name="product_price" type="number" step="0.01" size="30" value="<?php echo htmlspecialchars($product_data['product_price']); ?>" required><br><br>

                        <label>ブランド</label><br>
                        <select name="brand_id" required>
                            <option value="">　</option>
                            <?php foreach ($brand_data as $brand) : ?>
                                <option value="<?php echo htmlspecialchars($brand['bland_id']); ?>" <?php echo ($product_data['bland_id'] == $brand['bland_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($brand['bland_name']); ?></option>
                            <?php endforeach; ?>
                        </select><br><br>

                        <label>カテゴリー</label><br>
                        <select name="category_id" required>
                            <option value="">　</option>
                            <?php foreach ($category_data as $category) : ?>
                                <option value="<?php echo htmlspecialchars($category['category_id']); ?>" <?php echo ($product_data['category_id'] == $category['category_id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($category['category_name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <br><br><br><br>

                        <!--更新用フォーム(上記と同じ)-->
                        <button type="submit" name="update" class="btn btn-outline-success">更新して前ページに戻る</button>
                        <br><br>
                    </form>

                    <!-- 削除用フォーム -->
                    <form method="post" action="">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_data['product_id']); ?>">
                        <button type="submit" name="delete" class="btn btn-outline-danger">商品を削除する</button>
                    </form>
                    <br>

                    <!-- 戻るボタン用フォーム -->
                    <form action='item-detail.php'>
                        <button type="submit" class="btn btn-outline-secondary">商品一覧へ戻る</button>
                    </form>
                    <br><br><br><br>

                <?php else : ?>
                    <p>指定された商品が見つかりませんでした。</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>

<?php
        //PHPブロック再開
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief デストラクタ
    */
    //--------------------------------------------------------------------------------------
    public function __destruct()
    {
        //親クラスのデストラクタを呼ぶ
        parent::__destruct();
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief テーブルからデータを取得する関数
    */
    //--------------------------------------------------------------------------------------
    private function get_table_data($mysqli, $table, $id_col, $name_col)
    {
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
}

//ページを作成
$page_obj = new cnode();
//ヘッダ追加
$page_obj->add_child(cutil::create('cheader'));
//本体追加
$page_obj->add_child($main_obj = cutil::create('cmain_node'));
//フッタ追加
$page_obj->add_child(cutil::create('cfooter'));
//構築時処理
$page_obj->create();
//本体実行（表示前処理）
$main_obj->execute();
//ページ全体を表示
$page_obj->display();

?>
