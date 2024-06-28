<?php
/*!
@file item-image-list.php
@brief 商品画像リストを表示するページ
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
        global $product_details;

        // データベース接続を試みる 
        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($mysqli->connect_error) {
            die("データベース接続失敗: " . $mysqli->connect_error);
        }

        // productsテーブルとdetailsテーブルを結合してデータを取得するクエリ
        $query = "
            SELECT p.product_id, p.product_name, p.product_exp, p.product_price, b.bland_name, g.genre_name, s.season_name, c.category_name, col.color_name
            FROM products p
            JOIN blands b ON p.bland_id = b.bland_id
            JOIN genres g ON p.genre_id = g.genre_id
            JOIN seasons s ON p.season_id = s.season_id
            JOIN categorys c ON p.category_id = c.category_id
            JOIN details d ON p.product_id = d.product_id
            JOIN colors col ON d.color_id = col.color_id
            GROUP BY p.product_id, p.product_name, p.product_exp, p.product_price, b.bland_name, g.genre_name, s.season_name, c.category_name, col.color_name
            ORDER BY p.product_id
        ";

        $result = $mysqli->query($query);

        $product_details = array();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $product_details[] = $row;
            }
        } else {
            echo "クエリ実行エラー: " . $mysqli->error . "<br>";
        }

        $mysqli->close();
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
        global $product_details;
?>
        <!-- コンテンツ　-->
        <div class="contents">
            <h1>商品画像リスト</h1>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>商品ID</th>
                        <th>商品名</th>
                        <th>説明</th>
                        <th>単価</th>
                        <th>ブランド</th>
                        <th>ジャンル</th>
                        <th>季節</th>
                        <th>カテゴリー</th>
                        <th>色</th>
                        <th>画像を追加</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($product_details as $detail) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($detail['product_id']); ?></td>
                            <td><?php echo htmlspecialchars($detail['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($detail['product_exp']); ?></td>
                            <td><?php echo htmlspecialchars($detail['product_price']); ?></td>
                            <td><?php echo htmlspecialchars($detail['bland_name']); ?></td>
                            <td><?php echo htmlspecialchars($detail['genre_name']); ?></td>
                            <td><?php echo htmlspecialchars($detail['season_name']); ?></td>
                            <td><?php echo htmlspecialchars($detail['category_name']); ?></td>
                            <td><?php echo htmlspecialchars($detail['color_name']); ?></td>
                            <td>
                                <form method="post" action="item-image-add.php">
                                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($detail['product_id']); ?>">
                                    <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($detail['product_name']); ?>">
                                    <input type="hidden" name="product_exp" value="<?php echo htmlspecialchars($detail['product_exp']); ?>">
                                    <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($detail['product_price']); ?>">
                                    <input type="hidden" name="bland_name" value="<?php echo htmlspecialchars($detail['bland_name']); ?>">
                                    <input type="hidden" name="genre_name" value="<?php echo htmlspecialchars($detail['genre_name']); ?>">
                                    <input type="hidden" name="season_name" value="<?php echo htmlspecialchars($detail['season_name']); ?>">
                                    <input type="hidden" name="category_name" value="<?php echo htmlspecialchars($detail['category_name']); ?>">
                                    <input type="hidden" name="color_name" value="<?php echo htmlspecialchars($detail['color_name']); ?>">
                                    <button type="submit" onclick="window.location.href='item-image-add.php'" class="btn btn-primary">画像を追加</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
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
