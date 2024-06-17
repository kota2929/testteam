<link rel="stylesheet" href="css/item-home.css">
<?php
/*!
@file hinagata.php
@brief ページ作成の雛形ファイル
@copyright Copyright (c) 2024 Yamanoi Yasushi.
*/

// ライブラリをインクルード
require_once("common/libs.php");

session_start(); // セッション開始

$err_array = array();
$err_flag = 0;
$page_obj = null;

//--------------------------------------------------------------------------------------
///	本体ノード
//--------------------------------------------------------------------------------------
class cmain_node extends cnode {
    private $products = array(); // プロパティとして商品情報を保存する配列
    private $details_products = array(); // 新たに追加：結合クエリの結果を保存する配列

    //--------------------------------------------------------------------------------------
    /*!
    @brief	コンストラクタ
    */
    //--------------------------------------------------------------------------------------
    public function __construct() {
        // 親クラスのコンストラクタを呼ぶ
        parent::__construct();
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief  本体実行（表示前処理）
    @return なし
    */
    //--------------------------------------------------------------------------------------
    public function execute(){
        global $mysqli;

        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // クエリを実行して結果を取得
        $query = "SELECT product_id, product_name, product_price FROM products";
        $result = $mysqli->query($query);

        // 取得した商品情報をプロパティに保存
        while ($row = $result->fetch_assoc()) {
            $this->products[] = $row;
        }

        // 結果セットを閉じる
        $result->close();

        // 結合クエリを実行して結果を取得
        $details_query = "
            SELECT DISTINCT
                details.product_id,
                products.product_name,
                products.product_exp,
                products.product_price,
                products.bland_id,
                products.genre_id,
                details.color_id,
                products.category_id,
            FROM
                details
            INNER JOIN
                products ON details.product_id = products.product_id;
        ";
        $details_result = $mysqli->query($details_query);

        // 取得した結合クエリの結果をプロパティに保存
        while ($row = $details_result->fetch_assoc()) {
            $this->details_products[] = $row;
        }

        // 結果セットを閉じる
        $details_result->close();

        // データベース接続を閉じる
        $mysqli->close();
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief	構築時の処理(継承して使用)
    @return	なし
    */
    //--------------------------------------------------------------------------------------
    public function create(){
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief  表示(継承して使用)
    @return なし
    */
    //--------------------------------------------------------------------------------------
    public function display(){
        ?>
        <!-- コンテンツ -->
        <main class="container">
          <section>
            <nav class="custom-nav">
              <ul>
                <li><a href="#">Genre</a>
                  <ul>
                    <li><a href="#">きれいめ</a></li>
                    <li><a href="#">カジュアル</a></li>
                    <li><a href="#">ストリート</a></li>
                    <li><a href="#">モード系</a></li>
                  </ul>
                </li>
                <li><a href="#">Season</a>
                  <ul>
                    <li><a href="#">春</a></li>
                    <li><a href="#">夏</a></li>
                    <li><a href="#">秋</a></li>
                    <li><a href="#">冬</a></li>
                    <li><a href="#">オールシーズン</a></li>
                  </ul>
                </li>
                <li><a href="#">Color</a>
                  <ul>
                    <li><a href="#">ブラック</a></li>
                    <li><a href="#">ホワイト</a></li>
                    <li><a href="#">レッド</a></li>
                    <li><a href="#">ブルー</a></li>
                    <li><a href="#">グリーン</a></li>
                    <li><a href="#">イエロー</a></li>
                    <li><a href="#">パープル</a></li>
                    <li><a href="#">ピンク</a></li>
                    <li><a href="#">ブラウン</a></li>
                  </ul>
                </li>
                <li><a href="#">Category</a>
                  <ul>
                    <li><a href="#">トップス</a></li>
                    <li><a href="#">ジャケット・アウター</a></li>
                    <li><a href="#">ボトムス</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </section>

          <div class="product-card-container row">
        <?php
          // 商品情報を表示
          foreach ($this->products as $product) {
            $product_name = $product['product_name'];
            $product_price = round($product['product_price']);
            $product_id = $product['product_id']; // 商品IDを取得

            // 商品カードのHTMLを出力
            echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">';
            echo '<div class="card-container">';
            echo '<div class="card">';
            echo '<a href="item-detail.php?id=' . $product_id . '" class="card-link">'; // 商品詳細ページへのリンクを追加
            echo '<img src="img/no-image.jpg" alt="' . $product_name . '" class="card-img">';
            echo '<div class="card-content">';
            echo '<h3 class="card-title">' . $product_name . '</h3>';
            echo '<div class="card-info">';
            echo '<p class="card-price">¥' . $product_price . '</p>';
            echo '<button class="favorite-button" onclick="toggleFavorite(event, this)">★</button>';
            echo '</div></div></a></div></div></div>';
          }
        ?>
        </div>

        <!-- 結合クエリの結果をカード形式で表示 -->
        <div class="product-card-container row">
        <?php
          // 商品詳細情報を表示
          foreach ($this->details_products as $details_product) {
            $product_id = $details_product['product_id'];
            $product_name = $details_product['product_name'];
            $product_price = round($details_product['product_price']);
            $bland_id = $details_product['bland_id'];
            $genre_id = $details_product['genre_id'];
            $color_id = $details_product['color_id'];
            $category_id = $details_product['category_id'];

            // 商品カードのHTMLを出力
            echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">';
            echo '<div class="card-container">';
            echo '<div class="card">';
            echo '<a href="item-detail.php?id=' . $product_id . '" class="card-link">'; // 商品詳細ページへのリンクを追加
            echo '<img src="img/no-image.jpg" alt="' . $product_name . '" class="card-img">';
            echo '<div class="card-content">';
            echo '<h3 class="card-title">' . $product_name . '</h3>';
            echo '<div class="card-info">';
            echo '<p class="card-price">¥' . $product_price . '</p>';
            echo '<p class="card-bland">ブランドID: ' . $bland_id . '</p>';
            echo '<p class="card-genre">ジャンルID: ' . $genre_id . '</p>';
            echo '<p class="card-color">カラーID: ' . $color_id . '</p>';
            echo '<p class="card-color">カテゴリーID: ' . $category_id . '</p>';
            echo '<button class="favorite-button" onclick="toggleFavorite(event, this)">★</button>';
            echo '</div></div></a></div></div></div>';
          }
        ?>
        </div>
        </main>
        <?php
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief	デストラクタ
    */
    //--------------------------------------------------------------------------------------
    public function __destruct(){
        // 親クラスのデストラクタを呼ぶ
        parent::__destruct();
    }
}

// ページを作成
$page_obj = new cnode();
// ヘッダ追加
$page_obj->add_child(cutil::create('cheader'));
// 本体追加
$page_obj->add_child($main_obj = cutil::create('cmain_node'));
// フッタ追加
$page_obj->add_child(cutil::create('cfooter'));
// 構築時処理
$page_obj->create();
// 本体実行（表示前処理）
$main_obj->execute();
// ページ全体を表示
$page_obj->display();
?>
