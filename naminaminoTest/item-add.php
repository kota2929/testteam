<?php
/*!
@file hinagata.php
@brief ページ作成の雛形ファイル
@copyright Copyright (c) 2024 Yamanoi Yasushi.
*/

//ライブラリをインクルード
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
        global $mysqli, $brand_data, $genre_data, $season_data, $category_data, $color_data, $size_data;

        // データベース接続を試みる 
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_error) {
            die("データベース接続失敗: " . $mysqli->connect_error);
        }

        // フォームが送信された場合の処理
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // 入力データを取得、登録する項目を用意。
            $product_name = $mysqli->real_escape_string($_POST['product_name']);
            $product_exp = $mysqli->real_escape_string($_POST['product_exp']);
            $genre_id = intval($_POST['genre_id']);
            $season_id = intval($_POST['season_id']);
            $price = floatval($_POST['product_price']);
            $brand_id = intval($_POST['brand_id']);
            $category_id = intval($_POST['category_id']);
            $color_ids = isset($_POST['color_ids']) ? $_POST['color_ids'] : [];
            $size_ids = isset($_POST['size_ids']) ? $_POST['size_ids'] : [];
            $product_stock = isset($_POST['product_stock']) ? intval($_POST['product_stock']) : 0; // ここでproduct_stockの値をチェック

            // INSERTクエリを準備。クエリ実行でDB登録が完了する。
            $insert_query = "INSERT INTO products (product_name, product_exp, genre_id, season_id, product_price, bland_id, category_id) VALUES ('$product_name', '$product_exp', $genre_id, $season_id, $price, $brand_id, $category_id)";

            // クエリを実行して成功したか否か
            if ($mysqli->query($insert_query)) {
                echo "商品を登録しました。<br>";

                // 直近の挿入で生成されたproduct_idを取得
                $product_id = $mysqli->insert_id;

                // 選択された色とサイズに対してdetailsテーブルに情報を追加
                foreach ($color_ids as $color_id) {
                    foreach ($size_ids as $size_id) {
                        $detail_insert_query = "INSERT INTO details (color_id, size_id, product_id) VALUES ($color_id, $size_id, $product_id)";
                        if ($mysqli->query($detail_insert_query)) {
                            $detail_id = $mysqli->insert_id;
                            // Stacksテーブルに在庫数を追加
                            $stack_insert_query = "INSERT INTO stacks (product_detail_id, product_stock) VALUES ($detail_id, $product_stock)";
                            if (!$mysqli->query($stack_insert_query)) {
                                echo "Stacksテーブルへの挿入エラー: " . $mysqli->error . "<br>";
                            }
                        } else {
                            echo "detailsテーブルへの挿入エラー: " . $mysqli->error . "<br>";
                        }
                    }
                }
            } else {
                echo "エラー: " . $mysqli->error . "<br>";
            }
        }

        // 各テーブルのデータを取得するクエリを実行。
        $brand_data = $this->get_table_data($mysqli, "blands", "bland_id", "bland_name");
        $genre_data = $this->get_table_data($mysqli, "genres", "genre_id", "genre_name");
        $season_data = $this->get_table_data($mysqli, "seasons", "season_id", "season_name");
        $category_data = $this->get_table_data($mysqli, "categorys", "category_id", "category_name");
        $color_data = $this->get_table_data($mysqli, "colors", "color_id", "color_name");
        $size_data = $this->get_table_data($mysqli, "sizes", "size_id", "size_name");

        $mysqli->close();
    }

    // テーブルからデータを取得する関数
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
    @brief 表示(継承して使用)
    @return なし
    */
    //--------------------------------------------------------------------------------------
    public function display()
    {
        global $brand_data, $genre_data, $season_data, $category_data, $color_data, $size_data;
?>
        <!-- コンテンツ　-->
        <div class="contents">
            <main class="container mt-4">
                <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
                <link rel="stylesheet" href="mng.css">
                <!-- 独自のスタイルシートを後にリンク -->

                <!--pageタイトル-->
                <h1>商品の追加</h1>
                <br>
                <!--商品登録フォーム-->
                <form method="post" action="">
                    <div class="center">
                        <label>商品名</label><br>
                        <input name="product_name" size="30" required><br><br>

                        <label>商品の説明</label><br>
                        <input name="product_exp" size="30" required><br><br>

                        <label>ジャンル</label><br>
                        <select name="genre_id" required>
                            <option value="">　</option>
                            <?php foreach ($genre_data as $genre) : ?>
                                <option value="<?php echo htmlspecialchars($genre['genre_id']); ?>"><?php echo htmlspecialchars($genre['genre_name']); ?></option>
                            <?php endforeach; ?>
                        </select><br><br>

                        <label>季節</label><br>
                        <select name="season_id" required>
                            <option value="">　</option>
                            <?php foreach ($season_data as $season) : ?>
                                <option value="<?php echo htmlspecialchars($season['season_id']); ?>"><?php echo htmlspecialchars($season['season_name']); ?></option>
                            <?php endforeach; ?>
                        </select><br><br>

                        <label>単価</label><br>
                        <input name="product_price" type="number" step="0.01" size="30" required><br><br>

                        <label>ブランド</label><br>
                        <select name="brand_id" required>
                            <option value="">　</option>
                            <?php foreach ($brand_data as $brand) : ?>
                                <option value="<?php echo htmlspecialchars($brand['bland_id']); ?>"><?php echo htmlspecialchars($brand['bland_name']); ?></option>
                            <?php endforeach; ?>
                        </select><br><br>

                        <label>カテゴリー</label><br>
                        <select name="category_id" required>
                            <option value="">　</option>
                            <?php foreach ($category_data as $category) : ?>
                                <option value="<?php echo htmlspecialchars($category['category_id']); ?>"><?php echo htmlspecialchars($category['category_name']); ?></option>
                            <?php endforeach; ?>
                        </select><br><br>

                        <label>色</label><br>
                        <div class="form-check form-check-inline">
                            <?php foreach ($color_data as $color) : ?>
                                <input type="checkbox" class="form-check-input" name="color_ids[]" value="<?php echo htmlspecialchars($color['color_id']); ?>">
                                <label class="form-check-label"><?php echo htmlspecialchars($color['color_name']); ?></label>
                            <?php endforeach; ?>
                        </div><br><br>

                        <label>サイズ</label><br>
                        <div class="form-check form-check-inline">
                            <?php foreach ($size_data as $size) : ?>
                                <input type="checkbox" class="form-check-input" name="size_ids[]" value="<?php echo htmlspecialchars($size['size_id']); ?>">
                                <label class="form-check-label"><?php echo htmlspecialchars($size['size_name']); ?></label>
                            <?php endforeach; ?>
                        </div><br><br>

                        <label>在庫数</label><br>
                        <input name="product_stock" type="number" size="30" required><br><br>

                        <button type="submit" class="btn btn-outline-success">商品を登録</button>
                    </div>
                    <br><br>
                </form>
            </main>
        </div>
        <!-- /コンテンツ　-->
<?php
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
