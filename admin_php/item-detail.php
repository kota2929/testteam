<?php
/*!
@file hinagata.php
@brief ページ作成の雛形ファイル
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
        // 削除処理を実行
        $this->delete();
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
    @brief 商品削除用のスクリプト
    */
    //--------------------------------------------------------------------------------------
    public function delete()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["product_id"])) {
            $product_id = intval($_POST["product_id"]);
        
            // データベース接続を試みる 
            $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
            if ($mysqli->connect_error) {
                die("データベース接続失敗: " . $mysqli->connect_error);
            }
        
            // DBのproductsテーブルから該当の商品を削除するクエリを実行
            $sql = "DELETE FROM products WHERE product_id = ?";
            $stmt = $mysqli->prepare($sql);
            $stmt->bind_param("i", $product_id);
        
            if ($stmt->execute()) {
                echo "商品ID " . htmlspecialchars($product_id) . " を削除しました。";
            } else {
                echo "エラーが発生しました: " . $stmt->error;
            }
        
            // データベース接続を閉じる
            $stmt->close();
            $mysqli->close();
            
            // POSTリクエストの後にリダイレクトする（ページリロード）
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief 商品情報の取得
    @return array 商品情報の配列
    */
    //--------------------------------------------------------------------------------------
    public function get_products()
    {
        // データベース接続を試みる 
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        if ($mysqli->connect_error) {
            die("データベース接続失敗: " . $mysqli->connect_error);
        }

        // productsテーブルから全ての情報を取得するクエリを実行
        $sql = "SELECT products.product_id, products.product_name, products.product_exp, products.product_price, 
                       genres.genre_name, seasons.season_name, blands.bland_name, categorys.category_name 
                FROM products
                JOIN genres ON products.genre_id = genres.genre_id
                JOIN seasons ON products.season_id = seasons.season_id
                JOIN blands ON products.bland_id = blands.bland_id
                JOIN categorys ON products.category_id = categorys.category_id";

        $result = $mysqli->query($sql);

        if (!$result) {
            die("クエリ実行エラー: " . $mysqli->error);
        }

        $products = $result->fetch_all(MYSQLI_ASSOC);

        // データベース接続を閉じる
        $mysqli->close();

        return $products;
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief 表示(継承して使用)
    @return なし
    */
    //--------------------------------------------------------------------------------------
    public function display()
    {
        //商品情報を取得
        $products = $this->get_products();
        //PHPブロック終了
        ?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品の削除</title>
    <link rel="stylesheet" href="mng.css"> <!-- スタイルシートをリンク -->
    <script src="mng.js" defer></script> <!-- JavaScriptファイルをリンク -->
</head>
<body>
    <!-- コンテンツ　-->
    <div class="contents">
        <main class="container mt-4">
            <!--pageタイトル-->
            <h1>商品の一覧</h1>
            <br><br>
            <div class="center">
                <?php if (count($products) > 0): ?>
                    <table border='1' id='productTable'>
                        <tr>
                            <th>商品ID</th>
                            <th>商品名</th>
                            <th>説明</th>
                            <th>値段</th>
                            <th>ジャンル</th>
                            <th>季節</th>
                            <th>ブランド</th>
                            <th>カテゴリー</th>
                            <th>編集・削除</th>
                        </tr>
                        <?php foreach ($products as $product): ?>
                            <tr id='row_<?php echo htmlspecialchars($product["product_id"]); ?>'>
                                <td><?php echo htmlspecialchars($product["product_id"]); ?></td>
                                <td><?php echo htmlspecialchars($product["product_name"]); ?></td>
                                <td><?php echo htmlspecialchars($product["product_exp"]); ?></td>
                                <td><?php echo htmlspecialchars($product["product_price"]); ?></td>
                                <td><?php echo htmlspecialchars($product["genre_name"]); ?></td>
                                <td><?php echo htmlspecialchars($product["season_name"]); ?></td>
                                <td><?php echo htmlspecialchars($product["bland_name"]); ?></td>
                                <td><?php echo htmlspecialchars($product["category_name"]); ?></td>
                                <td>
                                    <button type='button' onclick="window.location.href='item-edit-delete.php?product_id=<?php echo htmlspecialchars($product['product_id']); ?>'" class='btn btn-outline-success'>編集・削除</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php else: ?>
                    <p>0件の結果</p>
                <?php endif; ?>
                <br><br>
                <p><a href="#" class="btn btn-outline-success" onclick="history.back(); return false;">戻る</a></p>
            </div>
            <br><br>
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
