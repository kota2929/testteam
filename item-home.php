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
        $query = "SELECT product_name, product_price FROM products";
        $result = $mysqli->query($query);

        // 取得した商品情報をプロパティに保存
        while ($row = $result->fetch_assoc()) {
            $this->products[] = $row;
        }

        // 結果セットを閉じる
        $result->close();

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
                  </ul>
                </li>
                <li><a href="#">Season</a>
                  <ul>
                    <li><a href="#">春</a></li>
                    <li><a href="#">夏</a></li>
                    <li><a href="#">秋</a></li>
                    <li><a href="#">冬</a></li>
                  </ul>
                </li>
                <li><a href="#">Color</a>
                  <ul>
                    <li><a href="#">白</a></li>
                    <li><a href="#">黒</a></li>
                    <li><a href="#">グレー</a></li>
                    <li><a href="#">緑</a></li>
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
            $product_price = $product['product_price'];

            // 商品カードのHTMLを出力
            echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">';
            echo '<div class="card-container">';
            echo '<div class="card">';
            echo '<a href="item-detatil.php" class="card-link">';
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
