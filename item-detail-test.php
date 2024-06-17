<link rel="stylesheet" href="css/item-detail.css">
<?php
/*!
@file hinagata.php
@brief ページ作成の雛形ファイル
@copyright Copyright (c) 2024 Yamanoi Yasushi.
*/

//ライブラリをインクルード
require_once("common/libs.php");

$err_array = array();
$err_flag = 0;
$page_obj = null;

//--------------------------------------------------------------------------------------
/// 本体ノード
//--------------------------------------------------------------------------------------
class cmain_node extends cnode {
    private $product = array(); // プロパティとして商品情報を保存する配列
    private $colors = array();  // プロパティとして色情報を保存する配列
    private $sizes = array();   // プロパティとしてサイズ情報を保存する配列

    //--------------------------------------------------------------------------------------
    /*!
    @brief コンストラクタ
    */
    //--------------------------------------------------------------------------------------
    public function __construct() {
        // 親クラスのコンストラクタを呼ぶ
        parent::__construct();
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief 本体実行（表示前処理）
    @return なし
    */
    //--------------------------------------------------------------------------------------
    public function execute(){
        global $mysqli;

        $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

        // GET パラメータから商品 ID を取得
        $product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($product_id > 0) {
            // クエリを実行して結果を取得
            $query = "SELECT product_name, product_price, product_exp,bland_id FROM products WHERE product_id = ?";
            $stmt = $mysqli->prepare($query);
            if ($stmt === false) {
                die("クエリの準備に失敗しました: " . $mysqli->error);
            }
            $stmt->bind_param('i', $product_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // 取得した商品情報をプロパティに保存
            if ($row = $result->fetch_assoc()) {
                $this->product = $row;
            }
                            // 商品情報からブランドIDを取得
                            $bland_id = $row['bland_id'];

                            // ブランド名を取得するクエリを準備
                            $query_brand = "SELECT bland_name FROM blands WHERE bland_id = ?";
                            $stmt_brand = $mysqli->prepare($query_brand);
                            $stmt_brand->bind_param('i', $bland_id);
                            $stmt_brand->execute();
                            $result_brand = $stmt_brand->get_result();

                                            // ブランド名を取得
                if ($row_brand = $result_brand->fetch_assoc()) {
                  $this->bland_name = $row_brand['bland_name'];
              }

            // 結果セットを閉じる
            $stmt->close();

            // 色情報を取得するクエリ
            $query_colors = "SELECT DISTINCT c.color_id, c.color_name 
                             FROM details d
                             JOIN colors c ON d.color_id = c.color_id
                             WHERE d.product_id = ?";
            $stmt = $mysqli->prepare($query_colors);
            if ($stmt === false) {
                die("クエリの準備に失敗しました: " . $mysqli->error);
            }
            $stmt->bind_param('i', $product_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // 取得した色情報をプロパティに保存
            while ($row = $result->fetch_assoc()) {
                $this->colors[] = array(
                    'color_id' => $row['color_id'],
                    'color_name' => $row['color_name']
                );
            }

            // 結果セットを閉じる
            $stmt->close();

            // サイズ情報を取得するクエリ
            $query_sizes = "SELECT DISTINCT s.size_id, s.size_name 
                             FROM details d
                             JOIN sizes s ON d.size_id = s.size_id
                             WHERE d.product_id = ?";
            $stmt = $mysqli->prepare($query_sizes);
            if ($stmt === false) {
                die("クエリの準備に失敗しました: " . $mysqli->error);
            }
            $stmt->bind_param('i', $product_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // 取得したサイズ情報をプロパティに保存
            while ($row = $result->fetch_assoc()) {
                $this->sizes[] = array(
                    'size_id' => $row['size_id'],
                    'size_name' => $row['size_name']
                );
            }

            // 結果セットを閉じる
            $stmt->close();
        }

        // データベース接続を閉じる
        $mysqli->close();
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief 構築時の処理(継承して使用)
    @return なし
    */
    //--------------------------------------------------------------------------------------
    public function create(){
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief 表示(継承して使用)
    @return なし
    */
    //--------------------------------------------------------------------------------------
    public function display(){
        if (empty($this->product)) {
            echo "<p>商品が見つかりませんでした。</p>";
            return;
        }

        $product_bland = htmlspecialchars($this->product['product_name'], ENT_QUOTES, 'UTF-8');
        $product_name = htmlspecialchars($this->product['product_name'], ENT_QUOTES, 'UTF-8');
        $product_price = round($this->product['product_price']);
        $product_description = nl2br(htmlspecialchars($this->product['product_exp'], ENT_QUOTES, 'UTF-8'));

// PHPブロック終了
?>
<!-- コンテンツ　-->
<main class="container my-5">
  <div class="row">
    <div class="col-md-6">
      <img src="img/no-image.jpg" id="mainImage" class="product-image img-zone" alt="商品画像">
      <div class="mt-3 img-zone">
        <img src="img/no-image.jpg" class="img-thumbnail thumb-image" alt="商品画像サムネイル1">
        <img src="img/jiji.jpg" class="img-thumbnail thumb-image" alt="商品画像サムネイル2">
        <img src="img/baba.png" class="img-thumbnail thumb-image" alt="商品画像サムネイル3">
        <img src="img/abe.jpg" class="img-thumbnail thumb-image" alt="商品画像サムネイル4">
      </div>
    </div>
    <div class="col-md-6">
    <p class="h6 brand-name text-danger"><?php echo $this->bland_name;?></p>
      <h1 class="product-name"><?php echo $product_name; ?></h1>
      <p class="h4 text-danger product-price">¥<?php echo $product_price; ?></p>

      <!-- 商品の色選択 -->
      <div class="mb-3">
        <label for="colorSelect" class="form-label">色:</label>
        <select class="form-select" id="colorSelect">
          <option selected>色を選択してください</option>
          <?php foreach ($this->colors as $color): ?>
            <option value="<?php echo htmlspecialchars($color['color_id'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($color['color_name'], ENT_QUOTES, 'UTF-8'); ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- 商品のサイズ選択 -->
      <div class="mb-3">
        <label for="sizeSelect" class="form-label">サイズ:</label>
        <select class="form-select" id="sizeSelect">
          <option selected>サイズを選択してください</option>
          <?php foreach ($this->sizes as $size): ?>
            <option value="<?php echo htmlspecialchars($size['size_id'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($size['size_name'], ENT_QUOTES, 'UTF-8'); ?></option>
          <?php endforeach; ?>
        </select>
      </div>  

      <button class="btn btn-primary btn-lg add-to-cart-button" onclick="location.href='kart.php'"><i class="bi bi-cart-plus"></i> カートに追加</button>
      <button id="favoriteButton" class="favorite-button align-middle" onclick="toggleFavorite(event, this)">★</button>
      <p class="product-description"><?php echo $product_description; ?></p>
    </div>
  </div>
</main>
<!-- /コンテンツ　-->
<?php 
// PHPブロック再開
    }

    //--------------------------------------------------------------------------------------
    /*!
    @brief デストラクタ
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

<script src="js/item-detail.js"></script>
